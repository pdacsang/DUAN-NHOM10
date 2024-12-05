<?php
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';

// Lấy thông tin giỏ hàng từ session
$cartItems = $_SESSION['cart'] ?? [];
$totalAmount = array_sum(array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $cartItems));
$orderId = uniqid("order_", true);
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

    .error-message {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
    }
</style>

<div class="container1">
    <h1>Nhập thông tin đặt hàng</h1>

    <!-- Hiển thị lỗi nếu có -->

    <!-- Form nhập thông tin -->
    <form id="orderForm" action="index.php?act=checkout" method="POST">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($orderId) ?>">

        <div>
            <label for="recipient_name">Tên người nhận:</label>
            <input class="name" type="text" id="recipient_name" name="recipient_name" 
                value="<?= htmlspecialchars($_POST['recipient_name'] ?? '') ?>" required placeholder="Nhập tên người nhận">
        </div>

        <div>
            <label for="phone">Số điện thoại:</label>
            <input class="sdt" type="text" id="phone" name="phone" 
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" 
                required pattern="[0-9]{10,15}" 
                title="Số điện thoại phải từ 10 đến 15 chữ số." 
                placeholder="Nhập số điện thoại">
        </div>

        <div>
            <label for="email">Email người nhận:</label>
            <input class="email" type="email" id="email" name="email" 
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required placeholder="Nhập email người nhận">
        </div>

        <div>
            <label for="note">Ghi chú:</label>
            <textarea id="note" name="note" required placeholder="Nhập ghi chú"><?= htmlspecialchars($_POST['note'] ?? '') ?></textarea>
        </div>

        <div>
            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" required placeholder="Nhập địa chỉ giao hàng"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
        </div>

        <div>
            <label for="payment_method">Phương thức thanh toán:</label>
            <select id="payment_method" name="payment_method">
                <option value="1" <?= isset($_POST['payment_method']) && $_POST['payment_method'] == 1 ? 'selected' : '' ?>>Thanh toán trực tiếp</option>
                <option value="2" <?= isset($_POST['payment_method']) && $_POST['payment_method'] == 2 ? 'selected' : '' ?>>Thanh toán qua VNPay</option>
            </select>
        </div>

        <div class="cart-summary" style="font-size:30px;">
            <h2>Thông tin giỏ hàng</h2>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li><?= htmlspecialchars($item['name']) ?> x<?= $item['quantity'] ?> x <?= number_format($item['price'], 0, ',', '.') ?> đ</li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Tổng cộng:</strong> <?= number_format($totalAmount, 0, ',', '.') ?> đ</p>
        </div>

        <button type="submit" id="confirmOrderBtn" <?= empty($cartItems) ? 'disabled' : '' ?>>Xác nhận đặt hàng</button>
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
?>