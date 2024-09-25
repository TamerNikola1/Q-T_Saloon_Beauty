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
                <li><a href="./AdminCharts.php" class="active">סטטיסטיקה</a></li>        
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
require_once '../Database.php';
try {
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to fetch services data
    function fetchServicesData(PDO $pdo) {
        $query = "SELECT Services_Name, Price FROM services";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to fetch appointments data
    function fetchAppointmentsData(PDO $pdo) {
        $query = "SELECT COUNT(*) as count, DATE(appointment_time) as appointment_date FROM appointments GROUP BY appointment_date";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to fetch feedback data
    function fetchFeedbackData(PDO $pdo) {
        $query = "SELECT Feedback_Text FROM feedback";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Fetch services data
    $servicesData = fetchServicesData($pdo);

    // Fetch appointments data
    $appointmentsData = fetchAppointmentsData($pdo);

    // Fetch feedback data
    $feedbackData = fetchFeedbackData($pdo);

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
    <title>Charts Demo</title>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            max-width: 800px;
            margin: auto;
        }

        .chart {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Charts Demo</h1>

        <div class="chart-container">
            <!-- Bar Chart: Appointments by Date -->
            <div class="chart">
                <canvas id="barChart" width="400" height="200"></canvas>
            </div>

            <!-- Pie Chart: Services and Prices -->
            <div class="chart">
                <canvas id="pieChart" width="400" height="200"></canvas>
            </div>

            <!-- Word Cloud: Feedback -->
            <div class="chart">
                <canvas id="wordCloud" width="400" height="200"></canvas>
            </div>
            <br>
        </div>
    </div>

    <script>
        // Data for Bar Chart: Appointments by Date
        var barData = {
            labels: [<?php foreach ($appointmentsData as $data) { echo '"' . $data['appointment_date'] . '",'; } ?>],
            datasets: [{
                label: 'Appointments Count',
                data: [<?php foreach ($appointmentsData as $data) { echo $data['count'] . ','; } ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Data for Pie Chart: Services and Prices
        var pieData = {
            labels: [<?php foreach ($servicesData as $data) { echo '"' . $data['Services_Name'] . '",'; } ?>],
            datasets: [{
                label: 'Service Price',
                data: [<?php foreach ($servicesData as $data) { echo $data['Price'] . ','; } ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Data for Word Cloud: Feedback
        var feedbackData = {
            labels: [<?php foreach ($feedbackData as $text) { echo '"' . $text . '",'; } ?>],
            datasets: [{
                label: 'Feedback Words',
                data: [<?php $counts = array_count_values($feedbackData); foreach ($counts as $text => $count) { echo $count . ','; } ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Render Bar Chart: Appointments by Date
        var barCtx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: barData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Render Pie Chart: Services and Prices
        var pieCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: pieData
        });

        // Render Word Cloud: Feedback
        var wordCloudCtx = document.getElementById('wordCloud').getContext('2d');
        var wordCloudChart = new Chart(wordCloudCtx, {
            type: 'bar', // Using bar chart for word cloud effect
            data: feedbackData,
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
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