<?php

$dsn = "mysql:host=localhost;dbname=qamar_tamer";
$dbusername = "root";
$dbpassword = "";


try{

  $pdo = new PDO($dsn,$dbusername,$dbpassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

echo "Connecion Failed: " . $e->getMessage();

}

?>