<?php 
require_once './views/layout/header.php';
require_once './views/layout/navbar.php';
?>
>

<section class="product">
        <div class="container">
            <div class="row bg-white pt-4 pb-4 border-bt pc">
                <nav class="menu__nav col-lg-3 col-md-12 col-sm-0">
                    <ul class="menu__list">
                        <li class="menu__item menu__item--active">
                            <a href="#" class="menu__link">
                            <img src="images1/item/baby-boy.png" alt=""  class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                            Sách Tiếng Việt</a>
                        </li>
                        <li class="menu__item">
                            <a href="#" class="menu__link">
                            <img src="images1/item/translation.png" alt="" class="menu__item-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512">
                            Sách nước ngoài</a>
                        </li>
                      
                        <li class="menu__item">
                            <a href="#" class="menu__link">
                                <img src="images1/item/1380754_batman_comic_hero_superhero_icon.png" alt="" class="menu__item-icon"  viewBox="0 0 512 512" width="1012" height="512">

                            Manga - Comic</a>
                        </li>
                      
                    </ul>
                </nav>

                <article class="product__main col-lg-9 col-md-12 col-sm-12">
                    <div class="row">
                    <div class="product__main-img col-lg-4 col-md-4 col-sm-12"> 
    <div class="product__main-img-primary"> 
        <img src="<?php echo htmlspecialchars($product['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($product['ten_sach']); ?>"> 
    </div> 
</div>

                        <div class="product__main-info col-lg-8 col-md-8 col-sm-12">
                            <div class="product__main-info-breadcrumb">
                                Trang chủ / Sản phẩm
                            </div>
                            
                            
                            <article class="product__main-info col-lg-8 col-md-8 col-sm-12"> 
   

                            <a href="#" class="product__main-info-title">
    <h2 class="product__main-info-heading">
        <?php echo htmlspecialchars($product['ten_sach']); ?>
    </h2>
</a>

<div class="product__main-info-price">
    <span class="product__main-info-price-current">
        <?php echo number_format($product['gia_sach'], 0, ',', '.') . 'đ'; ?>
    </span>
</div>

<div class="product__main-info-status">
    <strong style="font-size: 15px;">Trạng thái: </strong>
    <span style="font-size: 15px;">
        <?php echo $product['trang_thai'] == 1 ? 'Còn hàng' : 'Hết hàng'; ?>
    </span>
</div>

<div class="product__main-info-cart-btn-wrap">
    <!-- Form xử lý thêm vào giỏ hàng -->
    <form method="post" action="index.php?act=addToCart&id=<?= htmlspecialchars($product['id']); ?>">
        <label for="quantity-<?= htmlspecialchars($product['id']); ?>">Số lượng:</label>
        <div class="cart__body-quantity">
            <input type="button" value="-" class="cart__body-quantity-minus" onclick="updateQuantity(false)">
            <input type="number" step="1" min="1" max="999" name="quantity" id="quantity-<?= htmlspecialchars($product['id']); ?>" value="1">
            <input type="button" value="+" class="cart__body-quantity-plus" onclick="updateQuantity(true)">
        </div>
        <button type="submit" class="product__main-info-cart-btn">Thêm vào giỏ hàng</button>
    </form>
</div>
<script>
function updateQuantity(isIncrease) {
    const quantityInput = document.querySelector('input[name="quantity"]');
    let quantity = parseInt(quantityInput.value);
    quantity = isIncrease ? quantity + 1 : Math.max(1, quantity - 1); // Đảm bảo số lượng không nhỏ hơn 1
    quantityInput.value = quantity;
}
</script>


                            <div class="product__main-info-contact">
                                <a href="#" class="product__main-info-contact-fb">
                                    <i class="fab fa-facebook-f"></i>
                                    Chat Facebook
                                </a>
                                <div class="product__main-info-contact-phone-wrap">
                                    <div class="product__main-info-contact-phone-icon">
                                        <i class="fas fa-phone-alt "></i>
                                    </div>
                                    
                                    <div class="product__main-info-contact-phone">
                                        <div class="product__main-info-contact-phone-title">
                                            Gọi điện tư vấn
                                        </div>
                                        <div class="product__main-info-contact-phone-number">
                                            ( 0352.860.701)
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row bg-white">
                        <div class="col-12 product__main-tab">
                            <a href="#" class="product__main-tab-link product__main-tab-link--active">
                                Mô tả
                            </a>
                            <a href="#" class="product__main-tab-link">
                                Đánh giá
                            </a>
                        </div>

                        <div class="col-12 product__main-content-wrap">
                        <div class="product__main-info-description">
    <?= nl2br(htmlspecialchars($product['mo_ta'])); ?>
</div>
                            <h2 class="thongtin">    <span>Thông tin chi tiết</span> 
                             </h2>
                             <div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Công ty phát hành</th>
                <td><?= htmlspecialchars($product['nha_xuat_ban']); ?></td>
            </tr>
            <tr>
                <th>Ngày xuất bản</th>
                <td><?= htmlspecialchars($product['ngay_xuat_ban']); ?></td>
            </tr>
            <tr>
                <th>Số trang</th>
                <td><?= htmlspecialchars($product['so_trang']); ?></td>
            </tr>
        </tbody>
    </table>
</div>
                              
                        
                        </div>
                        
                    </div>
                </article>

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