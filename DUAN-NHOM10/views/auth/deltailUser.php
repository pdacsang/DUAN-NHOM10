<?php require_once './views/layout/header.php' ?>
<?php require_once './views/layout/navbar.php' ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-11">
                    <h1>Thông tin cá nhân</h1>
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
                <div class="col-6">
                    <img src="<?= BASE_URL . $khachHang['anh_dai_dien'] ?>" style="width: 30%" alt=""
                    onerror="this.onerror=null; this.src='https://e7.pngegg.com/pngimages/178/595/png-clipart-user-profile-computer-icons-login-user-avatars-monochrome-black.png'">
                </div>
                <div class="col-6">
                    <div class="container">
                        <?php if (isset($_SESSION['flash'])): ?>
                            <?php if ($_SESSION['flash'] == 'success'): ?>
                                <div class="alert alert-success">Thông tin đã được cập nhật thành công!</div>
                            <?php elseif ($_SESSION['flash'] == 'error'): ?>
                                <div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại!</div>
                            <?php endif; ?>
                            <?php unset($_SESSION['flash']); ?>
                        <?php endif; ?>
                        <table class="table table-borderless">
                            <tbody style="font-size: large;">
                                <tr>
                                    <th>Họ tên :</th>
                                    <td><?= $khachHang['ho_ten'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Ngày sinh :</th>
                                    <td><?= $khachHang['ngay_sinh'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Email : </th>
                                    <td><?= $khachHang['email'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại : </th>
                                    <td><?= $khachHang['so_dien_thoai'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Giới tính : </th>
                                    <td><?= $khachHang['gioi_tinh'] == 1 ? 'Nam' : 'Nữ'; ?></td>
                                </tr>
                                <tr>
                                    <th>Địa chỉ : </th>
                                    <td><?= $khachHang['dia_chi'] ?? '' ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="<?= BASE_URL . '?act=form-sua-khach-hang'?>">
                             <button class="btn btn-warning">Chỉnh sửa thông tin</button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php require_once './views/layout/footer.php' ?>
