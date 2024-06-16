<?php
include_once __DIR__ . '/../Models/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function list() {
        $productsPerPage = 10; // Set the number of products per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalProducts = $this->productModel->getTotalProducts();
        $totalPages = ceil($totalProducts / $productsPerPage);

        $products = $this->productModel->getProductsByPage($currentPage, $productsPerPage);

        include_once __DIR__ . '/../Views/Products/list.php';
    }
    }
?>
