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
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    h1 {
        text-align: center;
        color: #007bff;
        margin-top: 20px;
    }

    .order-container {
        max-width: 900px;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #ddd;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        padding: 10px 20px;
        background-color: #f1f1f1;
        border-bottom: 1px solid #ddd;
    }

    .order-header .status {
        color: #e74c3c;
        font-weight: bold;
    }

    .order-header .time {
        color: #3498db;
        font-weight: bold;
    }

    .order-item {
        display: flex;
        padding: 20px;
        border-bottom: 1px solid #ddd;
    }

    .order-item img {
        width: 80px;
        height: 100px;
        object-fit: cover;
        margin-right: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .order-item .info {
        flex-grow: 1;
    }

    .order-item .info h4 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .order-header {
        font-size: 20px;

    }

    .order-item .info .price {
        margin: 5px 0;
        font-size: 16px;
        color: #e74c3c;
    }

    .order-item .info .quantity {
        font-size: 14px;
        color: #555;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        padding: 10px 20px;
        background-color: #f9f9f9;
    }

    .order-footer .total {
        font-size: 16px;
        font-weight: bold;
        color: #e74c3c;
    }

    .order-footer .btn-detail {
        padding: 5px 10px;
        background-color: #3498db;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
    }

    .btn-back {
        display: block;
        width: fit-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #7f8c8d;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
    }

    .btn-back:hover {
        background-color: #95a5a6;
    }

    .price-quantity {
        font-size: 14px;
      
        font-weight: bold;
        display: inline-block;
        line-height: 1.2;
    }

    .price-quantity .quantity {
        margin-left: 5px;
    }
</style>
</head>

<body>
    <h1>Lịch sử đặt hàng</h1>

    <?php if (!empty($orderDetails)) { ?>
        <?php foreach ($orderDetails as $order) { ?>
            <div class="order-container">
                <div class="order-header">
                    <span class="status">
                        Trạng thái: <?= isset($order['ten_trang_thai']) ? htmlspecialchars($order['ten_trang_thai']) : 'Không rõ' ?>
                    </span> <span class="time">Thời gian: <?= isset($order['ngay_dat']) ? htmlspecialchars($order['ngay_dat']) : 'Không rõ' ?></span>
                </div>
                <div class="order-item">
                    <!-- Hiển thị ảnh sản phẩm -->
                    <img src="<?= isset($order['hinh_anh_san_pham']) ? htmlspecialchars($order['hinh_anh_san_pham']) : 'default.png' ?>" alt="Hình ảnh sản phẩm">
                    <div class="info">
                        <!-- Hiển thị tên sản phẩm -->
                        <h4><?= isset($order['ten_san_pham']) ? htmlspecialchars($order['ten_san_pham']) : 'Không rõ' ?></h4>
                        <!-- Hiển thị giá và số lượng -->
                        <div class="price-quantity">
                            <a class="price" ><?= isset($order['don_gia']) ? number_format($order['don_gia'], 0, ',', '.') : '0' ?>đ</a>
                            &times;<?= isset($order['so_luong']) ? htmlspecialchars($order['so_luong']) : '0' ?>
                        </div>
                    </div>
                </div>
                <div class="order-footer">
                    <span class="total">Thành tiền: <?= isset($order['tong_tien']) ? number_format($order['tong_tien'], 0, ',', '.') : '0' ?>đ</span>
                    <a href="?act=orderDetails&order_id=<?= $order['don_hang_id'] ?>" class="btn-detail">Xem chi tiết</a>                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p style="text-align: center; color: #666; font-size:20px;">Bạn chưa có đơn hàng nào trong lịch sử.</p>
    <?php } ?>

    <a href="javascript:history.back()" class="btn-back" style="font-size:15px;">Trở lại</a>

    <?php
    require_once './views/layout/footer.php';
    ?>