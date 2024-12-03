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
        try {
            $categoryId = $_GET['danh_muc_id'] ?? null;
            $currentPage = $_GET['page'] ?? 1;
            $perPage = 9;
            $offset = ($currentPage - 1) * $perPage;
    
            $categories = $this->productModel->getAllCategories();
    
            if ($categoryId) {
                $productsData = $this->productModel->getProductsByCategoryWithPagination($categoryId, $offset, $perPage);
            } else {
                $productsData = $this->productModel->getAllProductsWithPagination($offset, $perPage);
            }
    
            $products = $productsData['products'];
            $totalProducts = $productsData['total'];
            $totalPages = ceil($totalProducts / $perPage);
    
            require_once './views/listProduct.php';
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            file_put_contents('./logs/error.log', date('Y-m-d H:i:s') . ' - Lỗi showProductsByCategory: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
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
