<?php
require_once '../Controllers/AdminController.php';

$adminController = new AdminController();
$adminController->render();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
        // Đảm bảo rằng tham số 'page_layout' đã được truyền và xử lý nó
        if(isset($_GET['page_layout'])){
            switch($_GET['page_layout']){
                case 'them':
                    require_once 'sanpham/them.php'; // Hiển thị trang thêm sản phẩm
                    break;

                case 'sua':
                    require_once 'sanpham/sua.php'; // Hiển thị trang sửa sản phẩm
                    break;

                case 'xoa':
                    require_once 'sanpham/xoa.php'; // Hiển thị trang xóa sản phẩm
                    break;

                default:
                    require_once 'views/admin/list_product.php'; // Mặc định, hiển thị danh sách sản phẩm
                    break;
            } 
        } else {
            require_once 'views/admin/list_product.php'; // Nếu không có tham số 'page_layout', hiển thị danh sách sản phẩm
        }
    ?>    
</body>
</html>
