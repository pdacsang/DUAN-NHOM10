<?php 
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';

// Lấy thông tin giỏ hàng
$cartItems = $_SESSION['cart_items'] ?? [];
$totalAmount = array_reduce($cartItems, function($carry, $item) {
    return $carry + ($item['price'] * $item['quantity']);
}, 0);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container1 {
        background-color: #f8f9fa;
        max-width: 900px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 22px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        color: #555;
        margin-bottom: 5px;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #007bff;
        outline: none;
    }
    .cart-items ul {
        list-style: none;
        padding: 0;
    }
    .cart-items li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
    .cart-items img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    .submit-btn {
        display: block;
        width: 100%;
        padding: 10px 20px;
        font-size: 18px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-align: center;
    }
    .submit-btn:hover {
        background-color: #0056b3;
    }
</style>

<div class="container1">
    <h2>Thanh Toán</h2>
    <form action="index.php?act=placeOrder" method="POST">
        <div class="form-group">
            <label for="full_name">Họ và Tên:</label>
            <input type="text" id="full_name" name="full_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Số Điện Thoại:</label>
            <input type="text" id="phone" name="phone" required pattern="^0[0-9]{9,10}$" title="Số điện thoại hợp lệ bắt đầu bằng 0 và có 10-11 chữ số.">
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ người nhận:</label>
            <input type="text" id="address" name="address" required>
        </div>
        
        <div class="form-group">
            <label>Phương Thức Thanh Toán:</label>
            <div>
                <input type="radio" id="cod" name="payment_method" value="1" checked>
                <label for="cod">COD</label>
            </div>
            <div>
                <input type="radio" id="vnpay" name="payment_method" value="2">
                <label for="vnpay">VNPay</label>
            </div>
        </div>
        <div class="form-group">
            <label for="note">Ghi Chú:</label>
            <textarea id="note" name="note" rows="3"></textarea>
        </div>
        
        <div class="cart-items">
            <h3>Giỏ Hàng:</h3>
            <ul>
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <li>
                            <img src="<?= htmlspecialchars($item['image'] ?? 'images/default.jpg') ?>" 
                                 alt="<?= htmlspecialchars($item['name'] ?? 'No Name') ?>">
                            <div>
                                <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                                <small>Số lượng: <?= htmlspecialchars($item['quantity']) ?></small>
                            </div>
                            <div>
                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Giỏ hàng trống.</p>
                <?php endif; ?>
            </ul>
            <p><strong>Tổng tiền: <?= number_format($totalAmount, 0, ',', '.') ?>đ</strong></p>
        </div>

        <!-- Dữ liệu giỏ hàng dưới dạng JSON -->
        <input type="hidden" name="cart_items" value="<?= htmlspecialchars(json_encode($cartItems)) ?>">

        <button type="submit" class="submit-btn">Hoàn Thành Đặt Hàng</button>
    </form>
</div>


<?php 
require_once './views/layout/footer.php';
?>
