<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=phpfpt';
$user = 'root';
$pass = '';

try {
    $con = new PDO($dsn, $user, $pass);
    $db = $con;
} catch (Exception $ex) {
    echo "Lỗi kết nối: " . $ex->getMessage();
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $TenSP = $_POST['TenSP'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    if (isset($_SESSION['cart'][$TenSP])) {
        $_SESSION['cart'][$TenSP] += $quantity;
    } else {
        $_SESSION['cart'][$TenSP] = $quantity;
    }
    // Chuyển hướng người dùng trở lại trang giỏ hàng sau khi thêm sản phẩm vào giỏ hàng
    header("Location: viewcart.php");
    exit();
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $TenSP = $_GET['remove'];
    unset($_SESSION['cart'][$TenSP]);
    // Chuyển hướng người dùng trở lại trang giỏ hàng sau khi xóa sản phẩm khỏi giỏ hàng
    header("Location: viewcart.php");
    exit();
}

// Hiển thị giỏ hàng
function displayCart()
{
    global $db;

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $productIds = array_keys($_SESSION['cart']);
        $placeholders = rtrim(str_repeat('?, ', count($productIds)), ', ');

        $stmt = $db->prepare("SELECT * FROM sanpham WHERE TenSP IN ($placeholders)");
        $stmt->execute($productIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalPrice = 0;

        echo '<div class="cart-container">
                <div class="cart-header">
                    <h2>Giỏ hàng</h2>
                </div>
                <div class="cart-content">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th class="product-name">Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($products as $product) {
            $quantity = $_SESSION['cart'][$product['TenSP']];
            $subtotal = $product['DonGia'] * $quantity;
            $totalPrice += $subtotal;

            echo '<tr>
                    <td class="product-name">' . $product['TenSP'] . '</td>
                    <td>' . number_format($product['DonGia']) . ' VND</td>
                    <td>' . $quantity . '</td>
                    <td>' . number_format($subtotal) . ' VND</td>
                    <td><a class="remove-btn" href="?remove=' . $product['TenSP'] . '">Xóa</a></td>
                </tr>';
        }

        echo '</tbody>
                </table>
                <div class="cart-total">
                    <span>Tổng cộng: ' . number_format($totalPrice) . ' VND</span>
                </div>
                <div class="checkout-btn">
                    <a href="thanhtoan.php?total_price=' . $totalPrice . '" class="btn btn-primary">Thanh toán</a>
                </div>
            </div>
        </div>';
    } else {
        echo '<p class="empty-cart">Giỏ hàng trống</p>';
    }

// Chuyển đổi giá trị PHP thành JavaScript để sử dụng trong mã HTML
echo '<script>var totalPrice = ' . json_encode($totalPrice) . ';</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .cart-container {
            max-width: 1200px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            background-color: #f0f0f0;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .cart-content {
            padding: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 12px 15px;
            text-align: left;
        }

        .cart-table th.product-name,
        .cart-table td.product-name {
            width: 40%;
        }

        .cart-table th {
            background-color: #f2f2f2;
            font-weight: 500;
            color: #333;
        }

        .remove-btn {
            color: red;
            cursor: pointer;
        }

        .remove-btn:hover {
            text-decoration: underline;
        }

        .empty-cart {
            font-size: 18px;
            color: #666;
            text-align: center;
            margin-top: 50px;
        }

        .cart-total {
            margin-top: 20px;
            text-align: right;
            font-size: 20px;
            font-weight: 500;
        }

        .checkout-btn {
            margin-top: 20px;
            text-align: right;
        }

        .btn-primary {
            background-color: #ee4d2d;
            border-color: #ee4d2d;
        }

        .btn-primary:hover {
            background-color: #d43a1d;
            border-color: #d43a1d;
        }
    </style>
</head>
<body class="bg-gray-100">
     <!-- Navbar -->
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
    <div id="bannerCarousel" class="carousel slide banner" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/iphone.jpg" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 1</h5>
                    <p>Subtitle or description for Image 1</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/iphone.jpg" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 2</h5>
                    <p>Subtitle or description for Image 2</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/iphone.jpg" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption for Image 3</h5>
                    <p>Subtitle or description for Image 3</p>
                </div>
            </div>
        </div>
    </div>

<?php displayCart(); ?>

<h2 class="mt-8 text-center mb-4 "><a href="../../index.php" class="text-blue-500 ">Trở Về Trang Chủ</a></h2>

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

</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>