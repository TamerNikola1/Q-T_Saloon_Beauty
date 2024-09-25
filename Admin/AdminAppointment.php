<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/ContactUs.css">
    <link rel="stylesheet" href="../Style/PricesTable.css">
    <link rel="stylesheet" href="../Style/Footer.css">
    <link rel="stylesheet" href="../Style/AdminNavBar.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>Qamar & Tamer saloon beauty</title>
</head>
<body>
    <nav>
        <div class="container nav-container">
            <a href="#home" class="logo">
                <div>
                    <span>Qamar</span><span>Tamer</span>
                </div>
                <div>Saloon Beauty</div>
            </a>
            <ul class="navlist">
                <li><a href="./AdminHome.php">בית</a></li>
                <li class="dropdown">
                    <a href="#">ניהול עובדים</a>
                    <ul class="submenu">
                        <li><a href="./AddWorker.php">הוספת עובד</a></li>
                        <li><a href="./DeleteWorker.php">מחיקת עובד</a></li>
                        <!-- Add more dropdown items as needed -->
                    </ul>
                </li>
                <li><a href="./AdminPrices.php">מחירים</a></li>
                <li><a href="./AdminFeedBack.php">תלונות</a></li>
                <li><a href="./AdminAppointment.php" class="active">תורים</a></li>
                <li><a href="./AdminCharts.php">סטטיסטיקה</a></li>            
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
// Database connection
require_once "../Database.php";
try {
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all appointments
    $query = "SELECT * FROM appointments";
    $stmt = $pdo->query($query);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Appointments</h1>
        
        <?php if (count($appointments) > 0): ?>
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">User ID</th>
                    <th class="py-2 px-4">Appointment Time</th>
                    <th class="py-2 px-4">Description</th>
                    <th class="py-2 px-4">Created At</th>
                    <th class="py-2 px-4">Updated At</th>
                    <th class="py-2 px-4">User Name</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td class="border py-2 px-4"><?php echo $appointment['id']; ?></td>
                    <td class="border py-2 px-4"><?php echo $appointment['user_id']; ?></td>
                    <td class="border py-2 px-4"><?php echo $appointment['appointment_time']; ?></td>
                    <td class="border py-2 px-4"><?php echo $appointment['appointment_description']; ?></td>
                    <td class="border py-2 px-4"><?php echo $appointment['created_at']; ?></td>
                    <td class="border py-2 px-4"><?php echo $appointment['updated_at']; ?></td>
                    <td class="border py-2 px-4"><?php echo $appointment['user_name']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-gray-600">No appointments found.</p>
        <?php endif; ?>
        
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