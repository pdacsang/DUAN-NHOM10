<?php 

session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminSanPhamControllrer.php';
// require_once './controllers/AdminDonHangController.php';


// Require toàn bộ file Models
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanPham.php';
// require_once './models/AdminDonHang.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    // Danh mục
    'danh-muc' => (new AdminDanhMucController()) -> danhSachDanhMuc(),   
    'form-them-danh-muc' => (new AdminDanhMucController()) -> formAddDanhMuc(),   
    'them-danh-muc' => (new AdminDanhMucController()) -> postAddDanhMuc(),   
    'form-sua-danh-muc' => (new AdminDanhMucController()) -> formEditDanhMuc(),   
    'sua-danh-muc' => (new AdminDanhMucController()) -> postEditDanhMuc(),   
    'xoa-danh-muc' => (new AdminDanhMucController()) -> deleteDanhMuc(),   
    // Sản phẩm
    'san-pham' => (new AdminSanPhamController()) -> danhSachSanPham(),   
    'form-them-san-pham' => (new AdminSanPhamController()) -> formAddSanPham(),   
    'them-san-pham' => (new AdminSanPhamController()) -> postAddSanPham(),   
    // 'form-sua-san-pham' => (new AdminSanPhamController()) -> formEditSanPham(),   
    // 'sua-san-pham' => (new AdminSanPhamController()) -> postEditSanPham(),   
    // 'xoa-san-pham' => (new AdminSanPhamController()) -> deleteSanPham(),   

    
};