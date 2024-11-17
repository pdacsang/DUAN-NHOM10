<?php
require_once './models/CartModel.php';
require_once './models/ProductModel.php';

class CartController {
    private $cartModel;
    private $productModel;
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection; // Kết nối cơ sở dữ liệu
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel($this->conn); // Khởi tạo với kết nối CSDL
    }

    // Hiển thị giỏ hàng
    public function viewCart() {
        try {
            $cartItems = $this->cartModel->getCartItems();
            $totalAmount = $this->cartModel->getTotalAmount();
            $uniqueProductCount = $this->cartModel->getUniqueProductCount(); // Số lượng sản phẩm khác nhau
            require_once './views/cart.php';
        } catch (Exception $e) {
            $this->logError($e);
            echo "Không thể hiển thị giỏ hàng.";
        }
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart() {
        try {
            // Lấy ID sản phẩm và số lượng từ request
            $productId = $_GET['id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
    
            // Kiểm tra đầu vào
            if ($productId && is_numeric($quantity) && $quantity > 0) {
                // Lấy thông tin sản phẩm từ ProductModel
                $product = $this->productModel->getProductById($productId);
    
                if ($product) {
                    // Thêm sản phẩm vào giỏ hàng với thông tin đầy đủ, bao gồm hình ảnh
                    $this->cartModel->addToCart(
                        $product['id'],          // ID sản phẩm
                        $product['ten_sach'],    // Tên sản phẩm
                        $product['gia_sach'],    // Giá sản phẩm
                        (int)$quantity,          // Số lượng
                        $product['hinh_anh'] ?? 'images/default.jpg' // Hình ảnh, mặc định nếu không có
                    );
    
                    // Chuyển hướng về trang giỏ hàng
                    header("Location: index.php?act=viewCart");
                    exit();
                } else {
                    // Nếu sản phẩm không tồn tại
                    throw new Exception("Sản phẩm không tồn tại.");
                }
            } else {
                // Thông tin không hợp lệ
                throw new Exception("Thông tin không hợp lệ.");
            }
        } catch (Exception $e) {
            // Ghi log và hiển thị lỗi
            $this->logError($e);
            echo "Không thể thêm sản phẩm vào giỏ hàng: " . $e->getMessage();
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng (AJAX)
    public function updateCart() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $productId = $data['product_id'] ?? null;
                $quantity = $data['quantity'] ?? null;

                if ($productId && is_numeric($quantity) && $quantity >= 0) {
                    $success = $this->cartModel->updateProductQuantity((int)$productId, (int)$quantity);
                    $cartItems = $this->cartModel->getCartItems();
                    $uniqueProductCount = $this->cartModel->getUniqueProductCount(); // Số sản phẩm khác nhau

                    // Lấy tổng giá cho từng sản phẩm và toàn bộ giỏ hàng
                    $itemTotal = $cartItems[$productId]['price'] * $cartItems[$productId]['quantity'];
                    $totalAmount = $this->cartModel->getTotalAmount();

                    echo json_encode([
                        'success' => $success,
                        'itemTotal' => $itemTotal,
                        'totalAmount' => $totalAmount,
                        'uniqueProductCount' => $uniqueProductCount // Trả về số sản phẩm khác nhau
                    ]);
                    return;
                } else {
                    throw new Exception("Dữ liệu không hợp lệ.");
                }
            }
        } catch (Exception $e) {
            $this->logError($e);
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart() {
        try {
            $productId = $_GET['id'] ?? null;

            if ($productId) {
                $this->cartModel->removeFromCart((int)$productId);
            }

            // Chuyển hướng về giỏ hàng
            header("Location: index.php?act=viewCart");
            exit();
        } catch (Exception $e) {
            $this->logError($e);
            echo "Không thể xóa sản phẩm khỏi giỏ hàng.";
        }
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart() {
        try {
            $this->cartModel->clearCart();
            
            // Chuyển hướng về giỏ hàng
            header("Location: index.php?act=viewCart");
            exit();
        } catch (Exception $e) {
            $this->logError($e);
            echo "Không thể xóa toàn bộ giỏ hàng.";
        }
    }

    // Lấy số lượng sản phẩm khác nhau trong giỏ hàng (Dùng cho hiển thị trên mọi trang)
    public function getUniqueProductCount() {
        return $this->cartModel->getUniqueProductCount();
    }

    // Ghi log lỗi
    private function logError($exception) {
        file_put_contents('./logs/error.log', date('Y-m-d H:i:s') . ' - ' . $exception->getMessage() . PHP_EOL, FILE_APPEND);
    }
}
?>
