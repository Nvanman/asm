<?php
session_start();
include_once __DIR__ . '/../Models/TaiKhoan.php';

class LoginController {
    private $taiKhoanModel;

    public function __construct() {
        $this->taiKhoanModel = new TaiKhoan();
    }

    public function login() {
        $error = '';

        if (isset($_POST["btn_submit"])) {
            $tenTK = strip_tags(addslashes($_POST["TenTK"]));
            $matKhau = strip_tags(addslashes($_POST["MatKhau"]));

            if ($tenTK == "" || $matKhau == "") {
                $error = "Tên tài khoản hoặc mật khẩu không được để trống!";
            } else {
                $taiKhoan = $this->taiKhoanModel->getTaiKhoan($tenTK, $matKhau);

                if ($taiKhoan == null) {
                    $error = "Tên tài khoản hoặc mật khẩu không đúng!";
                } else {
                    $_SESSION['tenTK'] = $tenTK;
                    $_SESSION['Role'] = $taiKhoan['Role'];

                    if ($taiKhoan['Role'] == 'admin') {
                        header('Location: ../Views/admin/list_product.php');
                        exit;
                    } else {
                        header('Location: ../index.php');
                        exit;
                    }
                }
            }
        }

        include_once __DIR__ . '/../Views/login.php';
    }
}

$controller = new LoginController();
$controller->login();
?>
