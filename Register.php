<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/Style.css">
    <link rel="stylesheet" href="./Style/Connection.css">
        
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!--Login + signup CSS files-->
    <link rel="stylesheet" href="./Style/Login.css">
    <link rel="stylesheet" href="./Style/Sign_up.css">
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
                <li><a href="./Home.php">בית</a></li>
                <li><a href="./AboutUs.php">אודות העסק</a></li>
                <li><a href="./Gallery.php">גלריה</a></li>
                <li><a href="./Prices.php">מחירים</a></li>
                <li><a href="./Contact.php">יצרת קשר</a></li>
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
        <form id="register-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Register</h2>

            <div class="mb-4">
                <label for="id" class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                <input type="text" name="txt_id" id="id" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter 9-digit ID" pattern="\d{9}" title="ID must be exactly 9 digits." required />
                <span id="idError" class="text-red-500 text-sm hidden">ID must be exactly 9 digits.</span>
            </div>

            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input type="text" name="txt_first_name" id="first_name" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter first name" pattern="[A-Za-z]{1,32}" title="First name should only contain letters and be up to 32 characters." required />
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input type="text" name="txt_last_name" id="last_name" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter last name" pattern="[A-Za-z]{1,32}" title="Last name should only contain letters and be up to 32 characters." required />
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                <input type="tel" name="txt_phone" id="phone" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter phone number" pattern="\d{10}" title="Phone number should be 10 digits." required />
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="txt_email" id="email" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter email" required />
            </div>

            <div class="mb-4">
                <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">Birthday</label>
                <input type="date" name="txt_birthday" id="birthday" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required />
                <span id="ageError" class="text-red-500 text-sm hidden">You must be at least 16 years old to register.</span>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <input type="text" name="txt_address" id="address" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter address" pattern=".{1,255}" title="Address should be up to 255 characters." required />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="txt_password" id="password" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter password" pattern=".{6,}" title="Password should be at least 6 characters." required />
            </div>

            <div class="mb-6">
                <input type="submit" name="btn_register" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition duration-300" value="Register">
            </div>

            <div class="text-sm">
                Already have an account? <a href="Connection.php" class="text-blue-500 hover:text-blue-700">Login here</a>
            </div>
        </form>
    </div>

<?php
require_once './Database.php'; // Database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_register'])) {
    $id = htmlspecialchars($_POST['txt_id']);
    $first_name = htmlspecialchars($_POST['txt_first_name']);
    $last_name = htmlspecialchars($_POST['txt_last_name']);
    $phone = htmlspecialchars($_POST['txt_phone']);
    $email = htmlspecialchars($_POST['txt_email']);
    $birthday = htmlspecialchars($_POST['txt_birthday']);
    $address = htmlspecialchars($_POST['txt_address']);
    $password = password_hash(htmlspecialchars($_POST['txt_password']), PASSWORD_BCRYPT);
    $role = 'user'; // Default role for new users

    // Calculate the age
    $currentDate = date("Y-m-d");
    $birthDate = new DateTime($birthday);
    $today = new DateTime($currentDate);
    $age = $today->diff($birthDate)->y;

    // Server-side validation for ID and age
    if (!preg_match('/^\d{9}$/', $id)) {
        echo "<script>alert('ID must be exactly 9 digits.');</script>";
    } elseif ($age < 16) {
        echo "<script>alert('You must be at least 16 years old to register.');</script>";
    } else {
        try {
            // Check if ID exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $id_exists = $stmt->fetch();

            if ($id_exists) {
                echo "<script>alert('ID already exists. Please use a different ID.');</script>";
            } else {
                // Check if email exists
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $email_exists = $stmt->fetch();

                if ($email_exists) {
                    echo "<script>alert('Email already exists. Please use a different email.');</script>";
                } else {
                    // Insert new user
                    $stmt = $pdo->prepare("INSERT INTO users (id, name, last_name, phone, email, birthday, address, password, role) VALUES (:id, :first_name, :last_name, :phone, :email, :birthday, :address, :password, :role)");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthday', $birthday);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':role', $role);

                    if ($stmt->execute()) {
                        echo "<script>alert('Registration successful! Please log in.'); window.location.href = 'Connection.php';</script>";
                    } else {
                        echo "<script>alert('Registration failed. Please try again later.');</script>";
                    }
                }
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<script>
    document.getElementById('register-form').addEventListener('submit', function(event) {
        const birthdayInput = document.getElementById('birthday').value;
        const birthDate = new Date(birthdayInput);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        if (age < 16) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('ageError').classList.remove('hidden');
        }
    });
</script>

</body>
</html>
