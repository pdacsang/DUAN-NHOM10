<?php
require_once './models/OrderModel.php';
require_once './models/CartModel.php';

class OrderController {
    private $orderModel;
    private $cartModel;

    public function __construct($db) {
        $this->orderModel = new OrderModel($db);
        $this->cartModel = new CartModel($db);
    }

    // Hiển thị trang thanh toán
    public function checkout() {
        try {
            // Lấy thông tin giỏ hàng
            $cartItems = $this->cartModel->getCartItems();
            $totalAmount = $this->cartModel->getTotalAmount();

            if (empty($cartItems)) {
                throw new Exception("Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng.");
            }

            // Hiển thị trang thanh toán
            require './views/Order.php';
        } catch (Exception $e) {
            // Hiển thị lỗi và điều hướng người dùng
            echo "<p class='error'>Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<a href='index.php?act=products' class='btn'>Quay lại mua hàng</a>";
        }
    }

    // Xử lý đặt hàng
    public function placeOrder() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Yêu cầu không hợp lệ.");
            }

            // Lấy và kiểm tra dữ liệu từ form
            $fullName = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
            $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
            $paymentMethod = filter_input(INPUT_POST, 'payment_method', FILTER_VALIDATE_INT);

            if (empty($fullName) || empty($email) || empty($phone) || empty($address) || empty($paymentMethod)) {
                throw new Exception("Vui lòng điền đầy đủ thông tin.");
            }

            // Kiểm tra định dạng email và số điện thoại
            if (!$email) {
                throw new Exception("Địa chỉ email không hợp lệ.");
            }
            if (!preg_match('/^0[0-9]{9,10}$/', $phone)) {
                throw new Exception("Số điện thoại không hợp lệ.");
            }

            // Lấy thông tin giỏ hàng
            $cartItems = $this->cartModel->getCartItems();
            if (empty($cartItems)) {
                throw new Exception("Giỏ hàng trống. Không thể tiến hành đặt hàng.");
            }

            // Tính tổng tiền
            $totalAmount = array_reduce($cartItems, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Tạo mã đơn hàng
            $orderCode = 'DH-' . time();

            // Thêm đơn hàng vào CSDL
            $orderId = $this->orderModel->createOrder([
                'ma_don_hang' => $orderCode,
                'tai_khoan_id' => $_SESSION['user_id'] ?? 0,
                'ten_nguoi_nhan' => $fullName,
                'email_nguoi_nhan' => $email,
                'sdt_nguoi_nhan' => $phone,
                'dia_chi_nguoi_nhan' => $address,
                'ngay_dat' => date('Y-m-d H:i:s'),
                'tong_tien' => $totalAmount,
                'ghi_chu' => $note,
                'phuong_thuc_thanh_toan_id' => $paymentMethod,
                'trang_thai_id' => 1,
            ]);

            if (!$orderId) {
                throw new Exception("Không thể thêm đơn hàng vào CSDL.");
            }

            // Thêm chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $this->orderModel->addOrderDetail([
                    'don_hang_id' => $orderId,
                    'san_pham_id' => $item['id'],
                    'don_gia' => $item['price'],
                    'so_luong' => $item['quantity'],
                    'thanh_tien' => $item['price'] * $item['quantity'],
                ]);
            }

            

            // Chuyển hướng tới trang thành công
            header("Location: index.php?act=orderSuccess&order_id={$orderId}");
            exit;

        } catch (Exception $e) {
            // Log lỗi nếu cần
            error_log("Lỗi đặt hàng: " . $e->getMessage());

            // Hiển thị lỗi cho người dùng
            echo "<p class='error'>Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<a href='index.php?act=checkout' class='btn'>Quay lại thanh toán</a>";
        }
    }
}
?>
