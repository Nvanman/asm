<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Tạo kết nối
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Thiết lập chế độ lỗi PDO
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy dữ liệu từ bảng "danhmuc"
    $sql_brand = "SELECT * FROM danhmuc";
    $query_brand = $connect->query($sql_brand);

    // Xử lý dữ liệu được gửi từ form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $MaSP = $_POST['MaSP'];
        $TenSP = $_POST['TenSP'];
        $DonGia = $_POST['DonGia'];
        $MoTa = $_POST['MoTa'];

        // Kiểm tra và gán giá trị cho $MaDM
        if (isset($_POST['MaDM']) && $_POST['MaDM'] !== '') {
            $MaDM = $_POST['MaDM'];
        } else {
            $MaDM = 1; // Gán giá trị mặc định
        }

        // Xử lý file upload
        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $img = $_FILES['img']['name'];
            $target_dir = "img/";
            $target_file = $target_dir . basename($img);
            move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
        } else {
            $img = ""; // Giá trị mặc định nếu không có ảnh được tải lên
        }

        // Kiểm tra nếu MaSP đã tồn tại
        $check_sql = "SELECT COUNT(*) FROM sanpham WHERE MaSP = :MaSP";
        $stmt = $connect->prepare($check_sql);
        $stmt->bindParam(':MaSP', $MaSP);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Thực hiện câu INSERT INTO
            $sql = "INSERT INTO sanpham (MaSP, TenSP, img, DonGia, MoTa, MaDM) 
                    VALUES (:MaSP, :TenSP, :img, :DonGia, :MoTa, :MaDM)";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':MaSP', $MaSP);
            $stmt->bindParam(':TenSP', $TenSP);
            $stmt->bindParam(':img', $img);
            $stmt->bindParam(':DonGia', $DonGia);
            $stmt->bindParam(':MoTa', $MoTa);
            $stmt->bindParam(':MaDM', $MaDM);

            if ($stmt->execute()) {
                echo "Thêm sản phẩm thành công!";
            } else {
                echo "Lỗi: Không thể thêm sản phẩm";
            }
        } else {
            echo "Lỗi: Mã sản phẩm đã tồn tại!";
        }
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}

// Đóng kết nối cơ sở dữ liệu
$connect = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
<div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Thêm Sản Phẩm</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="MaSP" class="block text-sm font-medium text-gray-600">Mã Sản Phẩm</label>
                    <input type="text" name="MaSP" id="MaSP" class="form-input mt-1 block w-full border-gray-300 rounded-md focus:border-indigo-600" required>
                </div>
                <div class="mb-4">
                    <label for="TenSP" class="block text-sm font-medium text-gray-600">Tên Sản Phẩm</label>
                    <input type="text" name="TenSP" id="TenSP" class="form-input mt-1 block w-full border-gray-300 rounded-md focus:border-indigo-600" required>
                </div>
                <div class="mb-4">
                    <label for="img" class="block text-sm font-medium text-gray-600">Ảnh Sản Phẩm</label>
                    <input type="file" name="img" id="img" class="form-input mt-1 block w-full border-gray-300 rounded-md focus:border-indigo-600">
                </div>
                <div class="mb-4">
                    <label for="DonGia" class="block text-sm font-medium text-gray-600">Giá Sản Phẩm</label>
                    <input type="number" name="DonGia" id="DonGia" class="form-input mt-1 block w-full border-gray-300 rounded-md focus:border-indigo-600" required>
                </div>
                <div class="mb-4">
                    <label for="MoTa" class="block text-sm font-medium text-gray-600">Mô Tả Sản Phẩm</label>
                    <input type="text" name="MoTa" id="MoTa" class="form-input mt-1 block w-full border-gray-300 rounded-md focus:border-indigo-600" required>
                </div>
                <div class="mb-4">
                    <label for="MaDM" class="block text-sm font-medium text-gray-600">Thương Hiệu</label>
                    <select class="form-select mt-1 block w-full border-gray-300 rounded
                    -md focus:border-indigo-600" name="MaDM" id="MaDM">
                        <?php while ($row_brand = $query_brand->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $row_brand['MaDM'] ?>"><?= $row_brand['TenDM'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" name="sbm" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
