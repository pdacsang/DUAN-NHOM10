<?php
session_start(); // Bắt đầu session

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/ProductController.php'; 
require_once './controllers/CartController.php'; // Thêm CartController

// Require toàn bộ file Models
require_once './models/ProductModel.php'; // Model sản phẩm
require_once './models/SanPham.php';

// Tạo kết nối cơ sở dữ liệu
$dbConnection = connectDB();

// Route
$act = $_GET['act'] ?? '/';

$result = match ($act) {
    // Trang chủ
    '/' => (new HomeController())->home(),

    // Chi tiết sản phẩm
    'showProductDetail' => (new ProductController($dbConnection))->showProductDetail(),

    // Danh sách sản phẩm
    'productList' => function () use ($dbConnection) {
        $controller = new ProductController($dbConnection);
        $controller->showProductList();
    },

    // Sản phẩm theo danh mục
    'productByCategory' => function () use ($dbConnection) {
        $controller = new ProductController($dbConnection);
        $controller->showProductsByCategory();
    },

    // Xử lý khi không tìm thấy action
    default => function() {
        http_response_code(404); // Đặt mã trạng thái HTTP là 404
        echo "Action không hợp lệ hoặc không tồn tại.";
    }
};

// Gọi kết quả nếu là callback
if (is_callable($result)) {
    $result();
}
?>
