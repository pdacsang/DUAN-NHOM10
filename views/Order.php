<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';

// Kiểm tra và khởi tạo session nếu cần
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Đảm bảo phiên hoạt động
}

// Kiểm tra trạng thái đăng nhập
if (!isset($_SESSION['user_client']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: index.php?act=login"); // Chuyển hướng nếu không đăng nhập
    exit;
}

$isSingleProduct = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']));

if ($isSingleProduct) {
    $product = [
        'id' => $_POST['product_id'] ?? null,
        'name' => $_POST['product_name'] ?? 'Tên sản phẩm không xác định',
        'price' => $_POST['product_price'] ?? 0,
        'quantity' => $_POST['product_quantity'] ?? 1,
        'image' => $_POST['product_image'] ?? 'images/default.jpg'
    ];
    $totalAmount = $product['price'] * $product['quantity'];
} else {
    $cartItems = $_SESSION['cart'] ?? [];
    $totalAmount = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $cartItems));
}

$orderId = uniqid("order_", true);

// Khởi tạo lỗi trống
$errors = [];
$isSubmitted = false;

// Xử lý biểu mẫu khi gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isSubmitted = true;

    $recipientName = trim($_POST['recipient_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $paymentMethod = $_POST['payment_method'] ?? '';

    // Validate các trường
    if (empty($recipientName)) {
        $errors['recipient_name'] = 'Tên người nhận không được để trống.';
    }
    if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errors['phone'] = 'Số điện thoại không hợp lệ.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
    }
    if (empty($address)) {
        $errors['address'] = 'Địa chỉ không được để trống.';
    }
    if (!in_array($paymentMethod, ['1', '2'])) {
        $errors['payment_method'] = 'Phương thức thanh toán không hợp lệ.';
    }

    if (empty($errors)) {
        header("Location: index.php?act=orderSuccess");
        exit;
    }
}
?>




