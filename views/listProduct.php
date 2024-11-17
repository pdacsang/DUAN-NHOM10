<?php 
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';
?>
<section id="category1" class="product__love">
    <div class="container">
        <div class="row bg-white">
            <div class="col-lg-12 col-md-12 col-sm-12 product__love-title">
                <h2 class="product__love-heading upper">Danh sách sản phẩm</h2>
            </div>
        </div>
        <div class="row bg-white">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                        <div class="product__panel-img-wrap">
                            <a href="index.php?act=showProductDetail&id=<?= $product['id']; ?>">
                                <img src="<?= htmlspecialchars($product['hinh_anh']); ?>" 
                                     alt="<?= htmlspecialchars($product['ten_sach']); ?>" 
                                     class="product__panel-img">
                            </a>
                        </div>
                        <h3 class="product__panel-heading">
                            <a href="index.php?act=showProductDetail&id=<?= $product['id']; ?>" class="product__panel-link">
                                <?= htmlspecialchars($product['ten_sach']); ?>
                            </a>
                        </h3>
                        <div class="product__panel-price">
                            <span class="product__panel-price-current">
                                <?= number_format($product['gia_sach'], 0, ',', '.'); ?> VND
                            </span>
                        </div>
                        <form method="post" action="index.php?act=addToCart&id=<?= $product['id'] ?>">
                            <button type="submit">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="col-12 text-center">Không có sản phẩm nào để hiển thị trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php 
require_once './views/layout/footer.php';
?>
