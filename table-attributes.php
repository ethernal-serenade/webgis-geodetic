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

    <!-- Page Plugins CSS -->
    <link href="vendor/plugin/selectize/dist/css/selectize.default.css" rel="stylesheet">
    <link href="vendor/plugin/datatables/media/css/jquery.dataTables.css" rel="stylesheet"/>
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
                    <li class="nav-item">
                        <a class="mrg-top-15" href="index.php">
                            <span class="icon-holder">
                                <i class="ti-map-alt"></i>
                            </span>
                            <span class="title">Bản đồ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="index3d.php">
                            <span class="icon-holder">
                                <i class="ti-map-alt"></i>
                            </span>
                            <span class="title">Bản đồ 3D</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="index360.php">
                            <span class="icon-holder">
                                <i class="ti-map-alt"></i>
                            </span>
                            <span class="title">Bản đồ 360</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="indexPointCloud.php">
                            <span class="icon-holder">
                                <i class="ti-map-alt"></i>
                            </span>
                            <span class="title">Bản đồ PointCloud</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="indexDem.php">
                            <span class="icon-holder">
                                <i class="ti-map-alt"></i>
                            </span>
                            <span class="title">Bản đồ DEM</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="" href="table-attributes.php">
                            <span class="icon-holder">
                                <i class="fa fa-table"></i>
                            </span>
                            <span class="title">Các lớp dữ liệu</span>
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

            <div class="modal fade" id="deleteLayerModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Thông báo</h4>
                        </div>
                        <div class="modal-body">
                            <span>Bạn có chắc chắn muốn xoá lớp dữ liệu này?</span>
                        </div>
                        <div class="modal-footer no-border">
                            <div class="text-right">
                                <button class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary btn-sm" id="confirmDelete">Xoá</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="container-fluid">
                    <div class="row mrg-top-5">
                        <div class="col-md-4">
                            <div class="">
                                <label for="selectLayers" style="display: none"></label>
                                <select id="selectLayers" class="form-control">
                                    <!-- DOM Option -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button id="deleteLayer" class="btn btn-danger"
                                disabled data-toggle="modal" data-target="#deleteLayerModal">
                                Xoá lớp dữ liệu
                            </button>
                        </div>
                    </div>
                    <div id="containerTable" class="row mrg-top-20" style="display: none">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="table-reponsive">
                                        <table id="tableOfLayers" class="table table-bordered">
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/app/js/vendor.js"></script>
<script src="assets/app/js/app.min.js"></script>

<script src="vendor/plugin/selectize/dist/js/standalone/selectize.min.js"></script>
<script src="vendor/plugin/datatables/media/js/jquery.dataTables.js"></script>

<script src="assets/pages/js/config.js"></script>
<script src="assets/pages/js/table-attributes/main.js"></script>
</body>