<?php 

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';


// Require toàn bộ file Models
require_once './models/SanPham.php';

// Route
$act = $_GET['act'] ?? '/';

// Sử dụng match để route các chức năng
match ($act) {
    // Trang chủ
    '/' => (new HomeController())->home(),

};
