
<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/UserNavBar.css">   
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="../Style/Footer.css">
       <!--Login +signup css files-->
       <link rel="stylesheet" href="../Style/Login.css">
    <link rel="stylesheet" href="../Style/Sign_up.css">
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
        <li><a href="./UserHome.php">בית</a></li>
        <li><a href="./UserFeedBack.php">שליחת תלונה</a></li>
        <li><a href="./UserPrices.php" class="active">טבלת מחירים</a></li>
        <li><a href="./UserInfo.php">פרטים אישיים</a></li>
     
        <li class="dropdown">
                    <a href="#">תורים</a>
                    <ul class="submenu">
                        <li><a href="./UserAppointment.php">תור לסלון</a></li>
                        <li><a href="./UserListAppointment.php">תורים שלי</a></li>
                        <!-- Add more dropdown items as needed -->
                    </ul>
                </li>





        <li><a href="../Exit.php">התנתק</a></li>
        </ul>
        <div class="nav-icons">
        <div class="menu-btn">
        <span class="lnr lnr-menu"></span>
        </div>

       
    </div>
    </nav>
<br>


<?php
// Database connection
require_once '../Database.php';

// Initialize PDO connection
try {
  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
    exit;
}

// Fetch data from services table
$sql = "SELECT Services_Name, Services_ID, Price FROM services";
$stmt = $pdo->query($sql);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services List</title>

</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Services List</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="w-full bg-gray-200 border-b border-gray-300">
                        <th class="py-2 px-4 text-left text-gray-600">Service Name</th>
                        <th class="py-2 px-4 text-left text-gray-600">Service ID</th>
                        <th class="py-2 px-4 text-left text-gray-600">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($services) > 0): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300"><?php echo htmlspecialchars($service['Services_Name']); ?></td>
                                <td class="py-2 px-4 border-b border-gray-300"><?php echo htmlspecialchars($service['Services_ID']); ?></td>
                                <td class="py-2 px-4 border-b border-gray-300"><?php echo htmlspecialchars(number_format($service['Price'], 2)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-2 px-4 text-center text-gray-600">No services found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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