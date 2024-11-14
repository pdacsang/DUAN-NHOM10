<?php require_once './views/layout/header.php' ?>
<?php require_once './views/layout/navbar.php' ?>
<?php require_once './views/layout/sidebar.php' ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-11">
                    <h1>Quản Lý Danh Sách Sản Phẩm</h1>
                </div>
                <div class="col-sm-1">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm Sản Phẩm</h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=them-san-pham' ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body row">
                                <div class="form-group col-12">
                                    <label">Tên Sản Phẩm</label>
                                    <input type="text" class="form-control" name="ten_sach" placeholder="Nhập tên sản phẩm">
                                </div>
                                <?php if(isset($errors['ten_sach'])){ ?>
                                    <p class="text-danger"><?= $errors['ten_sach'] ?></p>
                                <?php } ?>
                                
                                <div class="form-group col-12">
                                    <label">Giá Sản Phẩm</label>
                                    <input type="number" class="form-control" name="gia_sach" placeholder="Nhập giá sản phẩm">
                                </div>
                                <?php if(isset($errors['gia_sach'])){ ?>
                                    <p class="text-danger"><?= $errors['gia_sach'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Giá Khuyến Mãi</label>
                                    <input type="nember" class="form-control" name="gia_khuyen_mai" placeholder="Nhập gia khuyến mãi">
                                </div>
                                <?php if(isset($errors['gia_khuyen_mai'])){ ?>
                                    <p class="text-danger"><?= $errors['gia_khuyen_mai'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Hình Ảnh</label>
                                    <input type="file" class="form-control" name="hinh_anh" placeholder="Nhập hình ảnh">
                                </div>
                                <?php if(isset($errors['hinh_anh'])){ ?>
                                    <p class="text-danger"><?= $errors['hinh_anh'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Số Lượng</label>
                                    <input type="nember" class="form-control" name="so_luong" placeholder="Nhập số lượng">
                                </div>
                                <?php if(isset($errors['so_luong'])){ ?>
                                    <p class="text-danger"><?= $errors['so_luong'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Album Ảnh</label>
                                    <input type="file" class="form-control" name="img_array[]" multiple>
                                </div>

                                <div class="form-group col-12">
                                    <label">Ngày nhập</label>
                                    <input type="date" class="form-control" name="ngay_xuat_ban" placeholder="Nhập ngày nhập">
                                </div>
                                <?php if(isset($errors['ngay_xuat_ban'])){ ?>
                                    <p class="text-danger"><?= $errors['ngay_xuat_ban'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Danh Mục</label>
                                    <select class="form-control" name="danh_muc_id" id="exampleFormControlSelect1">
                                        <option selected disabled>Chọn danh mục sản phẩm</option>
                                        <?php foreach($listDanhMuc as $danhMuc): ?>
                                            <option value="<?= $danhMuc['id'] ?>"><?= $danhMuc['ten_danh_muc'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <?php if(isset($errors['so_luong'])){ ?>
                                    <p class="text-danger"><?= $errors['so_luong'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Trạng Thái</label>
                                    <select class="form-control" name="trang_thai" id="exampleFormControlSelect1">
                                        <option selected disabled>Chọn trạng thái sản phẩm</option>
                                        <option value="1">Còn Bán</option>
                                        <option value="2">Hết Hàng</option>
                                    </select>
                                </div>
                                <?php if(isset($errors['trang_thai'])){ ?>
                                    <p class="text-danger"><?= $errors['trang_thai'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Thể Loại</label>
                                    <input type="text" class="form-control" name="the_loai_id" placeholder="Nhập thể loại">
                                </div>
                                <?php if(isset($errors['the_loai_id'])){ ?>
                                    <p class="text-danger"><?= $errors['the_loai_id'] ?></p>
                                <?php } ?>

                                <div class="form-group col-12">
                                    <label">Mô Tả</label>
                                    <textarea name="mo_ta" class="form-control" placeholder="Nhập mô tả"></textarea>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once './views/layout/footer.php' ?>
</body>

</html>