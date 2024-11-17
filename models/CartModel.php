<?php

class CartModel {
    

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($productId, $productName, $price, $quantity, $image = 'images/default.jpg') {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        // Nếu sản phẩm đã tồn tại, chỉ cập nhật số lượng
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            // Thêm sản phẩm mới
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $image,
            ];
        }
    
        $this->updateCartTotalQuantity();
        $this->updateUniqueProductCount();
    }

    // Cập nhật tổng số lượng tất cả các sản phẩm
    private function updateCartTotalQuantity() {
        $_SESSION['cart_total_quantity'] = array_sum(array_column($_SESSION['cart'], 'quantity'));
    }

    // Lấy số lượng các sản phẩm khác nhau trong giỏ hàng
    public function updateUniqueProductCount() {
        $_SESSION['cart_unique_count'] = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    }

    // Lấy số lượng sản phẩm khác nhau
    public function getUniqueProductCount() {
        return $_SESSION['cart_unique_count'] ?? 0;
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    public function getCartItems() {
        return $_SESSION['cart'] ?? [];
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateProductQuantity($productId, $quantity) {
        if (isset($_SESSION['cart'][$productId])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
                $this->updateCartTotalQuantity();
                return true;
            } else {
                unset($_SESSION['cart'][$productId]);
                $this->updateUniqueProductCount();
                return true;
            }
        }
        return false;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            $this->updateCartTotalQuantity();
            $this->updateUniqueProductCount();
        }
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart() {
        unset($_SESSION['cart']);
        $_SESSION['cart_total_quantity'] = 0;
        $_SESSION['cart_unique_count'] = 0;
    }

    // Tính tổng tiền giỏ hàng
    public function getTotalAmount() {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }

    // Thêm sản phẩm từ cơ sở dữ liệu
    public function addProductToCartFromDB($productId, $quantity) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            // Tìm sản phẩm từ cơ sở dữ liệu
            $productModel = new ProductModel(connectDB());
            $product = $productModel->getProductById($productId);

            if ($product) {
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['ten_sach'],
                    'price' => $product['gia_sach'],
                    'image' => $product['hinh_anh'],
                    'quantity' => $quantity,
                ];
                $this->updateCartTotalQuantity();
                $this->updateUniqueProductCount();
            }
        }
    }
}
?>
