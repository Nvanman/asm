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
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Shop Điện Thoại</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .card {
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.05);
}

    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">Shop Điện Thoại</div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="sanpham.php">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Liên hệ</a></li>
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
            </nav>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm...">
                <button class="btn btn-outline-light" type="submit">Tìm</button>
            </form>
        </div>
    </header>
    
    <section id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="trangchu/img/iphone.jpg" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Chào mừng đến với Shop Điện Thoại</h5>
                    <p>Nơi cung cấp những sản phẩm điện thoại chính hãng với giá tốt nhất.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="trangchu/img/samsung.webp" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Sản phẩm mới nhất</h5>
                    <p>Cập nhật các mẫu điện thoại mới nhất trên thị trường.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="trangchu/img/iphone15.png" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Khuyến mãi đặc biệt</h5>
                    <p>Những ưu đãi hấp dẫn chỉ có tại Shop Điện Thoại.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <section class="about py-5">
        <div class="container">
            <h2 class="text-center mb-4">Về chúng tôi</h2>
            <p class="lead text-center">Shop Điện Thoại cung cấp những sản phẩm điện thoại chính hãng từ các thương hiệu nổi tiếng với giá cả phải chăng. Chúng tôi cam kết mang đến cho khách hàng những trải nghiệm mua sắm tốt nhất cùng các chương trình khuyến mãi hấp dẫn.</p>
        </div>
    </section>

    <section class="best-sellers py-5 bg-light">
        <div class="container">
            
            <h2 class="text-center mb-4">Sản phẩm bán chạy</h2>
            <div class="text-center mt-4">
            <a href="sanpham.php" class="btn btn-primary mb-4">Xem thêm sản phẩm</a>
        </div>
    </div>
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
    </section>

    <section class="featured-products py-5">
        <div class="container">
            <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="Views/admin/img/22.jpeg" class="card-img-top" alt="Phone 5">
                        <div class="card-body">
                            <h5 class="card-title">Điện thoại 5</h5>
                            <p class="card-text">Giá: 20,000,000 VND</p>
                            <a href="#" class="btn btn-primary">Chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="Views/admin/img/22.jpeg" class="card-img-top" alt="Phone 6">
                        <div class="card-body">
                            <h5 class="card-title">Điện thoại 6</h5>
                            <p class="card-text">Giá: 22,000,000 VND</p>
                            <a href="#" class="btn btn-primary">Chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="Views/admin/img/22.jpeg" class="card-img-top" alt="Phone 7">
                        <div class="card-body">
                            <h5 class="card-title">Điện thoại 7</h5>
                            <p class="card-text">Giá: 25,000,000 VND</p>
                            <a href="#" class="btn btn-primary">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="news py-5">
        <div class="container">
            <h2 class="text-center mb-4">Tin Tức Mới Nhất</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="Views/admin/img/tintuc.png" class="card-img-top" alt="Tin tức 1">
                        <div class="card-body">
                            <h5 class="card-title">Tiêu đề tin tức 1</h5>
                            <p class="card-text">Mô tả ngắn về tin tức 1...</p>
                            <a href="trangchu/news1.php" class="btn btn-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="Views/admin/img/tintuc.png" class="card-img-top" alt="Tin tức 2">
                        <div class="card-body">
                            <h5 class="card-title">Tiêu đề tin tức 2</h5>
                            <p class="card-text">Mô tả ngắn về tin tức 2...</p>
                            <a href="news2.html" class="btn btn-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="Views/admin/img/tintuc.png" class="card-img-top" alt="Tin tức 3">
                        <div class="card-body">
                            <h5 class="card-title">Tiêu đề tin tức 3</h5>
                            <p class="card-text">Mô tả ngắn về tin tức 3...</p>
                            <a href="news3.html" class="btn btn-primary">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="subscribe py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Đăng ký nhận bản tin</h2>
            <form class="d-flex justify-content-center">
                <input type="email" class="form-control w-50 me-2" placeholder="Nhập email của bạn">
                <button class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </section>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: contact@shopdienthoai.com</p>
                    <p>Điện thoại: 0123-456-789</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Trang chủ</a></li>
                        <li><a href="#" class="text-white">Sản phẩm</a></li>
                        <li><a href="#" class="text-white">Giới thiệu</a></li>
                        <li><a href="#" class="text-white">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <p class="text-center mt-3">&copy; 2024 Shop Điện Thoại. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
