<?php
require_once './models/OrderModel.php';

class OrderController {
    private $db;
    private $orderModel;

    public function __construct($db) {
        $this->db = $db;
        $this->orderModel = new OrderModel($db);
    }

    // Hiển thị form nhập thông tin đặt hàng
    public function orderForm() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        include './views/Order.php';
    }

    // Xử lý đặt hàng
    public function placeOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            echo "Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.";
            return;
        }

        // Lấy dữ liệu từ form
        $recipientName = $_POST['recipient_name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;
        $paymentMethodId = $_POST['payment_method'] ?? 1;

        // Kiểm tra dữ liệu đầu vào
        if (!$recipientName || !$email || !$phone || !$address) {
            echo "Vui lòng nhập đầy đủ thông tin.";
            return;
        }

        // Tính tổng tiền
        $totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        if ($totalAmount <= 0) {
            echo "Tổng tiền không hợp lệ.";
            return;
        }

        try {
            // Tạo đơn hàng
            $userId = $_SESSION['user_id'] ?? null;
            $orderId = $this->orderModel->createOrder(
                $totalAmount,
                1, // Trạng thái mặc định "Chờ xử lý"
                $paymentMethodId,
                $userId,
                $recipientName,
                $email,
                $phone,
                $address
            );

            // Thêm chi tiết đơn hàng
            foreach ($cart as $item) {
                $this->orderModel->addOrderDetails(
                    $orderId,
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );
            }

            // Đặt hàng thành công
            echo "Đặt hàng thành công. Mã đơn hàng: " . $orderId;

            // Xóa giỏ hàng sau khi đặt hàng
            unset($_SESSION['cart']);
        } catch (Exception $e) {
            echo "Lỗi khi xử lý đơn hàng: " . htmlspecialchars($e->getMessage());
        }
    }

    // Xác nhận đơn hàng
    public function confirmOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            echo "Không tìm thấy mã đơn hàng.";
            return;
        }

        try {
            // Lấy thông tin đơn hàng và chi tiết
            $order = $this->orderModel->getOrder($orderId);
            $orderDetails = $this->orderModel->getOrderDetails($orderId);

            include './views/confirm_order.php';
        } catch (Exception $e) {
            echo "Lỗi khi lấy thông tin đơn hàng: " . htmlspecialchars($e->getMessage());
        }
    }
}