<style>
    /* Cải thiện modal */
    #confirmationModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content h2 {
        margin-bottom: 20px;
    }

    .modal-content p {
        font-size: 16px;
        margin-bottom: 8px;
    }

    .modal-content button {
        padding: 10px 20px;
        margin: 10px 5px;
        border: none;
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .modal-content button:hover {
        background-color: #45a049;
    }

    /* Cải thiện form */
    .container1 {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    label {
        font-size: 16px;
        margin-bottom: 8px;
        display: block;
        color: #555;
    }

    .name,.sdt, .email, textarea, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .name,.sdt,:focus,.email:focus, textarea:focus, select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    textarea {
        height: 100px;
        resize: none;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    button:hover {
        background-color: #45a049;
    }

    .cart-summary {
        background-color: #f8f8f8;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .cart-summary ul {
        list-style: none;
        padding: 0;
    }

    .cart-summary ul li {
        margin-bottom: 10px;
    }

    .cart-summary p {
        font-weight: bold;
    }

    .cart-summary p span {
        color: red;
    }

    .error{
        color: red;
       font-size: 15px;
       margin-bottom: 10px;
    }
</style>

<div class="container1">
    <h1>Nhập thông tin đặt hàng</h1>

    <form id="orderForm" action="" method="POST">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($orderId) ?>">

        <div>
    <label for="recipient_name">Tên người nhận:</label>
    <input 
        class="name" 
        type="text" 
        id="recipient_name" 
        name="recipient_name" 
        placeholder="Nhập tên người nhận"
        onblur="validateInput(this)"
        oninput="validateInput(this)"
    >
    <small id="error_recipient_name_required" class="error" style="display: none;">Tên người nhận không được để trống.</small>
</div>

        <div>
            <label for="phone">Số điện thoại:</label>
            <input 
                class="sdt" 
                type="text" 
                id="phone" 
                name="phone" 
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" 
                placeholder="Nhập số điện thoại"
                onblur="validateInput(this)"
                oninput="validateInput(this)"
            >
            <small id="error_phone_required" class="error" style="display: none;">Số điện thoại không được để trống.</small>
            <small id="error_phone_invalid" class="error" style="display: none;">Số điện thoại không hợp lệ. Nhập từ 10 đến 15 chữ số.</small>
        </div>

        <div>
            <label for="email">Email người nhận:</label>
            <input 
                class="email" 
                type="email" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                placeholder="Nhập email người nhận"
                onblur="validateInput(this)"
                oninput="validateInput(this)"
            >
            <small id="error_email_required" class="error" style="display: none;">Email không được để trống.</small>
            <small id="error_email_invalid" class="error" style="display: none;">Email không hợp lệ.</small>
        </div>

        <div>
    <label for="address">Địa chỉ:</label>
    <textarea 
        id="address" 
        name="address" 
        placeholder="Nhập địa chỉ giao hàng"
        onblur="validateInput(this)"
        oninput="validateInput(this)"
    ></textarea>
    <small id="error_address_required" class="error" style="display: none;">Địa chỉ không được để trống.</small>
</div>

        <div>
            <label for="note">Ghi chú:</label>
            <textarea id="note" name="note" placeholder="Nhập ghi chú cho đơn hàng"><?= htmlspecialchars($_POST['note'] ?? '') ?></textarea>
        </div>

        <div>
            <label for="payment_method">Phương thức thanh toán:</label>
            <select id="payment_method" name="payment_method">
                <option value="1" <?= (isset($_POST['payment_method']) && $_POST['payment_method'] == 1) ? 'selected' : '' ?>>Thanh toán trực tiếp</option>
                <option value="2" <?= (isset($_POST['payment_method']) && $_POST['payment_method'] == 2) ? 'selected' : '' ?>>Thanh toán qua VNPay</option>
            </select>
        </div>

        <div class="cart-summary" style="font-size: 30px;">
            <h2>Thông tin sản phẩm</h2>
            <ul>
                <?php if ($isSingleProduct): ?>
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                    <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['price']) ?>">
                    <input type="hidden" name="product_quantity" value="<?= htmlspecialchars($product['quantity']) ?>">
                    <li><?= htmlspecialchars($product['name']) ?> x <?= $product['quantity'] ?> x <?= number_format($product['price'], 0, ',', '.') ?> đ</li>
                <?php else: ?>
                    <?php foreach ($cartItems as $item): ?>
                        <li><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?> x <?= number_format($item['price'], 0, ',', '.') ?> đ</li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <p><strong>Tổng cộng:</strong> <?= number_format($totalAmount, 0, ',', '.') ?> đ</p>
        </div>

        <button type="submit" id="confirmOrderBtn">Xác nhận đặt hàng</button>
    </form>
</div>

<!-- Modal xác nhận -->
<div id="confirmationModal">
    <div class="modal-content">
        <h2>Xác nhận thông tin đơn hàng</h2>
        <div id="orderDetails"></div>
        <button id="confirmSubmitBtn">Xác nhận</button>
        <button id="cancelBtn">Hủy</button>
    </div>
</div>

<script>
    function validateInput(input) {
    const id = input.id;
    const value = input.value.trim();

    // Reset lỗi
    const requiredError = document.getElementById(`error_${id}_required`);
    const invalidError = document.getElementById(`error_${id}_invalid`);

    if (requiredError) requiredError.style.display = "none";
    if (invalidError) invalidError.style.display = "none";

    // Kiểm tra lỗi
    if (!value) {
        if (requiredError) requiredError.style.display = "block";
        return false;
    }
    if ((id === "recipient_name" || id === "address") && !value) {
        if (requiredError) requiredError.style.display = "block";
        return false;
    }
    if (id === "phone") {
        const phonePattern = /^[0-9]{10,15}$/;
        if (!phonePattern.test(value)) {
            if (invalidError) invalidError.style.display = "block";
            return false;
        }
    }

    if (id === "email") {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(value)) {
            if (invalidError) invalidError.style.display = "block";
            return false;
        }
    }

    return true;
}

document.querySelectorAll('#orderForm input, #orderForm textarea').forEach(input => {
    input.addEventListener('blur', () => validateInput(input));
    input.addEventListener('input', () => validateInput(input));
});

document.getElementById('orderForm').addEventListener('submit', function (event) {
    let hasError = false;

    // Kiểm tra tất cả các trường
    const inputs = ['recipient_name', 'phone', 'email', 'address'];
    inputs.forEach((id) => {
        const input = document.getElementById(id);
        if (!validateInput(input)) {
            hasError = true;
        }
    });

    // Nếu có lỗi, ngăn gửi form
    if (hasError) {
        event.preventDefault();
    }
});
document.getElementById('confirmOrderBtn').addEventListener('click', function(event) {
    // Ngăn chặn form gửi đi ngay lập tức
    event.preventDefault();

    // Lấy dữ liệu từ form
    const recipientName = document.getElementById('recipient_name').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;
    const paymentMethod = document.getElementById('payment_method').value;
    const totalAmount = <?= $totalAmount ?>;
    const orderId = "<?= $orderId ?>";  // Lấy order_id từ PHP

    // Kiểm tra tính hợp lệ của dữ liệu đầu vào
    if (!recipientName || !phone || !email || !address) {
        alert('Vui lòng điền đầy đủ thông tin.');
        return;
    }

    // Hiển thị modal xác nhận
    let orderDetails = ` 
        <p><strong>Tên người nhận:</strong> ${recipientName}</p>
        <p><strong>Số điện thoại:</strong> ${phone}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Địa chỉ:</strong> ${address}</p>
        <p><strong>Phương thức thanh toán:</strong> ${paymentMethod == 1 ? 'Tiền mặt' : 'Chuyển khoản'}</p>
        <p><strong>Tổng cộng:</strong> ${totalAmount.toLocaleString()}đ</p>
    `;
    document.getElementById('orderDetails').innerHTML = orderDetails;
    document.getElementById('confirmationModal').style.display = 'flex';
});

// Khi nhấn "Xác nhận" trong modal, gửi form
document.getElementById('confirmSubmitBtn').addEventListener('click', function() {
    // Thêm order_id vào form khi người dùng nhấn "Xác nhận"
    const orderForm = document.getElementById('orderForm');
    const orderIdInput = document.createElement('input');
    orderIdInput.type = 'hidden';
    orderIdInput.name = 'order_id';
    orderIdInput.value = "<?= $orderId ?>";  // Lấy order_id từ PHP

    orderForm.appendChild(orderIdInput);  // Thêm vào form

    // Submit form
    orderForm.submit();
});

// Khi nhấn "Hủy" trong modal, đóng modal
document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('confirmationModal').style.display = 'none';
});

// Đóng modal khi click vào ngoài modal
window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('confirmationModal')) {
        document.getElementById('confirmationModal').style.display = 'none';
    }
});
</script>

<?php 
require_once './views/layout/footer.php';
ob_end_flush(); // Kết thúc và xóa bộ đệm đầu ra

?>
