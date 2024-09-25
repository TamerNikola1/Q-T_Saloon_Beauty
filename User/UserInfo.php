<?php
require_once '../Database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_login"]) || $_SESSION["user_login"] !== true) {
    die("Access denied. Please log in.");
}

// Get the logged-in user's email
$email = $_SESSION["login"];

// Fetch user ID based on email
try {
    $select_user_stmt = $pdo->prepare("SELECT ID FROM users WHERE Email = :email");
    $select_user_stmt->bindParam(":email", $email);
    $select_user_stmt->execute();

    $user = $select_user_stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die("User not found.");
    }
    $user_id = $user['ID'];
} catch (PDOException $e) {
    die("Error fetching user ID: " . $e->getMessage());
}

// Fetch user details based on user ID
try {
    $select_details_stmt = $pdo->prepare("SELECT Name, Last_Name, Phone, Email, Address FROM users WHERE ID = :id");
    $select_details_stmt->bindParam(":id", $user_id);
    $select_details_stmt->execute();

    $user_details = $select_details_stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user_details) {
        die("User details not found.");
    }
} catch (PDOException $e) {
    die("Error fetching user details: " . $e->getMessage());
}

// Regex patterns
$phone_pattern = '/^\d{10}$/'; // 10 digits
$email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'; // Email format

// Function to validate inputs
function validateInput($data, $pattern) {
    return preg_match($pattern, $data);
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    // Validate inputs
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Validate phone number
    if (!validateInput($phone, $phone_pattern)) {
        echo "Invalid phone number format. Please enter 10 digits.";
        exit();
    }

    // Validate email address
    if (!validateInput($email, $email_pattern)) {
        echo "Invalid email format. Please enter a valid email address.";
        exit();
    }

    // Update database
    try {
        $stmt_update = $pdo->prepare("UPDATE users SET Name = :name, Last_Name = :last_name, Phone = :phone, Email = :email, Address = :address WHERE ID = :id");
        $stmt_update->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_update->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt_update->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update->bindParam(':address', $address, PDO::PARAM_STR);

        if ($stmt_update->execute()) {
            echo "User details updated successfully.";
        } else {
            echo "Error updating user details.";
        }
    } catch (PDOException $e) {
        echo "Error updating user details: " . $e->getMessage();
    }
}
?>

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
    
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>Qamar & Tamer Saloon Beauty</title>
</head>
<body>
    <nav>
        <div class="container nav-container">
            <a href="#home" class="logo">
                <div>
                    <span>Qamar</span>Tamer
                </div>
                <div>Saloon Beauty</div>
            </a>
            <ul class="navlist">
                <li><a href="./UserHome.php">בית</a></li>
                <li><a href="./UserFeedBack.php">שליחת תלונה</a></li>
                <li><a href="./UserPrices.php">טבלת מחירים</a></li>
                <li><a href="./UserInfo.php" class="active">פרטים אישיים</a></li>
                <li class="dropdown">
                    <a href="#">תורים</a>
                    <ul class="submenu">
                        <li><a href="./UserAppointment.php">תור לסלון</a></li>
                        <li><a href="./UserListAppointment.php">תורים שלי</a></li>
                    </ul>
                </li>
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

    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-semibold mb-6">User Details</h2>
        <div class="overflow-x-auto">
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                <form id="updateForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="userId" name="id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="<?php echo isset($user_details['Name']) ? htmlspecialchars($user_details['Name']) : ''; ?>"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo isset($user_details['Last_Name']) ? htmlspecialchars($user_details['Last_Name']) : ''; ?>"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" id="phone" name="phone" value="<?php echo isset($user_details['Phone']) ? htmlspecialchars($user_details['Phone']) : ''; ?>"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($user_details['Email']) ? htmlspecialchars($user_details['Email']) : ''; ?>"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo isset($user_details['Address']) ? htmlspecialchars($user_details['Address']) : ''; ?>"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--------- Footer---------------------->
    <div class="footer">
        <p>Qamar & Tamer Developers &hearts;</p>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <script type="text/javascript" src="./Js/Javascribt.js"></script>
    <script src="Js/jquery-3.4.1.min.js"></script>
    <!-- Link with login JS file for form login/signup -->
    <script type="text/javascript" src="./Js/Login.js"></script>
</body>
</html>
