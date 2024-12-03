<?php 
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';
?>
>

<section class="product">
        <div class="container">
            <div class="row bg-white pt-4 pb-4 border-bt pc">
               

                <article class="product__main col-lg-9 col-md-12 col-sm-12">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="product__main-img col-lg-4 col-md-4 col-sm-12">
            <div class="product__main-img-primary">
                <img src="<?= htmlspecialchars($product['hinh_anh'] ?? 'images/default.jpg') ?>" 
                     alt="<?= htmlspecialchars($product['ten_sach'] ?? 'Không có tên sản phẩm') ?>">
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="product__main-info col-lg-8 col-md-8 col-sm-12">
            <div class="product__main-info-breadcrumb" style="font-size: 20px;">
                <a href="index.php">Trang chủ</a> / <a href="index.php?act=productByCategory">Danh sách sản phẩm</a>/ <a href="index.php?act=productByCategory">Sản phẩm</a>
            </div>

            <h2 class="product__main-info-heading">
                <?= htmlspecialchars($product['ten_sach'] ?? 'Tên sản phẩm không có') ?>
            </h2>

            <div class="product__main-info-price">
                <span class="product__main-info-price-current">
                    <?= isset($product['gia_sach']) ? number_format($product['gia_sach'], 0, ',', '.') . 'đ' : 'Liên hệ' ?>
                </span>
            </div>

            <div class="product__main-info-status">
                <strong>Trạng thái:</strong>
                <span>
                    <?= $product['trang_thai'] == 1 ? 'Còn hàng' : 'Hết hàng'; ?>
                </span>
            </div>

            <!-- Form thêm vào giỏ hàng -->
            <div class="product__main-info-cart-btn-wrap">
                <form method="post" action="index.php?act=addToCart&id=<?= htmlspecialchars($product['id'] ?? 0) ?>" 
                      onsubmit="ensureValidQuantity(<?= htmlspecialchars($product['id'] ?? 0) ?>)">
                    <label for="quantity-<?= htmlspecialchars($product['id'] ?? 0) ?>">Số lượng:</label>
                    <div class="cart__body-quantity">
                        <!-- Nút giảm số lượng -->
                        <input type="button" value="-" class="cart__body-quantity-minus" 
                               onclick="updateQuantity(<?= htmlspecialchars($product['id'] ?? 0) ?>, false)">
                        <!-- Input nhập số lượng -->
                        <input type="number" step="1" min="1" max="999" name="quantity" 
                               id="quantity-<?= htmlspecialchars($product['id'] ?? 0) ?>" 
                               value="1" onchange="validateQuantity(<?= htmlspecialchars($product['id'] ?? 0) ?>)">
                        <!-- Nút tăng số lượng -->
                        <input type="button" value="+" class="cart__body-quantity-plus" 
                               onclick="updateQuantity(<?= htmlspecialchars($product['id'] ?? 0) ?>, true)">
                    </div>
                    <button type="submit" class="product__main-info-cart-btn">Thêm vào giỏ hàng</button>
                </form>
                <form action="index.php?act=checkout" method="POST" id="checkoutForm">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['ten_sach']); ?>">
    <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['gia_sach']); ?>">
    <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['hinh_anh']); ?>">
    <!-- Trường số lượng được đồng bộ từ ô nhập số lượng -->
    <input type="hidden" name="product_quantity" id="checkout-quantity" value="1">
    <button type="button" class="btn btn-primary" onclick="prepareCheckout(<?= htmlspecialchars($product['id']); ?>)">Thanh Toán</button>
