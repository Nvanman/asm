<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">Shop Điện Thoại</div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Sản phẩm</a></li>
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

    <section class="news-detail py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h1 class="text-center mb-4">Tiêu đề tin tức 1</h1>
                    <img src="../Views/admin/img/tintuc.png" class="img-fluid mb-4" alt="Tin tức 1">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id ante id arcu condimentum mollis. Quisque suscipit elit a tristique pellentesque. Phasellus sed nisl id justo varius consectetur. Sed aliquam magna in justo fermentum vestibulum.</p>
                    <p>Etiam nec convallis ex. Nulla eget elit id ex interdum lacinia. Proin tincidunt sapien sed tortor posuere, eget egestas justo rhoncus. Curabitur eleifend felis nec congue commodo. Fusce vestibulum dignissim odio, in tincidunt enim facilisis eget. Sed eget neque id nisl laoreet lacinia a vitae enim.</p>
                    <p>Quisque nec justo consequat, mollis magna eu, pellentesque lectus. Fusce at dignissim nunc. Mauris mollis sem vel arcu pharetra bibendum. Phasellus egestas aliquet sapien, vitae consectetur justo lobortis sit amet. Aenean nec ipsum id arcu efficitur tempor nec a urna.</p>
                </div>
            </div>
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
