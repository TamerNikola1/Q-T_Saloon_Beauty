<?php
require_once 'Database.php';
session_start();

// Handle redirection if user is already logged in
if (isset($_SESSION["admin_login"])) {
    header("location: ../Admin/AdminHome.php"); 
    exit;
}
if (isset($_SESSION["employee_login"])) {
    header("location: ../Employee/Worker.php"); 
    exit;
}
if (isset($_SESSION["user_login"])) {
    header("location: ../User/UserHome.php");
    exit;
}

// Handle login form submission
if (isset($_POST['btn_login'])) {
    $email = $_POST["txt_email"]; 
    $password = $_POST["txt_password"]; 
    $role = $_POST["txt_role"];  

    if (empty($email)) {
        echo "<script>alert('Please enter email')</script>";
    } else if (empty($password)) {
        echo "<script>alert('Please enter password')</script>";
    } else if (empty($role)) {
        echo "<script>alert('Please select role')</script>";
    } else {
        try {
            // Query to fetch user details
            $select_stmt = $pdo->prepare("SELECT Email, Password, Role FROM users WHERE Email = :uemail AND Role = :urole");
            $select_stmt->bindParam(":uemail", $email);
            $select_stmt->bindParam(":urole", $role);
            $select_stmt->execute(); 

            // Check if user exists
            if ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['Password'])) {
                    $_SESSION["login"] = $email;   // Set session for logged in user
                    
                    // Set session based on role
                    switch ($role) {
                        case 'admin':
                            $_SESSION["admin_login"] = true;
                            header("location: ./Admin/AdminHome.php");
                            exit;
                        case 'employee':
                            $_SESSION["employee_login"] = true;
                            header("location: ./Employee/Worker.php");
                            exit;
                        case 'user':
                            $_SESSION["user_login"] = true;
                            header("location: ./User/UserHome.php");
                            exit;
                        default:
                            echo "<script>alert('Unknown role')</script>";
                            break;
                    }
                } else {
                    echo "<script>alert('Wrong email, password, or role')</script>";
                }
            } else {
                echo "<script>alert('Wrong email, password, or role')</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('".$e->getMessage()."')</script>";
        }
    }
}

// Handle forgot password form submission
if (isset($_POST['btn_forgot_password'])) {
    $forgot_email = $_POST["forgot_email"];
    $new_password = $_POST["new_password"];

    if (empty($forgot_email) || empty($new_password)) {
        echo "<script>alert('Please fill in both email and new password')</script>";
    } else {
        try {
            // Check if the email exists
            $select_stmt = $pdo->prepare("SELECT Email FROM users WHERE Email = :uemail");
            $select_stmt->bindParam(":uemail", $forgot_email);
            $select_stmt->execute();

            if ($select_stmt->rowCount() > 0) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update the user's password in the database
                $update_stmt = $pdo->prepare("UPDATE users SET Password = :new_password WHERE Email = :uemail");
                $update_stmt->bindParam(":new_password", $hashed_password);
                $update_stmt->bindParam(":uemail", $forgot_email);
                $update_stmt->execute();

                echo "<script>alert('Your password has been reset successfully. You can now log in with your new password.')</script>";
            } else {
                echo "<script>alert('Email does not exist')</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('".$e->getMessage()."')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="./Style/Style.css">
    <link rel="stylesheet" href="./Style/Connection.css">


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
                    <span>Qamar</span><span>Tamer</span>
                </div>
                <div>Saloon Beauty</div>
            </a>
            <ul class="navlist">
                <li><a href="./Home.php">בית</a></li>
                <li><a href="./AboutUs.php">אודות העסק</a></li>
                <li><a href="./Gallery.php">גלריה</a></li>
                <li><a href="./Prices.php">מחירים</a></li>
                <li><a href="./Connection.php" class="active">התחברות</a></li>
            </ul>
            <div class="nav-icons">
                <div class="menu-btn">
                    <span class="lnr lnr-menu"></span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex flex-col w-full justify-center items-center text-center bg-gray-100 min-h-screen py-12">
        <!-- Login Form -->
        <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Login</h2>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="txt_email" id="email" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter email" required />
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="txt_password" id="password" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter password" required />
            </div>
            
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Select Type</label>
                <select name="txt_role" id="role" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="" selected="selected"> - Select role - </option>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <div class="mb-6">
                <input type="submit" name="btn_login" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-300" value="Login">
            </div>
            
            <div class="text-sm">
                Don't have an account? <a href="Register.php" class="text-blue-500 hover:text-blue-700">Register here</a><br>
                <a href="#" id="forgotPasswordLink" class="text-blue-500 hover:text-blue-700">Forgot Password?</a>
            </div>
        </form>

        <!-- Forgot Password Form -->
        <form id="forgotPasswordForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md hidden">
            <h2 class="text-2xl font-bold mb-6">Forgot Password</h2>
            <div class="mb-4">
                <label for="forgot_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="forgot_email" id="forgot_email" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter email" required />
            </div>
            
            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input type="password" name="new_password" id="new_password" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter new password" required />
            </div>
            
            <div class="mb-6">
                <input type="submit" name="btn_forgot_password" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-300" value="Reset Password">
            </div>
            
            <div class="text-sm">
                <a href="#" id="backToLoginLink" class="text-blue-500 hover:text-blue-700">Back to Login</a>
            </div>
        </form>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <script type="text/javascript" src="./Js/Jquery3.7.0.js"></script>
    <script type="text/javascript" src="./Js/Login.js"></script>
    <script type="text/javascript" src="./Js/Sign_up.js"></script>
    <script type="text/javascript" src="./Js/Connection.js"></script>

    <script>
        document.getElementById('forgotPasswordLink').addEventListener('click', function() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('forgotPasswordForm').classList.remove('hidden');
        });

        document.getElementById('backToLoginLink').addEventListener('click', function() {
            document.getElementById('forgotPasswordForm').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
        });
    </script>
</body>
</html>