</form>
            </div>

            <div class="product__main-info-contact">
                <a href="#" class="product__main-info-contact-fb">
                    <i class="fab fa-facebook-f"></i> Chat Facebook
                </a>
                <div class="product__main-info-contact-phone-wrap">
                    <div class="product__main-info-contact-phone-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="product__main-info-contact-phone">
                        <div class="product__main-info-contact-phone-title">Gọi điện tư vấn</div>
                        <div class="product__main-info-contact-phone-number">(0352.860.701)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Mô tả & Đánh giá -->
    <div class="row bg-white">
        <div class="col-12 product__main-tab">
            <a href="#" class="product__main-tab-link product__main-tab-link--active">Mô tả</a>
            <a href="#" class="product__main-tab-link">Đánh giá</a>
        </div>

        <div class="col-12 product__main-content-wrap">
            <!-- Mô tả sản phẩm -->
            <div class="product__main-info-description">
                <?= nl2br(htmlspecialchars($product['mo_ta'] ?? 'Không có mô tả.')) ?>
            </div>

            <!-- Thông tin chi tiết -->
            <h2 class="thongtin"><span>Thông tin chi tiết</span></h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Công ty phát hành</th>
                            <td><?= htmlspecialchars($product['nha_xuat_ban'] ?? 'Không có thông tin') ?></td>
                        </tr>
                        <tr>
                            <th>Ngày xuất bản</th>
                            <td><?= htmlspecialchars($product['ngay_xuat_ban'] ?? 'Không có thông tin') ?></td>
                        </tr>
                        <tr>
                            <th>Số trang</th>
                            <td><?= htmlspecialchars($product['so_trang'] ?? 'Không có thông tin') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>

<script>
    // Đồng bộ số lượng trước khi thanh toán
    function prepareCheckout(productId) {
        // Lấy giá trị từ ô nhập số lượng
        const quantityInput = document.getElementById('quantity-' + productId);
        const checkoutQuantityInput = document.getElementById('checkout-quantity');

        // Đồng bộ giá trị số lượng
        checkoutQuantityInput.value = quantityInput.value;

        // Gửi form thanh toán
        document.getElementById('checkoutForm').submit();
    }

    // Hàm cập nhật số lượng khi nhấn tăng/giảm
    function updateQuantity(productId, increase) {
        const quantityInput = document.getElementById('quantity-' + productId);
        let currentQuantity = parseInt(quantityInput.value) || 1;

        // Tăng hoặc giảm số lượng
        if (increase) {
            quantityInput.value = currentQuantity + 1;
        } else if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
        }
    }

    // Hàm kiểm tra số lượng khi nhập trực tiếp
    function validateQuantity(productId) {
        const quantityInput = document.getElementById('quantity-' + productId);
        let quantity = parseInt(quantityInput.value);

        // Đảm bảo giá trị hợp lệ
        if (quantity < 1 || isNaN(quantity)) {
            quantityInput.value = 1;
        }
    }

    function ensureValidQuantity(productId) {
        let quantityInput = document.getElementById('quantity-' + productId);
        if (parseInt(quantityInput.value) < 1 || isNaN(quantityInput.value)) {
            quantityInput.value = 1;
        }
    }
