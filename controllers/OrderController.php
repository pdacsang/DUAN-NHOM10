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
    
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $error_message = "Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.";
            include './views/Order.php';
            return;
        }
    
        // Lấy dữ liệu từ form
        $recipientName = $_POST['recipient_name'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;
        $paymentMethodId = $_POST['payment_method'] ?? 1; // Mặc định là thanh toán COD
    
        // Kiểm tra dữ liệu đầu vào
        if (!$recipientName || !$email || !$phone || !$address) {
            $error_message = "Vui lòng nhập đầy đủ thông tin.";
            include './views/Order.php';
            return;
        }
    
        // Tính tổng tiền
        $totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        if ($totalAmount <= 0) {
            $error_message = "Tổng tiền không hợp lệ.";
            include './views/Order.php';
            return;
        }
    
        try {
            // Tạo đơn hàng
            $orderId = $this->orderModel->createOrder($totalAmount, 1, $paymentMethodId, 1, $recipientName, $email, $phone, $address);
    
            // Thêm chi tiết đơn hàng
            foreach ($cart as $item) {
                $this->orderModel->addOrderDetails($orderId, $item['id'], $item['quantity'], $item['price']);
            }
    
            // Xóa giỏ hàng sau khi đặt hàng thành công
            unset($_SESSION['cart']);
    
            // Kiểm tra phương thức thanh toán
            if ($paymentMethodId == 2) { // 2: Thanh toán VNPay
                $this->createVNPayPaymentRequest($orderId, $totalAmount, $recipientName, $email, $phone, $address);
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
    // Tạo yêu cầu thanh toán VNPay
    public function createVNPayPaymentRequest($orderId, $totalAmount, $recipientName, $email, $phone, $address) {
        // Dữ liệu từ hệ thống của bạn
        $vnp_TmnCode = "31DQ0GI0";  // Mã Merchant của bạn
        $vnp_HashSecret = "W4J1L035O98GIOWPIJUIUDL7D61VFXC5"; // Khóa bí mật của bạn
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";  // URL thanh toán VNPay
        $vnp_Returnurl = "http://localhost:81/";  // Địa chỉ trả về sau khi thanh toán

        // Sử dụng order_id đã tạo từ trước
        $vnp_TxnRef = $orderId;  // Truyền order_id từ PHP vào VNPay
        $vnp_OrderInfo = $_POST['order_desc'] ?? 'No description provided';  // Mô tả đơn hàng
        $vnp_OrderType = $_POST['order_type'] ?? 'other';  // Loại đơn hàng
        $vnp_Amount = $totalAmount * 100;  // VNPay yêu cầu số tiền phải nhân với 100 (đơn vị đồng)
        $vnp_Locale = 'vn';  // Ngôn ngữ thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];  // Địa chỉ IP của người dùng

        // Chuẩn bị dữ liệu để tạo chuỗi hash
        $inputData = array(
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
        );

        // Sắp xếp và tạo chuỗi hash
        ksort($inputData);
        $hashdata = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // Tạo URL thanh toán
        $vnp_Url .= "?" . $hashdata . "&vnp_SecureHash=" . $vnpSecureHash;

        // Chuyển hướng đến VNPay
        header('Location: ' . $vnp_Url);
        die();  // Dừng chương trình sau khi chuyển hướng
    }

    // Hàm xử lý thông báo thanh toán trả về từ VNPay
    public function paymentReturn() {
        $vnp_HashSecret = "W4J1L035O98GIOWPIJUIUDL7D61VFXC5"; // Khóa bí mật của bạn
    
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? null;
        $vnp_TxnRef = $_GET['vnp_TxnRef'] ?? null;
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? null;
    
        // Kiểm tra tính hợp lệ của kết quả thanh toán
        $secureHash = hash_hmac('sha512', $_SERVER['QUERY_STRING'], $vnp_HashSecret);
    
        if ($vnp_SecureHash == $secureHash) {
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công, cập nhật trạng thái đơn hàng trong DB
                $this->orderModel->updateOrderStatus($vnp_TxnRef, 'paid');
                
                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Chuyển hướng đến trang thành công
                header("Location: index.php?act=orderSuccess");
                exit();
            } else {
                // Thanh toán thất bại
                // Hiển thị thông báo hoặc chuyển hướng tới trang thất bại
                header("Location: OrderFailure.php?order_id=" . $vnp_TxnRef);
                exit();
            }
        } else {
            // Không hợp lệ
            echo "Dữ liệu không hợp lệ.";
        }
    }
    public function orderSuccess() {
        include './views/OrderSuccess.php';  // Chuyển đến trang thông báo đặt hàng thành công
    }
}
?>