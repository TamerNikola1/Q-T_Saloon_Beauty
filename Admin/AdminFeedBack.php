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
                <li><a href="./AdminFeedBack.php" class="active">תלונות</a></li>
                <li><a href="./AdminAppointment.php">תורים</a></li> 
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
require_once '../Database.php';

// Error handling and PDO instantiation
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
    exit();
}

// Query to fetch all feedback
$select_query = "SELECT * FROM feedback";
$stmt = $pdo->query($select_query);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Table</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6 bg-pink-100"> <!-- Set body background to light pink -->

    <div class="max-w-4xl mx-auto"> <!-- Center content with max width -->
        <h1 class="text-2xl font-bold mb-4">Feedback</h1>

        <!-- Feedback Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-pink-200 rounded-lg overflow-hidden shadow-lg"> <!-- Set table background to pink -->
                <thead class="bg-pink-400 text-white">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Feedback Text</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-300">
                    <?php foreach($feedbacks as $feedback): ?>
                        <tr class="text-center">
                            <td class="py-3 px-4"><?php echo $feedback['Feedback_ID']; ?></td>
                            <td class="py-3 px-4"><?php echo $feedback['Feedback_Text']; ?></td>
                        </tr>
                    <?php endforeach; ?>
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