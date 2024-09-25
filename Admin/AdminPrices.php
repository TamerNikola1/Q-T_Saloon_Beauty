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
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Qamar & Tamer Saloon Beauty</title>
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
                <li><a href="./AdminPrices.php" class="active">מחירים</a></li> 
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
    // Database connection
    require_once '../Database.php';

    // Error handling and PDO instantiation
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection Failed: " . $e->getMessage();
        exit();
    }

    // Add new service logic
    if (isset($_POST['add_service'])) {
        $service_name = $_POST['service_name'];
        $price = $_POST['price'];

        // Check if the service name already exists
        $check_query = "SELECT COUNT(*) AS count FROM services WHERE Services_Name = :service_name";
        $stmt = $pdo->prepare($check_query);
        $stmt->bindParam(':service_name', $service_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            echo "<script>alert('Service already exists!');</script>";
        } else {
            // Insert new service into database
            $insert_query = "INSERT INTO services (Services_Name, Price) VALUES (:service_name, :price)";
            $stmt = $pdo->prepare($insert_query);
            $stmt->bindParam(':service_name', $service_name);
            $stmt->bindParam(':price', $price);
            $stmt->execute();
            echo "<script>alert('Service added successfully!');</script>";
        }
    }

    // Update service price logic
    if (isset($_POST['update_service'])) {
        $service_id = $_POST['service_id'];
        $new_price = $_POST['new_price'];

        // Update the price of the selected service
        $update_query = "UPDATE services SET Price = :new_price WHERE Services_ID = :service_id";
        $stmt = $pdo->prepare($update_query);
        $stmt->bindParam(':new_price', $new_price);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->execute();
        echo "<script>alert('Service updated successfully!');</script>";
    }

    // Delete service logic
    if (isset($_POST['delete_service'])) {
        $service_id = $_POST['service_id'];

        // Check if there are appointments for this service by users with role 'user'
        $check_appointments_query = "SELECT COUNT(*) AS count FROM appointments a
                                    INNER JOIN users u ON a.user_name = CONCAT(u.Name, ' ', u.Last_Name)
                                    WHERE a.appointment_description = (SELECT Services_Name FROM services WHERE Services_ID = :service_id)
                                    AND u.Role = 'user'";
        $stmt = $pdo->prepare($check_appointments_query);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            echo "<script>alert('Cannot delete service. There are appointments associated with it by users.');</script>";
        } else {
            // Delete service from database
            $delete_query = "DELETE FROM services WHERE Services_ID = :service_id";
            $stmt = $pdo->prepare($delete_query);
            $stmt->bindParam(':service_id', $service_id);
            $stmt->execute();
            echo "<script>alert('Service deleted successfully!');</script>";
        }
    }

    // Fetch all services from database for display
    $select_query = "SELECT * FROM services";
    $stmt = $pdo->query($select_query);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <html lang="he">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Services</title>
        <!-- Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="p-6">
        <h1 class="text-2xl font-bold mb-4">Manage Services</h1>

        <!-- Add New Service Form -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Add New Service</h2>
            <form action="" method="POST" class="flex" onsubmit="return validatePrice()">
                <input type="text" name="service_name" placeholder="Service Name" class="rounded-l px-4 py-2 border border-gray-300 focus:outline-none focus:border-blue-500 flex-1" required>
                <input type="number" name="price" placeholder="Price" class="px-4 py-2 border border-gray-300 focus:outline-none focus:border-blue-500" pattern="[0-9]+([\.,][0-9]+)?" step="any" required>
                <button type="submit" name="add_service" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-r focus:outline-none">Add</button>
            </form>
        </div>

        <!-- Update Service Form -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Update Service Price</h2>
            <form action="" method="POST" class="flex">
                <select name="service_id" class="rounded-l px-4 py-2 border border-gray-300 focus:outline-none focus:border-blue-500 flex-1">
                    <?php foreach ($services as $service): ?>
                        <option value="<?= htmlspecialchars($service['Services_ID']) ?>"><?= htmlspecialchars($service['Services_Name']) ?> - &#8362;<?= htmlspecialchars($service['Price']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="new_price" placeholder="New Price" class="px-4 py-2 border border-gray-300 focus:outline-none focus:border-blue-500" step="any" required>
                <button type="submit" name="update_service" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-r focus:outline-none">Update</button>
            </form>
        </div>

        <!-- Delete Service Form -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Delete Service</h2>
            <form action="" method="POST" class="flex">
                <select name="service_id" class="rounded-l px-4 py-2 border border-gray-300 focus:outline-none focus:border-blue-500 flex-1">
                    <?php foreach ($services as $service): ?>
                        <option value="<?= htmlspecialchars($service['Services_ID']) ?>"><?= htmlspecialchars($service['Services_Name']) ?> - &#8362;<?= htmlspecialchars($service['Price']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="delete_service" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-r focus:outline-none">Delete</button>
            </form>
        </div>

        <!-- Display Services Table -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Services List</h2>
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-lg">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Service Name</th>
                        <th class="py-2 px-4">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr class="text-center">
                            <td class="py-2 px-4"><?= htmlspecialchars($service['Services_ID']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($service['Services_Name']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($service['Price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script>
            // Function to validate Price input before form submission
            function validatePrice() {
                var priceInput = document.querySelector('input[name="price"]');
                var priceValue = parseFloat(priceInput.value);
                if (isNaN(priceValue) || priceValue <= 0) {
                    alert("Price must be a number greater than 0.");
                    return false;
                }
                return true;
            }
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
    <!-- Link with login js file for form login/signup -->
    <script type="text/javascript" src="./Js/Login.js"></script>
</body>
</html>