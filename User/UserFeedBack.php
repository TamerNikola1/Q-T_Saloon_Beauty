
<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/UserNavBar.css">
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
        <li><a href="UserHome.php">בית</a></li>
        <li><a href="./UserFeedBack.php" class="active">שליחת תלונה</a></li>
        <li><a href="./UserPrices.php">טבלת מחירים</a></li>
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
// Database credentials
require_once '../Database.php';



// Establish a PDO connection
try {

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize variables for feedback and error messages
$message = $error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $feedback_text = trim($_POST['feedback_text']);
    
    // Validate feedback text (not empty)
    if (!empty($feedback_text)) {
        // Prepare SQL statement to insert feedback
        $query = "INSERT INTO feedback (Feedback_Text) VALUES (:feedback_text)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':feedback_text', $feedback_text, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "Feedback submitted successfully.";
        } else {
            $error_message = "Error submitting feedback.";
        }
    } else {
        $error_message = "Feedback message cannot be empty. Please enter a message.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        // Client-side validation using JavaScript (optional)
        function validateForm() {
            var feedbackText = document.getElementById('feedback_text').value.trim();

            if (feedbackText === '') {
                alert("Feedback message cannot be empty. Please enter a message.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Contact Us</h2>

        <?php if (!empty($message)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?= htmlspecialchars($message) ?></p>
        </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p><?= htmlspecialchars($error_message) ?></p>
        </div>
        <?php endif; ?>

        <form action="" method="POST" onsubmit="return validateForm()"
            class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="feedback_text" class="block text-gray-700 text-sm font-bold mb-2">Your Message:</label>
                <textarea name="feedback_text" id="feedback_text" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    rows="4" placeholder="Enter your message..."></textarea>
            </div>

            <div class="flex items-center justify-center">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    name="submit">Submit</button>
            </div>
        </form>
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