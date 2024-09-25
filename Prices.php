
<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/Style.css">
    <link rel="stylesheet" href="./Style/ContactUs.css">
    <link rel="stylesheet" href="./Style/PricesTable.css">
    <link rel="stylesheet" href="./Style/Footer.css">
 
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
        <li><a href="./Home.php">בית</a></li>
        <li><a href="./AboutUs.php">אודות העסק</a></li>
        <li><a href="./Gallery.php">גלריה</a></li>
        <li><a href="./Prices.php" class="active">מחירים</a></li>
        <li><a href="./Connection.php">התחברות</a></li>
        </ul>
        <div class="nav-icons">
        <div class="menu-btn">
        <span class="lnr lnr-menu"></span>
   
        </div>

     
        </div>
    </div>
    </nav>
<br>

<!--Table-->
<div class="PricesP">
<P>מחירים</P>
</div>
<table id="PricesTable">
  <tr>
    
    <th>מחיר</th>
    <th>שם</th>
  </tr>
  <tr>
 
  <?php
 require_once "Database.php";
$stmt = $pdo->prepare("SELECT Price,Services_Name FROM services");
try{
    $stmt->execute();
}catch(PDOException $err){
    //some logging function
}
//loop through each row
while($result=$stmt->fetch(PDO::FETCH_ASSOC))
{
   //select column by key and use
?>
<td><?php echo $result['Price'];?></td>
<td><?php echo $result['Services_Name'];?></td>
</tr>
<?php
}?>
</table>





















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