<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the list of categories from the database
    $sqlDanhMuc = "SELECT * FROM danhmuc";
    $stmtDanhMuc = $conn->prepare($sqlDanhMuc);
    $stmtDanhMuc->execute();
    $danhMucList = $stmtDanhMuc->fetchAll(PDO::FETCH_ASSOC);

    // Retrieve the list of products from the database
    $sqlSanPham = "SELECT * FROM sanpham";
    $stmtSanPham = $conn->prepare($sqlSanPham);
    $stmtSanPham->execute();
    $sanPhamList = $stmtSanPham->fetchAll(PDO::FETCH_ASSOC);

    // Create an array to store products by category
    $sanPhamTheoDanhMuc = [];
    foreach ($sanPhamList as $sanPham) {
        $sanPhamTheoDanhMuc[$sanPham['MaDM']][] = $sanPham;
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products by Category</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
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
            position: sticky;
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
            background-color: #343a40;
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
            border-radius: 10px;
        }
        .category-title {
            font-size: 1.5rem;
            color: #007bff;
            margin-bottom: 1rem;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Trang Chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="Views/Products/viewcart.php">Giỏ Hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Thêm</a></li>
                    <li class="nav-item dropdown">
                        <?php
                            session_start();
                            if (isset($_SESSION['tenTK'])) {
                                $Role = $_SESSION['Role'];
                                echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                echo 'Hello, ' . $_SESSION['tenTK'];
                                echo '</a>';
                                echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                echo '<li><a class="dropdown-item" href="login/logout.php" onclick="confirmLogout(event)">Logout</a></li>';
                                if ($Role === 'admin') {
                                    echo '<li><a class="dropdown-item" href="Views/admin/list_product.php">Admin Page</a></li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<a href="login/login.php" class="btn btn-light ms-2">Login</a>';
                                echo '<a href="login/register.php" class="btn btn-light ms-2">Register</a>';
                            }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Banner Carousel -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Views/Products/img/iphone.jpg" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 1</h5>
                    <p>Subtitle or description for Image 1</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Views/Products/img/iphone.jpg" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 2</h5>
                    <p>Subtitle or description for Image 2</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Views/Products/img/iphone.jpg" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 3</h5>
                    <p>Subtitle or description for Image 3</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Sidebar and Main Content -->
    <div class="d-flex">
        <nav class="sidebar">
            <h4 class="text-center text-white">Categories</h4>
            <div class="nav flex-column">
                <?php foreach ($danhMucList as $danhMuc) {
                    echo '<a class="nav-link" href="#' . $danhMuc['MaDM'] . '">' . $danhMuc['TenDM'] . '</a>';
                } ?>
            </div>
        </nav>
        <div class="main-content container-fluid">
            <h1 class="text-center mb-4">Products by Category</h1>
            <?php foreach ($danhMucList as $danhMuc) {
                echo '<div class="card mb-4" id="' . $danhMuc['MaDM'] . '">';
                echo '<div class="card-header">';
                echo '<h2 class="category-title">' . $danhMuc['TenDM'] . '</h2>';
                echo '</div>';
                echo '<div class="card-body">';
                echo '<div class="row">';
                if (isset($sanPhamTheoDanhMuc[$danhMuc['MaDM']])) {
                    foreach ($sanPhamTheoDanhMuc[$danhMuc['MaDM']] as $sanPham) {
                        echo '<div class="col-md-4 mb-3">';
                        echo '<div class="card h-100">';
                        echo '<img src="Views/admin/img/' . $sanPham['img'] . '" class="card-img-top product-image" alt="' . $sanPham['TenSP'] . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $sanPham['TenSP'] . '</h5>';
                        echo '<p class="card-text">Price: ' . number_format($sanPham['DonGia'], 0, ',', '.') . ' VND</p>';
                        echo '<a href="Views/Users/chitiet.php?id=' . $sanPham['MaSP'] . '" class="btn btn-primary">View Details</a>';
                        echo '<form action="Views/Products/viewcart.php" method="post" class="mt-2">';
                        echo '<input type="hidden" name="TenSP" value="' . $sanPham['TenSP'] . '">';
                        echo '<input type="hidden" name="add_to_cart" value="1">';
                        echo '<button type="submit" class="btn btn-success">Buy Now</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">No products in this category.</p>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } ?>
        </div>
    </div>
    <!-- Footer -->
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
    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có xác nhận đăng xuất không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
            var logoutLink = event.target.href; // Lấy liên kết đăng xuất

            // Hiển thị modal xác nhận
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();

            // Xử lý nút xác nhận đăng xuất
            document.getElementById('confirmLogoutBtn').onclick = function() {
                window.location.href = logoutLink; // Điều hướng đến liên kết đăng xuất
            }
        }
    </script>
</body>
</html>
