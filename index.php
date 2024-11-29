<?php
// Bắt đầu session (nếu chưa bắt đầu)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/ProductController.php';
require_once './controllers/SearchController.php'; 
require_once './controllers/CartController.php'; 
require_once './controllers/OrderController.php'; 

// Require toàn bộ file Models
require_once './models/ProductModel.php'; 
require_once './models/CartModel.php';    
require_once './models/OrderModel.php';   

// Kết nối cơ sở dữ liệu
$dbConnection = connectDB();
if (!$dbConnection) {
    die("Không thể kết nối đến cơ sở dữ liệu.");
}

// Nhận hành động từ URL (Route)
$act = $_GET['act'] ?? '/'; // Nếu không có act, mặc định là trang chủ

// Danh sách route
$routes = [
    '/' => [HomeController::class, 'home'],
    'showProductDetail' => [ProductController::class, 'showProductDetail'],
    'productList' => [ProductController::class, 'showProductList'],
    'productByCategory' => [ProductController::class, 'showProductsByCategory'],
    'search' => [SearchController::class, 'handleSearch'],
    'addToCart' => [CartController::class, 'addToCart'],
    'viewCart' => [CartController::class, 'viewCart'],
    'updateCart' => function () use ($dbConnection) {
        header('Content-Type: application/json');
        (new CartController($dbConnection))->updateCart();
    },
    'removeFromCart' => [CartController::class, 'removeFromCart'],

    // Thêm route mới cho đặt hàng và thanh toán
    'checkout' => [OrderController::class, 'checkout'], // Xử lý thanh toán
    'confirmOrder' => [OrderController::class, 'confirmOrder'], // Xác nhận đơn hàng
    'placeOrder' => [OrderController::class, 'placeOrder'],
    'order' => [OrderController::class, 'orderForm'],
    'orderSuccess' => [OrderController::class, 'orderSuccess'],
];

// Kiểm tra và xử lý route
try {
    if (isset($routes[$act])) {
        $handler = $routes[$act];

        // Kiểm tra nếu handler là callable (hàm hoặc closure)
        if (is_callable($handler)) {
            $handler(); // Gọi route dạng hàm
        } else {
            // Nếu là controller/method
            [$class, $method] = $handler;

            // Kiểm tra tồn tại class và method
            if (class_exists($class) && method_exists($class, $method)) {
                (new $class($dbConnection))->$method(); // Gọi route dạng class/method
            } else {
                throw new Exception("Controller hoặc method không tồn tại: {$class}::{$method}");
            }
        }
    } else {
        // Nếu không tìm thấy route, trả về lỗi 404
        http_response_code(404);
        include './404error.php'; // Trang lỗi 404
    }
} catch (Exception $e) {
    // Xử lý ngoại lệ
    http_response_code(500); // Lỗi máy chủ
    if (getenv('APP_ENV') === 'development') {
        echo "Đã xảy ra lỗi: " . htmlspecialchars($e->getMessage());
    } else {
        echo "Lỗi hệ thống. Vui lòng thử lại sau.";
        // Log lỗi vào file (hoặc hệ thống log)
        error_log($e->getMessage());
    }
}
