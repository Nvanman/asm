<?php
session_start();

// Thông tin kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Kết nối database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login/login.php");
        exit();
    }

    // Get product ID from POST request
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];

        // Add product to cart or create order logic
        $sql = "INSERT INTO giohang (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        header("Location: viewcart.php");
        exit();
    } else {
        echo "No product selected.";
    }
} catch(PDOException $e) {
    echo "Kết nối database thất bại: " . $e->getMessage();
}
?>
