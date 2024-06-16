<?php
// Tải file Product.php để sử dụng class Product
require_once 'product.php';

// Khởi tạo đối tượng Product
$product = new Product();

// Lấy danh sách tất cả các sản phẩm
$products = $product->getAllProducts();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
<header>
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a class="text-gray-800 text-xl font-semibold" href="../../index.php">Trang Chủ</a>
                </div>
                <div class="hidden md:block">
                    <ul class="ml-4 flex items-center space-x-4">
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="list_product.php">Sản Phẩm</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="danhmuc.php">Danh Mục</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="#">Đơn Hàng</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="#">Location</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="container mx-auto mt-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-center mb-8">Danh sách sản phẩm</h1>
            <a href='themsp.php' class="block w-max mx-auto mb-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md">Thêm Sản Phẩm</a>
            <?php if (count($products) > 0): ?>
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-3">Mã Sản Phẩm</th>
                            <th class="px-4 py-3">Tên</th>
                            <th class="px-4 py-3">Ảnh</th>
                            <th class="px-4 py-3">Giá Tiền</th>
                            <th class="px-4 py-3">Ngày Thêm</th>
                            <th class="px-4 py-3">Mô Tả</th>
                            <th class="px-4 py-3">Thương Hiệu</th>
                            <th class="px-4 py-3">Sửa</th>
                            <th class="px-4 py-3">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="border px-4 py-3"><?= htmlspecialchars($product['MaSP']) ?></td>
                            <td class="border px-4 py-3"><?= htmlspecialchars($product['TenSP']) ?></td>
                            <td class="border px-4 py-3">
                                <img src="img/<?= htmlspecialchars($product['img']) ?>" width="150px" alt="<?= htmlspecialchars($product['TenSP']) ?>">
                            </td>
                            <td class="border px-4 py-3"><?= htmlspecialchars($product['DonGia']) ?></td>
                            <td class="border px-4 py-3"><?= htmlspecialchars($product['NgayTao']) ?></td>
                            <td class="border px-4 py-3"><?= htmlspecialchars($product['MoTa']) ?></td>
                            <td class="border px-4 py-3"><?= htmlspecialchars($product['TenDM']) ?></td>
                            <td class="border px-4 py-3">
                                <a href="suasp.php?MaSP=<?= $product['MaSP'] ?>" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md">Sửa</a>
                            </td>
                            <td class="border px-4 py-3">
                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" href="xoasp.php?MaSP=<?= $product['MaSP'] ?>" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md shadow-md">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-center">Không có sản phẩm nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
