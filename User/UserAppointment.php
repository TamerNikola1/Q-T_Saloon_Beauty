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

    <?php
    // Include the database connection file
    require_once '../Database.php';
    // Start the session
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

    // Fetch user details based on user ID
    try {
        $select_details_stmt = $pdo->prepare("SELECT Name, Last_Name, Phone, Email, Address FROM users WHERE ID = :id");
        $select_details_stmt->bindParam(":id", $user_id);
        $select_details_stmt->execute();

        $user_details = $select_details_stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user_details) {
            die("User details not found.");
        }
    } catch (PDOException $e) {
        die("Error fetching user details: " . $e->getMessage());
    }

    // Handle appointment booking form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_appointment'])) {
        $service_id = $_POST['service_id'];
        $appointment_time = $_POST['appointment_time'];
        $user_name = $user_details['Name'] . ' ' . $user_details['Last_Name'];  // Use fetched user details
        $user_id = $user_id;

        // Services that require a 1-hour gap
        $specific_services = ['איפור מקצועי', 'בניית ציפורניים', 'מילוי ציפורניים', 'צביעת שיער', 'תוספת לשיער'];

        // Check if the appointment time is in the future
        if (new DateTime($appointment_time) <= new DateTime()) {
            $error_message = "You cannot book an appointment for a past date or time.";
        } else {
            // Check if the selected time is between 10:00 and 22:00
            $appointment_time_dt = new DateTime($appointment_time);
            $appointment_hour = (int)$appointment_time_dt->format('H');

            if ($appointment_hour < 10 || $appointment_hour >= 22) {
                $error_message = "You can only book appointments between 10:00 and 22:00.";
            } else {
                // Check if the service is one of the specific services
                $stmt = $pdo->prepare("SELECT Services_Name FROM services WHERE Services_ID = :service_id");
                $stmt->execute(['service_id' => $service_id]);
                $service = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($service) {
                    // Check for החלקה specific condition
                    if ($service['Services_Name'] === 'החלקה') {
                        $appointment_date = $appointment_time_dt->format('Y-m-d');
                        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM appointments WHERE appointment_description = 'החלקה' AND DATE(appointment_time) = :appointment_date");
                        $stmt->execute(['appointment_date' => $appointment_date]);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result['count'] >= 2) {
                            $error_message = "You cannot book more than 2 appointments for החלקה on the same date.";
                        }
                    }

                    // Check for 1-hour gap condition for specific services
                    if (in_array($service['Services_Name'], $specific_services)) {
                        $start_time = $appointment_time_dt->modify('-1 hour')->format('Y-m-d H:i:s');
                        $end_time = $appointment_time_dt->modify('+2 hours')->format('Y-m-d H:i:s');

                        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointment_description IN ('" . implode("','", $specific_services) . "') AND appointment_time BETWEEN :start_time AND :end_time");
                        $stmt->execute(['start_time' => $start_time, 'end_time' => $end_time]);
                        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($appointments)) {
                            $error_message = "You cannot book an appointment within 1 hour of an existing appointment for the same service.";
                        }
                    }

                    // If no errors, insert the appointment
                    if (!isset($error_message)) {
                        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, appointment_time, appointment_description, created_at, user_name) 
                                               VALUES (:user_id, :appointment_time, :appointment_description, NOW(), :user_name)");
                        $stmt->execute([
                            'user_id' => $user_id,
                            'appointment_time' => $appointment_time,
                            'appointment_description' => $service['Services_Name'],
                            'user_name' => $user_name
                        ]);

                        $success_message = "Appointment booked successfully!";
                    }
                }
            }
        }
    }

    // Fetch services for the dropdown
    $stmt = $pdo->query("SELECT Services_ID, Services_Name FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Page Content -->
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold text-center mb-4">Book an Appointment</h1>
        <form action="" method="post" class="w-full max-w-lg mx-auto bg-white p-6 rounded shadow">
            <!-- Service Selection -->
            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 font-bold mb-2">Service:</label>
                <select id="service_id" name="service_id" class="form-select block w-full mt-1 border rounded p-2" required>
                    <option value="">Select a service</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo htmlspecialchars($service['Services_ID']); ?>">
                            <?php echo htmlspecialchars($service['Services_Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Appointment Time Input -->
            <div class="mb-4">
                <label for="appointment_time" class="block text-gray-700 font-bold mb-2">Appointment Time:</label>
                <input type="datetime-local" id="appointment_time" name="appointment_time" class="form-input block w-full mt-1 border rounded p-2" required>
            </div>
            <!-- Submit Button -->
            <button type="submit" name="book_appointment" class="bg-blue-500 text-white p-2 rounded w-full">Book Appointment</button>
            <!-- Success/Error Messages -->
            <?php if (isset($success_message)): ?>
                <p class="text-green-500 text-center mt-4"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="text-red-500 text-center mt-4"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Qamar & Tamer Developers&hearts;</p>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <script type="text/javascript" src="./Js/Javascribt.js"></script>
    <script src="Js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./Js/Login.js"></script>
</body>
</html>
