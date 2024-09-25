
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


















<?php
require_once '../Database.php'; /// database connection script

// Function to validate email format
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate phone format (10 digits)
function validate_phone($phone) {
    return preg_match("/^[0-9]{10}$/", $phone);
}

// Function to validate ID format (9 digits)
function validate_id($id) {
    return preg_match("/^[0-9]{9}$/", $id);
}

// Function to check if the user is at least 18 years old
function is_age_valid($birthday) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age >= 18;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = isset($_POST['id']) ? $_POST['id'] : null; // Check if ID is set, otherwise set to null
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // convert and storage the password in database hash 
    $role = $_POST['role'];

    // Validate inputs
    if (!validate_id($id)) {
        die("Invalid ID format. Please enter 9 digits.");
    }

    if (!validate_phone($phone)) {
        die("Invalid phone number format. Please enter 10 digits without spaces or dashes.");
    }

    if (!validate_email($email)) {
        die("Invalid email format.");
    }

    if (!is_age_valid($birthday)) {
        die("The worker must be at least 18 years old.");
    }

    // Check if ID already exists
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE ID = ?");
        $stmt->execute([$id]);
        $existingId = $stmt->fetch();

        if ($existingId) {
            die("User with this ID already exists.");
        }
    }

    // Check if user already exists by email or phone
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Phone = ? OR Email = ?");
    $stmt->execute([$phone, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        die("User with this phone number or email already exists.");
    }

    // Insert new user into database
    $stmt = $pdo->prepare("INSERT INTO users (ID, Name, Last_Name, Phone, Email, Birthday, Address, Password, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id, $name, $last_name, $phone, $email, $birthday, $address, $password, $role]);

    echo "New employee added successfully!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
        <h2 class="text-xl font-semibold mb-6">Add New Employee</h2>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-4">
                <label for="id" class="block text-sm font-medium text-gray-700">ID</label>
                <input type="text" id="id" name="id" required pattern="[0-9]{9}" title="Please enter 9 digits" class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" id="last_name" name="last_name" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
                <p class="text-xs text-gray-500">Format: 10 digits without spaces or dashes</p>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                <input type="date" id="birthday" name="birthday" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" id="address" name="address" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
            </div>

            <input type="hidden" name="role" value="Employee">

            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">Add Employee</button>
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