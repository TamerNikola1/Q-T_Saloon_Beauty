
<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    
    <link rel="stylesheet" href="../Style/Footer.css">
      <!--Link to appointment table -->
      <link rel="stylesheet" href="../Style/WorkerAppointmentTables.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>Qamar & Tamer saloon beauty</title>
</head>
<body>
    <nav>
    <div class="container nav-container">
        <a href="#home" class="logo">
        <div>
        <span>Qamar</span>Tamer</span>
        </div>
        <div>Saloon Beauty</div>
        </a>
        <ul class="navlist">
        <li><a href="./Worker.php">בית</a></li>
        <li><a href="./WorkerAppointmentTables.php"  class="active">טבלת תורים</a></li>
        <li><a href="./WorkerInfo.php">עדכון פרטים</a></li>
        <li><a href="../Exit.php">התנתק</a></li>
        </ul>
        <div class="nav-icons">
        <div class="menu-btn">
        <span class="lnr lnr-menu"></span>
        </div>

       
    </div>
    </nav>
<br>


<!--Appointment Table of cusomers-->
<?php
// Database credentials
require_once '../Database.php';

// Establish a PDO connection
try {
  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Query to fetch all appointments
$query = "SELECT * FROM appointments";
$stmt = $pdo->query($query);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="p-4">

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Appointments</h1>

        <table class="min-w-full bg-white shadow-md rounded my-6">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">User ID</th>
                    <th class="py-3 px-6 text-left">Appointment Time</th>
                    <th class="py-3 px-6 text-left">Appointment Description</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Updated At</th>
                    <th class="py-3 px-6 text-left">User Name</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach ($appointments as $appointment): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['id']) ?></td>
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['user_id']) ?></td>
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['appointment_description']) ?></td>
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['created_at']) ?></td>
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['updated_at']) ?></td>
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($appointment['user_name']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>







<!--------- Footer---------------------->
<div class="footer">
  <p>Qamar & Tamer Developers&hearts;</p>
</div>



 <!-- Swiper JS -->
 <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
<script type="text/javascript" src="./Js/Javascribt.js"></script>
<script src="Js/jquery-3.4.1.min.js"></script>
<!--Link with login js file for form login/signup-->
<script type="text/javascript" src="./Js/Login.js"></script>
</body>
</html>