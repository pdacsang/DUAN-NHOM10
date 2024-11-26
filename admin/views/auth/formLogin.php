<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sign in Admin</title>
  <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
  <link rel="stylesheet" href="./asset/css/typography.css">
  <link rel="stylesheet" href="./asset/css/style.css">
  <link rel="stylesheet" href="./asset/css/responsive.css">
  <style>
    .text-danger-custom {
      color: #d32f2f;
    }
  </style>
</head>

<body>
  <div id="loading">
    <div id="loading-center">
    </div>
  </div>
  <section class="sign-in-page">
    <div class="container p-0">
      <div class="row no-gutters height-self-center">
        <div class="col-sm-12 align-self-center page-content rounded">
          <div class="row m-0">
            <div class="col-sm-12 sign-in-page-data">
              <div class="sign-in-from bg-primary rounded">
                <h3 class="mb-0 text-center text-white">Sign in</h3>
                <?php if (isset($_SESSION['error'])) { ?>
                  <p class="text-danger-custom text-center"><?= $_SESSION['error'] ?></p>
                <?php } else { ?>
                  <p class="text-center text-white">Vui lòng đăng nhập để vào Admin</p>
                <?php } ?>
                <form action="<?= BASE_URL_ADMIN . '?act=check-login-admin' ?>" method="POST" class="mt-4 form-text">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control mb-0 text-dark" id="" placeholder="Enter email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <a href="#" class="float-right text-dark">Quên Mật Khẩu ?</a>
                    <input type="text" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password" style="color: black;" name="password">
                  </div>
                  <div class="d-inline-block w-100">
                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Remember Me</label>
                    </div>
                  </div>
                  <div class="sign-info text-center">
                    <button type="submit" class="btn btn-white d-block w-100 mb-2">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Sign in END -->
  <script src="./asset/js/jquery.min.js"></script>
  <script src="./asset/js/bootstrap.min.js"></script>
  <script src="./asset/js/jquery.magnific-popup.min.js"></script>
  <script src="./asset/js/custom.js"></script>
</body>

</html>