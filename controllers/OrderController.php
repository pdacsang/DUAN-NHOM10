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

        // Kiểm tra nếu giỏ hàng trống
        if (empty($_SESSION['cart'])) {
            echo "Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.";
            return;
        }

        include './views/Order.php';
    }

    // Xử lý thanh toán và đặt hàng
    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra nếu thanh toán từ sản phẩm chi tiết
        if (isset($_POST['product_id'])) {
            // Thanh toán từ chi tiết sản phẩm
            $product = [
                'id' => $_POST['product_id'],
                'name' => $_POST['product_name'],
                'price' => $_POST['product_price'],
                'quantity' => $_POST['product_quantity'],
            ];
            $cart = [$product]; // Tạo giỏ hàng tạm thời
            $totalAmount = $product['price'] * $product['quantity'];
        } else {
            // Thanh toán từ giỏ hàng
            $cart = $_SESSION['cart'] ?? [];
            $totalAmount = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));
        }

        // Lấy dữ liệu từ form
        $recipientName = $_POST['recipient_name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;
        $orderNote = $_POST['note'] ?? null;
        $paymentMethodId = $_POST['payment_method'] ?? 1; // Mặc định là thanh toán COD

        // Lấy `userId` từ session
        $userId = $_SESSION['user_client']['id'] ?? null;

        // Kiểm tra dữ liệu đầu vào
        if (!$userId || !$recipientName || !$email || !$phone || !$address) {
            $error_message = "Vui lòng nhập đầy đủ thông tin.";
            include './views/Order.php';
            return;
        }

        if ($totalAmount <= 0) {
            $error_message = "Tổng tiền không hợp lệ.";
            include './views/Order.php';
            return;
        }

        try {
            // Tạo đơn hàng
            $orderId = $this->orderModel->createOrder($totalAmount, 1, $paymentMethodId, $userId, $recipientName, $email, $phone, $address, $orderNote);

            // Thêm chi tiết đơn hàng
            foreach ($cart as $item) {
                $this->orderModel->addOrderDetails($orderId, $item['id'], $item['quantity'], $item['price']);
            }

            // Nếu thanh toán từ giỏ hàng, xóa giỏ hàng
            if (!isset($_POST['product_id'])) {
                unset($_SESSION['cart']);
            }

            // Kiểm tra phương thức thanh toán
            if ($paymentMethodId == 2) { // 2: Thanh toán VNPay
                $this->createVNPayPaymentRequest($orderId, $totalAmount, $recipientName, $email, $phone, $address, $orderNote);
                return; // Dừng tại đây vì đã chuyển hướng đến VNPay
            }

            // Thanh toán COD (mặc định)
            header("Location: index.php?act=orderSuccess");
            exit();
        } catch (Exception $e) {
            // Xử lý lỗi
            $error_message = "Lỗi khi xử lý đơn hàng: " . $e->getMessage();
            include './views/Order.php';
        }
    }

    // Thanh toán từ chi tiết sản phẩm
    public function checkoutFromProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy thông tin sản phẩm từ form
            $productId = $_POST['product_id'] ?? null;
            $productName = $_POST['product_name'] ?? null;
            $productPrice = $_POST['product_price'] ?? null;
            $productQuantity = $_POST['product_quantity'] ?? 1;

            // Kiểm tra dữ liệu
            if (!$productId || !$productName || !$productPrice) {
                echo "Thông tin sản phẩm không hợp lệ.";
                return;
            }

            // Chuẩn bị dữ liệu để hiển thị trên trang thanh toán
            $product = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQuantity,
            ];

            // Chuyển đến trang thanh toán
            $isSingleProduct = true; // Đánh dấu là thanh toán từ sản phẩm chi tiết
            include './views/Checkout.php';
        } else {
            echo "Phương thức không hợp lệ.";
        }
    }

    public function createVNPayPaymentRequest($orderId, $totalAmount, $recipientName, $email, $phone, $address, $orderNote) {
        $vnp_TmnCode = "31DQ0GI0";  
        $vnp_HashSecret = "W4J1L035O98GIOWPIJUIUDL7D61VFXC5"; 
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";  
        $vnp_Returnurl = "http://localhost:81/";

        $vnp_TxnRef = $orderId;
        $vnp_OrderInfo = $_POST['order_desc'] ?? 'No description provided';
        $vnp_OrderType = $_POST['order_type'] ?? 'other';
        $vnp_Amount = $totalAmount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $hashdata = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        $vnp_Url .= "?" . $hashdata . "&vnp_SecureHash=" . $vnpSecureHash;

        header('Location: ' . $vnp_Url);
        die();
    }

    public function orderSuccess() {
        include './views/OrderSuccess.php'; 
    }
}