</script>


                <aside class="product__aside col-lg-3 col-md-0 col-sm-0">
                    <div class="product__aside-top">
                        <div class="product__aside-top-item">
                            <img src="images/shipper.png">
                            <div class="product__aside-top-item-text">
                                <p>
                                    Giao hàng nhanh chóng
                                </p>
                                <span>
                                    Chỉ trong vòng 24h
                                </span>
                            </div>
                        </div>
                        <div class="product__aside-top-item">
                            <img src="images/brand.png">
                            <div class="product__aside-top-item-text">
                                <p>
                                    Sản phẩm chính hãng
                                </p>
                                <span>
                                    Sản phẩm nhập khẩu 100%
                                </span>
                            </div>
                        </div>
                        <div class="product__aside-top-item">
                            <img src="images/less.png">
                            <div class="product__aside-top-item-text">
                                <p>
                                    Mua hàng tiết kiệm
                                </p>
                                <span>
                                    Rẻ hơn từ 10% đến 30%
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="product__aside-bottom">
                        <h3 class="product__aside-heading">
                            Có thể bạn thích
                        </h3>

                        <div class="product__aside-list">
                            <div class="product__aside-item product__aside-item--border">
                                <div class="product__aside-img-wrap">
                                    <img src="images1/product/image_227958.jpg" class="product__aside-img">
                                </div>
                                <div class="product__aside-title">
                                    <a href="#" class="product__aside-link">
                                        <h4 class="product__aside-link-heading"> Giáo Dục Stem/Steam : Từ Trải Nghiệm Thực Hành Đến Tư Duy</h4>
                                    </a>

                                    <div class="product__aside-rate-wrap">
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                    </div>

                                    <div class="product__aside-price">
                                        <span class="product__aside-price-current">
                                            72.250
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="product__aside-item">
                                <div class="product__aside-img-wrap">
                                    <img src="images1/product/untitled-1_9_25_1.jpg" class="product__aside-img">
                                </div>
                                <div class="product__aside-title">
                                    <a href="#" class="product__aside-link">
                                        <h4 class="product__aside-link-heading">Tôi Thích Bản Thân Nỗ Lực Hơn ( Tái bản 2019)</h4>
                                    </a>

                                    <div class="product__aside-rate-wrap">
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                    </div>

                                    <div class="product__aside-price">
                                        <span class="product__aside-price-current">
                                            76.800đ
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="product__aside-item">
                                <div class="product__aside-img-wrap">
                                    <img src="images1/product/image_187163.jpg" class="product__aside-img">
                                </div>
                                <div class="product__aside-title">
                                    <a href="#" class="product__aside-link">
                                        <h4 class="product__aside-link-heading">Tuổi Thơ Dữ Dội - Tập 2 (Tái Bản 2019)</h4>
                                    </a>

                                    <div class="product__aside-rate-wrap">
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                    </div>

                                    <div class="product__aside-price">
                                        <span class="product__aside-price-current">
                                          69.000đ
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="product__aside-item">
                                <div class="product__aside-img-wrap">
                                    <img src="images1/product/image_188285.jpg" class="product__aside-img">
                                </div>
                                <div class="product__aside-title">
                                    <a href="#" class="product__aside-link">
                                        <h4 class="product__aside-link-heading">Chuyện Con Mèo Dạy Hải Âu Bay</h4>
                                    </a>

                                    <div class="product__aside-rate-wrap">
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                        <i class="fas fa-star product__aside-rate"></i>
                                    </div>

                                    <div class="product__aside-price">
                                        <span class="product__aside-price-current">
                                         34.300đ
                                        </span>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </aside>

            </div>
            
           <div class="customer-reviews row pb-4 pb-4  py-4 pb-4 py-4 py-4">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h3 >Bình luận sản phẩm</h3>
                <form id ="formgroupcomment" method="post">
                    <div class="form-group">
                        <label>Tên:</label>
                        <input name="comm_name" required="" type="text" id ='form-name' class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input name="comm_mail" required="" type="email"  class="form-control" id="pwd">
                    </div>
                    <div class="form-group">
                        <label>Nội dung:</label>
                        <textarea name="comm_details" required="" rows="8" id ='formcontent' class="form-control"></textarea>     
                    </div>
                    <button type="submit" name="sbm" id= "submitcomment" class="btn btn-primary">Gửi</button>
                </form> 
            </div>
           </div>
            
           <div class="product-comment row pb-4 pb-4  py-4 pb-4 py-4 py-4">
            
           </div>
             
            

    
                               
                             

            <section class="product__love col-12 mt-4">
                <div class="row bg-white">
                <div class="col-lg-12 col-md-12 col-sm-12 product__love-title">
                    <h2 class="product__love-heading">
                        Sản phẩm tương tự
                    </h2>
                </div>
            </div>
            <div class="row bg-white">
                <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                    <div class="product__panel-img-wrap">
                        <img src="images1/product/image_189077.jpg" alt="" class="product__panel-img">
                    </div>
                    <h3 class="product__panel-heading">
                        <a href="#" class="product__panel-link">Tâm Lý Học - Khái Lược Những Tư Tưởng Lớn</a>
                    </h3>
                    <div class="product__panel-rate-wrap">
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                    </div>

                    <div class="product__panel-price">
                        <span class="product__panel-price-old product__panel-price-old-hide">
                         300.000đ
                        </span>
                        <span class="product__panel-price-current">
                            273.000đ
                        </span>
                    </div>  
                </div>

                <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                    <div class="product__panel-img-wrap">
                        <img src="images1/product/camnangppsupham.u84.d20161125.t123417.884704.jpg" alt="" class="product__panel-img">
                    </div>
                    <h3 class="product__panel-heading">
                        <a href="#" class="product__panel-link">Cẩm Nang Phương Pháp Sư Phạm (Tái Bản 2020)</a>
                    </h3>
                    <div class="product__panel-rate-wrap">
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                    </div>

                    <div class="product__panel-price">
                        <span class="product__panel-price-old product__panel-price-old-hide">
                           150.000đ
                        </span>
                        <span class="product__panel-price-current">
                            120.000đ
                        </span>
                    </div> 
                </div>

                <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                    <div class="product__panel-img-wrap">
                        <img src="images1/product/image_197655.jpg" alt="" class="product__panel-img">
                    </div>
                    <h3 class="product__panel-heading">
                        <a href="#" class="product__panel-link">STEM- Kỹ Thuật Siêu Đơn Giản</a>
                    </h3>
                    <div class="product__panel-rate-wrap">
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                    </div>

                    <div class="product__panel-price">
                        <span class="product__panel-price-old product__panel-price-old-hide 
                        ">
                           50.000đ
                        </span>
                        <span class="product__panel-price-current">
                            47.200đ
                        </span>
                    </div>
                </div>
                <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                    <div class="product__panel-img-wrap">
                        <img src="images1/product/9786045890332.jpg" alt="" class="product__panel-img">
                    </div>
                    <h3 class="product__panel-heading">
                        <a href="#" class="product__panel-link">Cẩm Nang Tư Duy Học Tập Và Nghiên Cứu..</a>
                    </h3>
                    <div class="product__panel-rate-wrap">
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                    </div>

                    <div class="product__panel-price">
                        <span class="product__panel-price-old product__panel-price-old-hide">
                           30.000đ
                        </span>
                        <span class="product__panel-price-current">
                           24.000đ
                        </span>
                    </div> 
                </div>

                <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                    <div class="product__panel-img-wrap">
                        <img src="images1/product/image_195509_1_21191.jpg" alt="" class="product__panel-img" width="110">
                    </div>
                    <h3 class="product__panel-heading">
                        <a href="#" class="product__panel-link">Phương Pháp Giáo Con Của Người Do Thái <br>
                            
                        </a>
                    </h3>
                    <div class="product__panel-rate-wrap">
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                    </div>

                    <div class="product__panel-price">
                        <span class="product__panel-price-old product__panel-price-old-hide">
                           62.000đ
                        </span>
                        <span class="product__panel-price-current">
                            37.200đ
                        </span>
                    </div> 
                </div>

                <div class="product__panel-item col-lg-2 col-md-3 col-sm-6">
                    <div class="product__panel-img-wrap">
                        <img src="images1/product/image_227958.jpg" alt="" class="product__panel-img" >
                    </div>
                    <h3 class="product__panel-heading">
                        <a href="#" class="product__panel-link">Giáo Dục Stem/Steam:Từ Trải Nghiệm Thực Hành..
                        </a>
                    </h3>
                    <div class="product__panel-rate-wrap">
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                        <i class="fas fa-star product__panel-rate"></i>
                    </div>

                    <div class="product__panel-price">
                        <span class="product__panel-price-old product__panel-price-old-hide">
                            85.000đ
                        </span>
                        <span class="product__panel-price-current">
                            72.250đ
                        </span>
                    </div> 
                </div>
            </div>
            </section>
        </div>
    </section>                  


    <?php 
require_once './views/layout/footer.php';
    ?>
</body>

</html>