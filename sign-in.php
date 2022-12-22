<?php
declare(strict_types=1);
session_start()
?>

<?php
require_once('services/config.php');
if (isset($_POST['btn_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    /*---- Make Clear Input ----*/
    $username = strip_tags($username);
    $username = addslashes($username);
    $password = strip_tags($password);
    $password = addslashes($password);
    if ($username == '' || $password == '') {
        echo 'username hoặc password bạn không được để trống!';
    } else {
        $query_sql = 'select * from users where username =' . "'" . $username . "'" .
            'and password =' . "'" . $password . "'";
        if (isset($pg_connect)) {
            $query = pg_query($pg_connect, $query_sql);
            $num_rows = pg_num_rows($query);
            if ($num_rows == 0) {
                echo "<script>alert('Tên đăng nhập hoặc Mật khẩu không đúng !')</script>";
            } else {
                while ($row_data = pg_fetch_assoc($query)) {
                    $_SESSION['userid'] = $row_data['id'];
                    $_SESSION['username'] = $row_data['username'];
                }
                header('Location: index.php');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <title>WebGIS Geodetic</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/app/images/logo/favicon.png"/>

    <!-- Plugins CSS -->
    <link href="vendor/plugin/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
    <link href="vendor/plugin/PACE/themes/blue/pace-theme-minimal.css" rel="stylesheet"/>
    <link href="vendor/plugin/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet"/>

    <!-- Core CSS -->
    <link href="assets/app/css/ei-icon.css" rel="stylesheet"/>
    <link href="assets/app/css/themify-icons.css" rel="stylesheet"/>
    <link href="assets/app/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="assets/app/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/app/css/app.css" rel="stylesheet"/>
</head>

<body>
<div class="app">
    <div class="authentication">
        <div class="sign-in">
            <div class="row no-mrg-horizon">
                <div class="col-md-8 no-pdd-horizon d-none d-md-block">
                    <div class="full-height bg"
                         style="background-image: url('assets/app/images/others/thumbnail.jpg')">
                        <div class="img-caption">
                            <h1 class="caption-title text-bold">WebGIS Geodetic</h1>
                            <p class="caption-text"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 no-pdd-horizon">
                    <div class="full-height bg-white height-100">
                        <div class="vertical-align full-height pdd-horizon-70">
                            <div class="table-cell">
                                <div class="pdd-horizon-15">
                                    <h2 class="text-bold">ĐĂNG NHẬP</h2>
                                    <form method="post" action="sign-in.php">
                                        <div class="form-group">
                                            <label for="username">Tài khoản</label>
                                            <input id="username" type="text" name="username"
                                                   class="form-control" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Mật khẩu</label>
                                            <input id="password" type="password" name="password"
                                                   class="form-control" placeholder="Password">
                                        </div>
                                        <!--<div class="checkbox font-size-12">
                                            <input id="agreement" name="agreement" type="checkbox">
                                            <label for="agreement">Keep Me Signed In</label>
                                        </div>-->
                                        <button type="submit" name="btn_submit" class="btn btn-info">Đăng nhập</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--<div class="login-footer">
                            <img class="img-responsive inline-block"
                                 src="assets/app/images/logo/logo.png" width="150" alt="">
                            <span class="font-size-13 pull-right pdd-top-10">Chưa có tài khoản?
                                <a href="#">Đăng ký</a>
                            </span>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/app/js/vendor.js"></script>
<script src="assets/app/js/app.min.js"></script>
</body>
</html>