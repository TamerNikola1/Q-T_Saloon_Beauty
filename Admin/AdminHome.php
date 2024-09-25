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