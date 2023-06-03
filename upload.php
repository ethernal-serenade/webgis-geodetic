<?php
declare(strict_types=1);
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: sign-in.php');
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
    <div class="layout">
        <div class="side-nav">
            <div class="side-nav-inner">
                <div class="side-nav-logo">
                    <a href="index.php">
                        <div class="logo logo-dark"
                             style="background-image: url('assets/app/images/logo/logo.png')"></div>
                        <div class="logo logo-white"
                             style="background-image: url('assets/app/images/logo/logo-white.png')"></div>
                    </a>
                    <div class="mobile-toggle side-nav-toggle">
                        <a href="#">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
                <ul class="side-nav-menu scrollable">
                    <?php
                    require_once('config-sidebar.php');
                    if (isset($sidebar)) {
                        echo $sidebar;
                    }
                    ?>

                    <?php
                    require_once('services/config.php');
                    $query = "SELECT * FROM iframe_layers";
                    if (isset($pg_connect)) {
                        $result = pg_query($pg_connect, $query);

                        if ($result) {
                            $data = pg_fetch_all($result);

                            if ($data) {
                                // In danh sách iframe layers
                                foreach ($data as $row) {
                                    echo '<li class="nav-item">';
                                    echo '<a class="" href="#iframe_' . $row['id'] . '">';
                                    echo '<span class="icon-holder">';
                                    echo '<i class="ti-map-alt"></i>';
                                    echo '</span>';
                                    echo '<span class="title">&nbsp;' . $row['name_iframe'] . '</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                            } else {
                                echo "";
                            }
                        } else {
                            echo "";
                        }
                    } else {
                        echo "";
                    }
                    ?>

                    <?php
                    require_once('services/config.php');
                    if (isset($_SESSION['role'])) {
                        $role_user = $_SESSION['role'];
                        if ($role_user === 'admin') {
                            echo '
                             <li class="nav-item">
                                <a class="" href="table-attributes.php">
                                    <span class="icon-holder">
                                        <i class="fa fa-table"></i>
                                    </span>
                                    <span class="title">Các lớp dữ liệu</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="" href="iframe-crud.php">
                                    <span class="icon-holder">
                                        <i class="fa fa-table"></i>
                                    </span>
                                    <span class="title">Các lớp iframe</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="" href="upload.php">
                                    <span class="icon-holder">
                                        <i class="fa fa-upload"></i>
                                    </span>
                                    <span class="title">Upload</span>
                                </a>
                            </li>
                            ';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="page-container">
            <div class="header navbar">
                <div class="header-container">
                    <ul class="nav-left">
                        <li>
                            <a class="side-nav-toggle" href="javascript:void(0);">
                                <i class="ti-view-grid"></i>
                            </a>
                        </li>
                        <li class="search-box">
                            <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                                <i class="search-icon ti-search pdd-right-10"></i>
                                <i class="search-icon-close ti-close pdd-right-10"></i>
                            </a>
                        </li>
                        <li class="search-input">
                            <label for="search" style="display: none"></label>
                            <input id="search" class="form-control" type="text" placeholder="Tìm kiếm...">
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="user-profile dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img class="profile-img img-fluid" src="assets/app/images/user.png" alt="">
                                <div class="user-info">
                                    <span class="name pdd-right-5">
                                        <?php
                                        require_once('services/config.php');
                                        if (isset($_SESSION['username'])) {
                                            $query_sql = 'select fullname from users where username =' . "'" .
                                                $_SESSION['username'] . "'";
                                            if (isset($pg_connect)) {
                                                $result = pg_query($pg_connect, $query_sql);
                                                if (!$result) {
                                                    echo "Không có dữ liệu.\n";
                                                    exit;
                                                }
                                                $data_fullname = [];
                                                while ($row_result = pg_fetch_assoc($result)) {
                                                    $data_fullname[] = $row_result;
                                                }
                                                echo $data_fullname[0]['fullname'];
                                            }
                                        }
                                        ?>
                                    </span>
                                    <i class="ti-angle-down font-size-10"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <!--<li>
                                    <a href="#">
                                        <i class="ti-user pdd-right-10"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>-->
                                <li>
                                    <a href="sign-out.php">
                                        <i class="ti-power-off pdd-right-10"></i>
                                        <span>Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="main-content">
                <div class="container-fluid">
                    <div class="page-title">
                        <h4>Upload Shapefile</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form enctype="multipart/form-data"
                                  method="POST"
                                  class="form-horizontal pdd-right-30">
                                <div class="row justify-content-md-center">
                                    <div class="col-md-4">
                                        <label for="name" class="control-label">Tên file</label>
                                        <input type="text" class="form-control" id="name" placeholder="Tên file">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="srid" class="control-label">SRID</label>
                                        <input type="text" class="form-control" id="srid" placeholder="SRID">
                                    </div>
                                </div>
                                <div class="row justify-content-md-center mrg-top-30">
                                    <div class="col-md-4">
                                        <label for="fileUpload" class="control-label" style="display: none"></label>
                                        <input type="file" class="form-control" id="fileUpload">
                                    </div>
                                    <div class="col-md-4">
                                        <a id="confirmUpload" href="#" class="btn btn-info">
                                            <i class="ti-export pdd-right-5"></i>
                                            <span>Upload</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div id="statusUpload" class="col-md-8"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/app/js/vendor.js"></script>
<script src="assets/app/js/app.min.js"></script>

<script src="assets/pages/js/config.js"></script>
<script src="assets/pages/js/upload/main.js"></script>
</body>