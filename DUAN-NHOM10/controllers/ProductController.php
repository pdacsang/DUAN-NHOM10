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
        $comments = $this->productModel->getCommentsByProductId((int) $productId); // Lấy bình luận
        if ($product) {
            require_once './views/detailsProduct.php';
        } else {
            echo "Sản phẩm không tồn tại.";
        }
    }

    // Bình luận
     // Thêm bình luận mới
     public function addComment() {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION['user_client'])) {
            echo "Bạn cần đăng nhập để bình luận.";
            return;
        }
        // Lấy dữ liệu từ form gửi lên
        $productId = $_POST['product_id'] ?? null;
        $userId = $_SESSION['user_client']['id']; // Lấy user_id từ session
        $commentContent = $_POST['comm_details'] ?? null;
        // Kiểm tra dữ liệu
        if (!$productId || !$userId || !$commentContent) {
            echo "Dữ liệu bình luận không hợp lệ.";
            return;
        }
        // Thêm bình luận vào cơ sở dữ liệu
        $status = $this->productModel->addComment($productId, $userId, $commentContent);
    
        if ($status) {
            // Redirect lại trang chi tiết sản phẩm sau khi thêm bình luận
            header("Location: " . BASE_URL . "?act=showProductDetail&id=" . $productId);
            exit();
        } else {
            echo "Có lỗi khi thêm bình luận.";
        }
    }
}
?>
