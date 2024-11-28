<?php
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';

$cartItems = $_SESSION['cart'] ?? [];
$totalAmount = array_sum(array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $cartItems));
?>

<div class="container">
    <h1>Nhập thông tin đặt hàng</h1>

    <form action="index.php?act=checkout" method="POST">
        <div>
            <label for="recipient_name">Tên người nhận:</label>
            <input type="text" id="recipient_name" name="recipient_name" required placeholder="Nhập tên người nhận">
        </div>
        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required pattern="[0-9]{10,15}" 
                   title="Số điện thoại phải từ 10 đến 15 chữ số." placeholder="Nhập số điện thoại">
        </div>
        <div>
            <label for="email">Email người nhận:</label>
            <input type="email" id="email" name="email" required placeholder="Nhập email người nhận">
        </div>
        <div>
            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" required placeholder="Nhập địa chỉ giao hàng"></textarea>
        </div>
        <div>
            <label for="payment_method">Phương thức thanh toán:</label>
            <select id="payment_method" name="payment_method">
                <option value="1">Tiền mặt</option>
                <option value="2">Chuyển khoản</option>
            </select>
        </div>

        <h2>Thông tin giỏ hàng</h2>
        <?php if (!empty($cartItems)): ?>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li>
                        <?= htmlspecialchars($item['name']) ?> 
                        Số lượng: <?= htmlspecialchars($item['quantity']) ?> 
                        Giá: <?= number_format($item['price'], 0, ',', '.') ?>đ
                    </li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Tổng cộng:</strong> <?= number_format($totalAmount, 0, ',', '.') ?>đ</p>
        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>

        <button type="submit" <?= empty($cartItems) ? 'disabled' : '' ?>>Xác nhận đặt hàng</button>
    </form>
</div>

<?php 
require_once './views/layout/footer.php';
?>
