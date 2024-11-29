

<?php if (isset($order) && isset($orderDetails)): ?>
    <h1>Đặt hàng thành công!</h1>
    <p>Mã đơn hàng: <?= htmlspecialchars($order['id']) ?></p>
    <p>Ngày đặt: <?= htmlspecialchars($order['ngay_tao']) ?></p>
    <p>Tổng tiền: <?= number_format($order['tong_tien'], 0, ',', '.') ?> VNĐ</p>
    <h2>Chi tiết đơn hàng</h2>
    <ul>
        <?php foreach ($orderDetails as $item): ?>
            <li>
                Sản phẩm ID: <?= htmlspecialchars($item['san_pham_id']) ?> -
                Số lượng: <?= htmlspecialchars($item['so_luong']) ?> -
                Giá: <?= number_format($item['gia'], 0, ',', '.') ?> VNĐ
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Không tìm thấy thông tin đơn hàng.</p>
<?php endif; ?>