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

    <!-- PointCloud CSS -->
    <link href="assets/pages/js/indexPointCloud/potree/potree.css" rel="stylesheet"/>
    <link href="assets/pages/js/indexPointCloud/libs/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
    <link href="assets/pages/js/indexPointCloud/libs/openlayers3/ol.css" rel="stylesheet"/>
    <link href="assets/pages/js/indexPointCloud/libs/spectrum/spectrum.css" rel="stylesheet"/>
    <link href="assets/pages/js/indexPointCloud/libs/jstree/themes/mixed/style.css" rel="stylesheet"/>
    <link href="assets/pages/js/indexPointCloud/entwine/entwine.css" rel="stylesheet"/>
    <style>
        #potree_render_area {
            width: 100%;
            height: 100%;
        }
    </style>
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
                    <li class="nav-item active">
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

            <div class="main-content">
                <div class="full-container">
                    <div id="potree_container">
                        <div id="potree_render_area"></div>
                        <div id="potree_sidebar_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/app/js/vendor.js"></script>
<script src="assets/app/js/app.min.js"></script>

<!-- PointCloud JS -->
<script src="assets/pages/js/indexPointCloud/libs/spectrum/spectrum.js"></script>

<script src="assets/pages/js/indexPointCloud/libs/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/jquery-ui/jquery-ui.min.js"></script>

<script src="assets/pages/js/indexPointCloud/libs/three.js/build/three.min.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/other/BinaryHeap.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/tween/tween.min.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/d3/d3.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/proj4/proj4.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/openlayers3/ol.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/i18next/i18next.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/jstree/jstree.js"></script>
<script src="assets/pages/js/indexPointCloud/potree/potree.js"></script>
<script src="assets/pages/js/indexPointCloud/libs/plasio/js/laslaz.js"></script>

<script type="module">
    import * as THREE from "./assets/pages/js/indexPointCloud/libs/three.js/build/three.module.js";

    window.viewer = new Potree.Viewer(document.getElementById("potree_render_area"));

    viewer.setEDLEnabled(true);
    viewer.setFOV(60);
    viewer.setPointBudget(1_000_000_000);
    viewer.useHQ = true;
    // viewer.loadSettingsFromURL();

    // viewer.setDescription("Loading Entwine-generated EPT format");

    viewer.loadGUI(() => {
        viewer.setLanguage('en');
        $("#menu_appearance").next().show();
        //viewer.toggleSidebar();
    });

    // Lion
    Potree.loadPointCloud("assets/pages/js/indexPointCloud/data/my_pointclouds/dongthap/cloud.js", "dongthap", function(e){
        viewer.scene.addPointCloud(e.pointcloud);

        let material = e.pointcloud.material;
        material.size = 1;
        material.pointSizeType = Potree.PointSizeType.ADAPTIVE;

        viewer.fitToScreen();
    });

    Potree.loadPointCloud("assets/pages/js/indexPointCloud/data/my_pointclouds/vungtau/cloud.js", "vungtau", function(e){
        viewer.scene.addPointCloud(e.pointcloud);

        let material = e.pointcloud.material;
        material.size = 1;
        material.pointSizeType = Potree.PointSizeType.ADAPTIVE;

        viewer.fitToScreen();
    });
</script>
</body>