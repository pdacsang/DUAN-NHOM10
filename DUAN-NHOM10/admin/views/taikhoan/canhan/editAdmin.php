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
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="<?= BASE_URL_ADMIN. $thongTin['anh_dai_dien']; ?>" style="width: 100px;" class="avatar img-circle" alt="avatar" onerror="this.onerror=null; this.src='https://e7.pngegg.com/pngimages/178/595/png-clipart-user-profile-computer-icons-login-user-avatars-monochrome-black.png'">
          <h6 class="mt-2">Họ Tên : <?= $thongTin['ho_ten'] ?></h6>
          <h6 class="mt-2">Chức vụ : <?= $thongTin['chuc_vu_id'] ?></h6>
          <!-- <input type="file" class="form-control"> -->
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
      <form action="<?= BASE_URL_ADMIN . '?act=sua-thong-tin-ca-nhan-admin' ?>" method="post">
    <hr/>
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php } ?>
    <h3>Thông tin quản trị viên</h3>
    <div class="form-group">
        <label class="col-lg-3 control-label">Họ tên :</label>
        <div class="col-lg-12">
            <input class="form-control" type="text" name="ho_ten" value="<?= $thongTin['ho_ten'] ?>" placeholder="Nhập họ tên">
            <?php if (isset($_SESSION['error']['ho_ten'])) { ?>
                <p class="text-danger"><?= $_SESSION['error']['ho_ten'] ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Email:</label>
        <div class="col-lg-12">
            <input class="form-control" type="email" name="email" value="<?= $thongTin['email'] ?>" placeholder="Nhập email">
            <?php if (isset($_SESSION['error']['email'])) { ?>
                <p class="text-danger"><?= $_SESSION['error']['email'] ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Số điện thoại :</label>
        <div class="col-lg-12">
            <input class="form-control" type="text" name="so_dien_thoai" value="<?= $thongTin['so_dien_thoai'] ?>" placeholder="Điền số điện thoại">
            <?php if (isset($_SESSION['error']['so_dien_thoai'])) { ?>
                <p class="text-danger"><?= $_SESSION['error']['so_dien_thoai'] ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Ngày sinh :</label>
        <div class="col-lg-12">
            <input class="form-control" type="date" name="ngay_sinh" value="<?= $thongTin['ngay_sinh'] ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Giới tính :</label>
        <div class="col-lg-12">
            <select class="form-control" name="gioi_tinh">
                <option <?= $thongTin['gioi_tinh'] == '1' ? 'selected' : '' ?> value="1">Nam</option>
                <option <?= $thongTin['gioi_tinh'] == '0' ? 'selected' : '' ?> value="0">Nữ</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Địa chỉ :</label>
        <div class="col-lg-12">
            <input class="form-control" type="text" name="dia_chi" value="<?= $thongTin['dia_chi'] ?>" placeholder="Nhập địa chỉ">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Trạng thái tài khoản :</label>
        <div class="col-lg-12">
            <select name="trang_thai" class="form-control custom-select">
                <option <?= $thongTin['trang_thai'] == 1 ? 'selected' : '' ?> value="1">Active</option>
                <option <?= $thongTin['trang_thai'] !== 1 ? 'selected' : '' ?> value="2">Inactive</option>
            </select>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </div>
</form>

      <hr>
          <h3>Đổi mật khẩu</h3>
          <?php if (isset($_SESSION['success'])){ ?>
            <div class="alert alert-info alert-dismissable">
              <a class="panel-close close" data-dismiss="alert">×</a> 
              <i class="fa fa-coffee"></i>
              <?= $_SESSION['success'] ?>
            </div>
          <?php } ?>

          <form action="<?= BASE_URL_ADMIN. '?act=sua-mat-khau-ca-nhan-admin' ?>" method="post">
          <div class="form-group">
            <label class="col-md-3 control-label">Mật khẩu cũ :</label>
            <div class="col-md-12">
              <input class="form-control" type="text" name="old_pass" value="">
              <?php if (isset($_SESSION['error']['old_pass'])){ ?>
                <p class="text-danger"><?= $_SESSION['error']['old_pass'] ?></p>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Mật khẩu mới :</label>
            <div class="col-md-12">
              <input class="form-control" type="text" name="new_pass" value="">
              <?php if (isset($_SESSION['error']['new_pass'])){ ?>
                <p class="text-danger"><?= $_SESSION['error']['new_pass'] ?></p>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Nhập lại mật khẩu mới :</label>
            <div class="col-md-12">
              <input class="form-control" type="text" name="confirm_pass" value="">
              <?php if (isset($_SESSION['error']['confirm_pass'])){ ?>
                <p class="text-danger"><?= $_SESSION['error']['confirm_pass'] ?></p>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-12">
              <input type="submit" class="btn btn-primary" value="Save Changes">
            </div>
          </div>
          </form>
      </div>
  </div>
</div>
<hr>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once './views/layout/footer.php' ?>
</body>

</html>