<?php
class CartController {
    public function index() {
        // Hiển thị trang giỏ hàng
        include 'views/Cart.php';
    }

    public function add($product_id, $quantity = 1) {
        // Thêm sản phẩm vào giỏ hàng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        header('Location: index.php?controller=cart');
    }

    public function update() {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['quantity'] as $product_id => $quantity) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$product_id] = $quantity;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        }
        header('Location: index.php?controller=cart');
    }

    public function remove($product_id) {
        // Xóa sản phẩm khỏi giỏ hàng
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        header('Location: index.php?controller=cart');
    }
}