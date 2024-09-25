<?php
require_once '../Database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_login"]) || $_SESSION["user_login"] !== true) {
    die("Access denied. Please log in.");
}

// Get the logged-in user's email
$email = $_SESSION["login"];

// Fetch user ID based on email
try {
    $select_user_stmt = $pdo->prepare("SELECT ID FROM users WHERE Email = :email");
    $select_user_stmt->bindParam(":email", $email);
    $select_user_stmt->execute();

    $user = $select_user_stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die("User not found.");
    }
    $user_id = $user['ID'];
} catch (PDOException $e) {
    die("Error fetching user ID: " . $e->getMessage());
}

// Fetch services for the dropdown
try {
    $stmt = $pdo->query("SELECT Services_ID, Services_Name FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching services: " . $e->getMessage());
}

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_time = $_POST['new_time'];

    // Fetch the current appointment time and description
    try {
        $select_appointment_stmt = $pdo->prepare("SELECT appointment_time, appointment_description FROM appointments WHERE id = :id AND user_id = :user_id");
        $select_appointment_stmt->bindParam(":id", $appointment_id);
        $select_appointment_stmt->bindParam(":user_id", $user_id);
        $select_appointment_stmt->execute();

        $appointment = $select_appointment_stmt->fetch(PDO::FETCH_ASSOC);
        if (!$appointment) {
            die("Appointment not found.");
        }

        $current_time = new DateTime();
        $appointment_time = new DateTime($appointment['appointment_time']);
        $interval = $current_time->diff($appointment_time);

        if ($interval->h >= 24 || $interval->days > 0) {
            // Check if the new appointment time is in the future
            if (new DateTime($new_time) <= new DateTime()) {
                $error_message = "You cannot update the appointment to a past date or time.";
            } else {
                // Check if the selected time is between 10:00 and 22:00
                $new_time_dt = new DateTime($new_time);
                $new_time_hour = (int)$new_time_dt->format('H');

                if ($new_time_hour < 10 || $new_time_hour >= 22) {
                    $error_message = "You can only update appointments to a time between 10:00 and 22:00.";
                } else {
                    // Services that require a 1-hour gap
                    $specific_services = ['איפור מקצועי', 'בניית ציפורניים', 'מילוי ציפורניים', 'צביעת שיער', 'תוספת לשיער'];

                    // Check for החלקה specific condition
                    if ($appointment['appointment_description'] === 'החלקה') {
                        $new_date = $new_time_dt->format('Y-m-d');
                        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM appointments WHERE appointment_description = 'החלקה' AND DATE(appointment_time) = :appointment_date");
                        $stmt->execute(['appointment_date' => $new_date]);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result['count'] >= 2) {
                            $error_message = "You cannot update the appointment to a time where there are already 2 appointments for החלקה on the same date.";
                        }
                    }

                    // Check for 1-hour gap condition
                    if (in_array($appointment['appointment_description'], $specific_services)) {
                        $start_time = $new_time_dt->modify('-1 hour')->format('Y-m-d H:i:s');
                        $end_time = $new_time_dt->modify('+2 hours')->format('Y-m-d H:i:s');

                        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointment_description IN ('" . implode("','", $specific_services) . "') AND appointment_time BETWEEN :start_time AND :end_time");
                        $stmt->execute(['start_time' => $start_time, 'end_time' => $end_time]);
                        $conflicting_appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($conflicting_appointments)) {
                            $error_message = "You cannot update the appointment to a time within 1 hour of an existing appointment for the same service.";
                        }
                    }

                    // If no errors, update the appointment
                    if (!isset($error_message)) {
                        $update_stmt = $pdo->prepare("UPDATE appointments SET appointment_time = :new_time WHERE id = :id AND user_id = :user_id");
                        $update_stmt->bindParam(":new_time", $new_time);
                        $update_stmt->bindParam(":id", $appointment_id);
                        $update_stmt->bindParam(":user_id", $user_id);

                        if ($update_stmt->execute()) {
                            $success_message = "Appointment updated successfully!";
                        } else {
                            $error_message = "Failed to update appointment.";
                        }
                    }
                }
            }
        } else {
            $error_message = "Cannot update appointment less than 24 hours before the appointment time.";
        }
    } catch (PDOException $e) {
        die("Error updating appointment: " . $e->getMessage());
    }
}

