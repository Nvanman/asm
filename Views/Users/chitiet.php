<?php
// Thông tin kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Kết nối database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Lấy thông tin sản phẩm từ database
        $sql = "SELECT * FROM sanpham WHERE MaSP = :productId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo "Sản phẩm không tồn tại!";
            exit();
        }
    } else {
        echo "Không có sản phẩm được chọn!";
        exit();
    }

} catch(PDOException $e) {
    echo "Kết nối database thất bại: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            padding: 2rem 0;
        }
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-img {
            border-radius: 0.5rem 0 0 0.5rem;
            object-fit: cover;
            width: 100%;
            height: 100%;
            max-height: auto;
            transition: transform 0.3s ease-in-out;
        }
        .card-img:hover {
            transform: scale(1.05);
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin-top: 56px;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
        }
        .navbar-nav .nav-link {
            font-size: 1.1rem;
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }
        .sidebar {
            position: static;
            top: 56px;
            bottom: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
            background-color: #343a40;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #fff;
            font-size: 1.2rem;
            padding: 12px 20px;
            transition: background-color 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #495057;
            border-radius: 0 5px 5px 0;
        }
        .main-content {
            padding: 30px;
            background-color: #fff;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: #0062cc;
            color: #fff;
            font-weight: 700;
            border-radius: 10px 10px 0 0;
        }
        .card-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        .card-text {
            font-size: 1rem;
            color: #333;
        }
        .btn-primary, .btn-success {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover, .btn-success:hover {
            transform: scale(1.05);
        }
        .banner {
            width: 100%;
            height: 300px;
        }
        .carousel-item {
            height: 300px;
        }
        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        footer a {
            color: #ffc107;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .product-image {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="bangsp.php">Invoice</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Banner Carousel -->
    <div id="bannerCarousel" class="carousel slide banner" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../Products/img/iphone.jpg" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 1</h5>
                    <p>Subtitle or description for Image 1</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../Products/img/iphone.jpg" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 2</h5>
                    <p>Subtitle or description for Image 2</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../Products/img/iphone.jpg" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 3</h5>
                    <p>Subtitle or description for Image 3</p>
                </div>
            </div>
        </div>
    </div>
<div class="container mx-auto">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg card">
        <img src="../admin/img/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>" class="card-img">
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($product['TenSP']) ?></h1>
            <p class="text-gray-700 text-lg mb-4">Giá: <?= number_format($product['DonGia'], 0, ',', '.') ?> VNĐ</p>
            <p class="text-gray-700 mb-4"><?= htmlspecialchars($product['MoTa']) ?></p>
            <a href="../../index.php" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Trở Về Trang Chủ</a>
        </div>
    </div>
</div>
<footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>Address: 123, ABC Street, XYZ District</p>
                    <p>Phone: 0123 456 789</p>
                    <p>Email: example@example.com</p>
                </div>
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>Company information.</p>
                    <p>Terms and conditions.</p>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <p><a href="#" class="text-white">Facebook</a></p>
                    <p><a href="#" class="text-white">Instagram</a></p>
                    <p><a href="#" class="text-white">Twitter</a></p>
                </div>
            </div>
        </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
