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
            <h1>Quản Lý Sản Phẩm</h1>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="<?= BASE_URL_ADMIN . '?act=form-them-san-pham' ?>"class="btn btn-success">Thêm Sản Phẩm</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Giá Tiền</th>
                    <th>Thể Loại</th>
                    <th>Nhà Xuất Bản</th>
                    <th>Số Lượng</th>
                    <th>Danh Mục</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($listSanPham as $key => $sanPham) : ?>
                  <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $sanPham['ten_sach'] ?></td>
                    <td>
                      <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" style="height: 80px" alt=""
                      onerror="this.onerror=null; this.src='https://d1iv5z3ivlqga1.cloudfront.net/wp-content/uploads/2023/10/27135755/81NBmxCR30L._AC_UF10001000_QL80_.jpg'">
                    </td>
                    <td><?= $sanPham['gia_sach'] ?></td>
                    <td><?= $sanPham['ten_the_loai'] ?></td>
                    <td><?= $sanPham['nha_xuat_ban'] ?></td>
                    <td><?= $sanPham['so_luong'] ?></td>
                    <td><?= $sanPham['ten_danh_muc'] ?></td>
                    <td><?= $sanPham['trang_thai'] == 1 ? 'Còn Bán' : 'Dừng Bán' ?></td>
                    <td>
                      <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' .$sanPham['id'] ?>">
                        <button class="btn btn-warning">Sửa</button>
                      </a>
                      <a href="<?= BASE_URL_ADMIN . '?act=xoa-san-pham&id_san_pham=' .$sanPham['id'] ?>" 
                      onclick="return confirm('Bạn Có muốn xóa hay không?')">
                        <button class="btn btn-danger">Xóa</button>
                      </a>
                    </td>
                  </tr>
                    <?php endforeach ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>STT</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Giá Tiền</th>
                    <th>Thể Loại</th>
                    <th>Nhà Xuất Bản</th>
                    <th>Số Lượng</th>
                    <th>Danh Mục</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
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
