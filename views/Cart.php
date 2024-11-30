<?php
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';
?>
<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-down"></i></button>

<!-- cart -->
<section class="cart">
    <div class="container">
        <!-- Header của giỏ hàng -->
        <article class="row cart__head pc">
            <nav class="menu__nav col-lg-3 col-md-12 col-sm-0">
                <ul class="menu__list">
                    <li class="menu__item menu__item--active">
                        <a href="#" class="menu__link">
                            <img src="images1/item/baby-boy.png" alt="Sách Tiếng Việt" class="menu__item-icon">
                            Sách Tiếng Việt
                        </a>
                    </li>
                    <li class="menu__item">
                        <a href="#" class="menu__link">
                            <img src="images1/item/translation.png" alt="Sách nước ngoài" class="menu__item-icon">
                            Sách nước ngoài
                        </a>
                    </li>
                    <li class="menu__item">
                        <a href="#" class="menu__link">
                            <img src="images1/item/1380754_batman_comic_hero_superhero_icon.png" alt="Manga - Comic" class="menu__item-icon">
                            Manga - Comic
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="col-6 cart__head-name">Thông tin sản phẩm</div>
            <div class="col-3 cart__head-quantity">Số lượng</div>
            <div class="col-3 cart__head-price">Đơn giá</div>
        </article>

        <!-- Sản phẩm trong giỏ -->
        <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                <article class="row cart__body">
                    <div class="col-6 cart__body-name">
                        <div class="cart__body-name-img">
                            <a href="index.php?act=showProductDetail&id=<?= htmlspecialchars($item['id']); ?>">
                            <img src="<?= htmlspecialchars($item['image'] ?? 'images/default.jpg') ?>" 
                                 alt="<?= htmlspecialchars($item['name'] ?? 'No Name') ?>" 
                                 onerror="this.src='images/default.jpg'">
                                 </a>
                        </div>
                        <a href="index.php?act=showProductDetail&id=<?= htmlspecialchars($item['id']); ?>" class="cart__body-name-title">
                            <?= htmlspecialchars($item['name'] ?? 'No Name') ?>
                        </a>
                    </div>
                    <div class="col-3 cart__body-quantity">
                        <input type="button" value="-" class="cart__body-quantity-minus" data-product-id="<?= $item['id'] ?>">
                        <input type="number" step="1" min="1" max="999" value="<?= $item['quantity'] ?>" 
                               class="cart__body-quantity-total" data-product-id="<?= $item['id'] ?>">
                        <input type="button" value="+" class="cart__body-quantity-plus" data-product-id="<?= $item['id'] ?>">
                    </div>
                    <div class="col-3 cart__body-price">
                        <span id="item-total-<?= $item['id'] ?>">
                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                        </span>
                        <a href="index.php?act=removeFromCart&id=<?= $item['id'] ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="cart-empty-message" style="font-size:20px;text-align:center;margin-top: 20px;">Giỏ hàng của bạn đang trống.</p>
            <div style="text-align:center;margin-bottom: 20px;" >
            <a href="index.php?act=productByCategory" class="btn btn-success" style="font-size:10px;">Xem sản phẩm</a>

            <a href="index.php" class="btn btn-primary " style="font-size:10px;">Quay lại trang chủ</a>
            </div>
        <?php endif; ?>

        <!-- Footer của giỏ hàng -->
        <article class="row cart__foot">
            <div class="col-6 col-lg-6 col-sm-6 cart__foot-update">
                <button class="cart__foot-update-btn">Cập nhật giỏ hàng</button>
            </div>
            <p class="col-3 col-lg-3 col-sm-3 cart__foot-total">Tổng cộng:</p>
            <span id="cart-total" class="col-3 col-lg-3 col-sm-3 cart__foot-price">
                <?= number_format($totalAmount, 0, ',', '.') ?>đ
            </span>
            
            <div class="cart__checkout">
    <form action="index.php?act=order" method="POST">
        <?php foreach ($cartItems as $item): ?>
            <input type="hidden" name="cartItems[]" value='<?= json_encode([
                'id' => $item['id'] ?? 0,
                'name' => $item['name'] ?? 'Tên sản phẩm không xác định',
                'quantity' => $item['quantity'] ?? 0, // Sử dụng 'quantity' thay cho 'so_luong'
                'price' => $item['price'] ?? 0, // Thêm thông tin giá nếu cần
            ], JSON_UNESCAPED_UNICODE) ?>'>
        <?php endforeach; ?>
        <input type="hidden" name="totalAmount" value="<?= $totalAmount ?>">
        <button type="submit" class="cart__foot-price-btn">Thanh toán</button>
    </form>
</div>
</section>

<?php
require_once './views/layout/footer.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const cartContainer = document.querySelector(".cart");

    cartContainer.addEventListener("click", function (event) {
        const target = event.target;

        if (target.matches(".cart__body-quantity-plus, .cart__body-quantity-minus")) {
            const productId = target.getAttribute("data-product-id");
            const change = target.classList.contains("cart__body-quantity-plus") ? 1 : -1;

            // Gửi yêu cầu cập nhật số lượng
            updateQuantity(productId, change);
        }
        if (change === -1 && currentQuantity === 1) {
            return;  // Không làm gì nếu số lượng đã là 1
        }
    });

    const updateQuantity = (productId, change) => {
        fetch("index.php?act=updateCart", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ product_id: productId, change: change })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật giá và tổng tiền
                document.querySelector(`#item-total-${productId}`).innerText = data.itemTotal;
                document.querySelector("#cart-total").innerText = data.totalAmount;
            } else {
                alert("Cập nhật thất bại: " + data.message);
            }
        })
        .catch(error => {
            console.error("Lỗi:", error);
        });
    };
});

</script>
