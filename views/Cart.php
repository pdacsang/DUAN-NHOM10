<?php
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';
?>
<button onclick="topFunction()" id="myBtn-scroll" title="Go to top"><i class="fas fa-chevron-down"></i></button>
<!-- cart -->
<section class="cart">
	<div class="container">
		<article class="row cart__head pc">
			<nav class="menu__nav col-lg-3 col-md-12 col-sm-0">
				<ul class="menu__list">
					<li class="menu__item menu__item--active">
						<a href="#" class="menu__link">
							<img src="images1/item/baby-boy.png" alt="" class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
							Sách Tiếng Việt</a>
					</li>
					<li class="menu__item">
						<a href="#" class="menu__link">
							<img src="images1/item/translation.png" alt="" class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
							Sách nước ngoài</a>
					</li>

					<li class="menu__item">
						<a href="#" class="menu__link">
							<img src="images1/item/1380754_batman_comic_hero_superhero_icon.png" alt="" class="menu__item-icon" viewBox="0 0 512 512" width="1012" height="512">

							Manga - Comic</a>
					</li>

				</ul>
			</nav>
			<div class="col-6 cart__head-name">
				Thông tin sản phẩm
			</div>
			<div class="col-3 cart__head-quantity">
				Số lượng
			</div>
			<div class="col-3 cart__head-price">
				Đơn giá
			</div>
		</article>

		<?php if (!empty($cartItems)): ?>
    <?php foreach ($cartItems as $item): ?>
        <article class="row cart__body">
            <div class="col-6 cart__body-name">
			<div class="cart__body-name-img">
            <img src="<?= htmlspecialchars($item['image'] ?? 'images/default.jpg') ?>" 
                 alt="<?= htmlspecialchars($item['name'] ?? 'No Name') ?>" 
                 onerror="this.src='images/default.jpg'">
        </div>
                <a href="" class="cart__body-name-title">
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
                <a href="index.php?act=removeFromCart&id=<?= $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
            </div>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p class="cart-empty-message">Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>
		</article>
		</article>

		<article class="row cart__foot">
			<div class="col-6 col-lg-6 col-sm-6 cart__foot-update">
				<button class="cart__foot-update-btn">Cập nhật giỏ hàng</button>
			</div>

			<p class="col-3 col-lg-3 col-sm-3 cart__foot-total">
				Tổng cộng:
			</p>

			<span id="cart-total" class="col-3 col-lg-3 col-sm-3 cart__foot-price">
				<?= number_format($totalAmount, 0, ',', '.') ?>đ
			</span>

			<button class="cart__foot-price-btn">Mua hàng</button>
			</span>
		</article>
	</div>
</section>
<?php
require_once './views/layout/footer.php';
?>
<script>
	function updateCart(productId, quantity) {
		fetch('index.php?act=updateCart', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify({
					product_id: productId,
					quantity: quantity
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Cập nhật tổng giá cho sản phẩm
					document.querySelector(`#item-total-${productId}`).textContent =
						new Intl.NumberFormat('vi-VN', {
							style: 'currency',
							currency: 'VND'
						}).format(data.itemTotal);

					// Cập nhật tổng giá giỏ hàng
					document.querySelector('#cart-total').textContent =
						new Intl.NumberFormat('vi-VN', {
							style: 'currency',
							currency: 'VND'
						}).format(data.totalAmount);
				} else {
					alert(data.message || 'Có lỗi xảy ra khi cập nhật.');
				}
			})
			.catch(error => console.error('Error:', error));
	}

	// Gắn sự kiện cho các nút tăng, giảm, và ô nhập số lượng
	document.querySelectorAll('.cart__body-quantity-total').forEach(input => {
		input.addEventListener('change', function() {
			const productId = this.dataset.productId;
			const quantity = parseInt(this.value);
			if (quantity > 0) {
				updateCart(productId, quantity);
			} else {
				alert('Số lượng phải lớn hơn 0.');
				this.value = 1;
				updateCart(productId, 1);
			}
		});
	});

	document.querySelectorAll('.cart__body-quantity-minus, .cart__body-quantity-plus').forEach(button => {
		button.addEventListener('click', function() {
			const productId = this.dataset.productId;
			const input = document.querySelector(`.cart__body-quantity-total[data-product-id="${productId}"]`);
			let quantity = parseInt(input.value);

			if (this.classList.contains('cart__body-quantity-plus')) {
				quantity++;
			} else if (this.classList.contains('cart__body-quantity-minus') && quantity > 1) {
				quantity--;
			}

			input.value = quantity;
			updateCart(productId, quantity);
		});
	});
</script>