// Handle delete form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_appointment'])) {
    $appointment_id = $_POST['appointment_id'];

    // Fetch the current appointment time
    try {
        $select_appointment_stmt = $pdo->prepare("SELECT appointment_time FROM appointments WHERE id = :id AND user_id = :user_id");
        $select_appointment_stmt->bindParam(":id", $appointment_id);
        $select_appointment_stmt->bindParam(":user_id", $user_id);
        $select_appointment_stmt->execute();

        $appointment = $select_appointment_stmt->fetch(PDO::FETCH_ASSOC);
        if (!$appointment) {
            die("Appointment not found.");
        }

        $current_time = new DateTime();
        $appointment_time = new DateTime($appointment['appointment_time']);
        $interval = $current_time->diff($appointment_time);

        if ($interval->h >= 24 || $interval->days > 0) {
            // If valid, delete the appointment
            $delete_stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id AND user_id = :user_id");
            $delete_stmt->bindParam(":id", $appointment_id);
            $delete_stmt->bindParam(":user_id", $user_id);

            if ($delete_stmt->execute()) {
                $success_message = "Appointment deleted successfully!";
            } else {
                $error_message = "Failed to delete appointment.";
            }
        } else {
            $error_message = "You can only delete appointments at least 24 hours before the appointment time.";
        }
    } catch (PDOException $e) {
        die("Error deleting appointment: " . $e->getMessage());
    }
}

// Fetch appointments for the logged-in user
try {
    $select_appointments_stmt = $pdo->prepare("
        SELECT a.id, a.appointment_time, a.appointment_description, a.user_name
        FROM appointments a
        WHERE a.user_id = :user_id
        ORDER BY a.appointment_time DESC
    ");
    $select_appointments_stmt->bindParam(":user_id", $user_id);
    $select_appointments_stmt->execute();

    $appointments = $select_appointments_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching appointments: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/Footer.css">

    <link rel="stylesheet" href="../Style/UserNavBar.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Qamar & Tamer saloon beauty</title>
</head>
<body>
    <nav>
        <div class="container nav-container">
            <a href="#home" class="logo">
                <div><span>Qamar</span>Tamer</div>
                <div>Saloon Beauty</div>
            </a>
            <ul class="navlist">
                <li><a href="./UserHome.php">בית</a></li>
                <li><a href="./UserFeedBack.php">שליחת תלונה</a></li>
                <li><a href="./UserPrices.php">טבלת מחירים</a></li>
                <li><a href="./UserInfo.php">פרטים אישיים</a></li>
                <li class="dropdown">
                    <a href="#">תורים</a>
                    <ul class="submenu">
                        <li><a href="./UserAppointment.php">תור לסלון</a></li>
                        <li><a href="./UserListAppointment.php">תורים שלי</a></li>
                    </ul>
                </li>
                <li><a href="../Exit.php">התנתק</a></li>
            </ul>
            <div class="nav-icons">
                <div class="menu-btn">
                    <span class="lnr lnr-menu"></span>
                </div>
            </div>
        </div>
    </nav>
    <br>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Your Appointments</h1>
        <?php if (!empty($success_message)): ?>
            <p class="text-green-500"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="text-red-500"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if (empty($appointments)) : ?>
            <p>You have no appointments.</p>
        <?php else: ?>
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Date & Time</th>
                        <th class="px-4 py-2">Service</th>
                        <th class="px-4 py-2">Update</th>
                        <th class="px-4 py-2">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($appointment['appointment_description']); ?></td>
                            <td class="border px-4 py-2">
                                <form action="" method="post">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                    <input type="datetime-local" name="new_time" required>
                                    <button type="submit" name="update_appointment" class="bg-blue-500 text-white py-1 px-2 text-sm rounded w-20">Update</button>
                                </form>
                            </td>
                            <td class="border px-4 py-2">
                                <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                    <button type="submit" name="delete_appointment" class="bg-red-500 text-white py-1 px-2 text-sm rounded w-20">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>Qamar & Tamer Developers&hearts;</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <script type="text/javascript" src="./Js/Javascribt.js"></script>
    <script src="Js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./Js/Login.js"></script>
</body>
</html>
