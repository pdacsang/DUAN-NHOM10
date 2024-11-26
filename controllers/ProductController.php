<?php
require_once './models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($dbConnection) {
        $this->productModel = new ProductModel($dbConnection);
    }

    // Hiển thị danh sách sản phẩm
    public function showProductList() {
        $products = $this->productModel->getAllProducts();
        $categories = $this->productModel->getAllCategories();
        require_once './views/listProduct.php'; // Gọi view để hiển thị sản phẩm
    }

    // Hiển thị sản phẩm theo danh mục
    public function showProductsByCategory() {
        $categoryId = $_GET['danh_muc_id'] ?? null;
        $categories = $this->productModel->getAllCategories();
        if ($categoryId && is_numeric($categoryId)) {
            $products = $this->productModel->getProductsByCategory((int) $categoryId);
        } else {
            $products = $this->productModel->getAllProducts();
        }
        require_once './views/listProduct.php';
    }

    // Hiển thị chi tiết sản phẩm
    public function showProductDetail() {
        $productId = $_GET['id'] ?? null;
        if (!$productId || !is_numeric($productId)) {
            echo "ID sản phẩm không hợp lệ.";
            return;
        }
        $product = $this->productModel->getProductById((int) $productId);
        if ($product) {
            require_once './views/detailsProduct.php';
        } else {
            echo "Sản phẩm không tồn tại.";
        }
    }
}
?>
