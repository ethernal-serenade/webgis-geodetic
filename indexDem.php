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

    <!-- DEM CSS -->
    <link href="assets/pages/js/indexDem/qgis2threejs/Qgis2threejs.css" rel="stylesheet"/>
    <link href="assets/pages/js/indexDem/main.css" rel="stylesheet"/>
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
                        <a class="" href="indexDem.php">
                            <span class="icon-holder">
                                <i class="ti-map-alt"></i>
                            </span>
                            <span class="title">Bản đồ DEM</span>
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
                    <div id="view">
                        <div id="labels"></div>
                        <div id="northarrow"></div>
                        <div id="navigation"></div>
                    </div>
                </div>
            </div>

            <div id="popup">
                <div id="closebtn">&times;</div>
                <div id="popupbar"></div>
                <div id="popupbody">
                    <div id="popupcontent"></div>

                    <!-- query result -->
                    <div id="queryresult">
                        <table id="qr_layername_table" class="mt-3">
                            <th>Layer name</th>
                            <tr>
                                <td id="qr_layername"></td>
                            </tr>
                        </table>

                        <table id="qr_coords_table" class="mt-3">
                            <th>Clicked coordinates</th>
                            <tr>
                                <td id="qr_coords"></td>
                            </tr>
                        </table>

                        <!-- camera actions -->
                        <!--<div class="action-btn action-zoom btn btn-sm btn-info mt-3"
                             onclick="app.cameraAction.zoomIn(); app.closePopup();">
                            Zoom in here
                        </div>-->
                        <div class="action-btn action-move btn btn-sm btn-info mt-3"
                             onclick="app.cameraAction.move(); app.closePopup();">
                            Move here
                        </div>
                        <div class="action-btn action-orbit btn btn-sm btn-info mt-3"
                             onclick="app.cameraAction.orbit(); app.closePopup();">
                            Orbit around here
                        </div>

                        <!-- attributes -->
                        <table id="qr_attrs_table">
                            <caption>Attributes</caption>
                        </table>
                    </div>

                    <!-- page info -->
                    <div id="pageinfo">
                        <h1>Current View URL</h1>
                        <div><input id="urlbox" type="text"></div>

                        <h1>Usage</h1>
                        <table id="usage">
                            <tr>
                                <td colspan="2" class="star">Mouse</td>
                            </tr>
                            <tr>
                                <td>Left button + Move</td>
                                <td>Orbit</td>
                            </tr>
                            <tr>
                                <td>Mouse Wheel</td>
                                <td>Zoom</td>
                            </tr>
                            <tr>
                                <td>Right button + Move</td>
                                <td>Pan</td>
                            </tr>

                            <tr>
                                <td colspan="2" class="star">Keys</td>
                            </tr>
                            <tr>
                                <td>Arrow keys</td>
                                <td>Move Horizontally</td>
                            </tr>
                            <tr>
                                <td>Shift + Arrow keys</td>
                                <td>Orbit</td>
                            </tr>
                            <tr>
                                <td>Ctrl + Arrow keys</td>
                                <td>Rotate</td>
                            </tr>
                            <tr>
                                <td>Shift + Ctrl + Up / Down</td>
                                <td>Zoom In / Out</td>
                            </tr>
                            <tr>
                                <td>L</td>
                                <td>Toggle Label Visibility</td>
                            </tr>
                            <tr>
                                <td>R</td>
                                <td>Start / Stop Orbit Animation</td>
                            </tr>
                            <tr>
                                <td>W</td>
                                <td>Wireframe Mode</td>
                            </tr>
                            <tr>
                                <td>Shift + R</td>
                                <td>Reset Camera Position</td>
                            </tr>
                            <tr>
                                <td>Shift + S</td>
                                <td>Save Image</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- progress bar -->
                <div id="progress">
                    <div id="bar"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/app/js/vendor.js"></script>
    <script src="assets/app/js/app.min.js"></script>

    <!-- DEM JS -->
    <script src="assets/pages/js/indexDem/threejs/three.min.js"></script>
    <script src="assets/pages/js/indexDem/threejs/OrbitControls.js"></script>
    <script src="assets/pages/js/indexDem/threejs/ViewHelper.js"></script>
    <script src="assets/pages/js/indexDem/threejs/OutlineEffect.js"></script>
    <script src="assets/pages/js/indexDem/proj4js/proj4.js"></script>
    <script src="assets/pages/js/indexDem/qgis2threejs/Qgis2threejs.js"></script>

    <script>
        Q3D.Config.allVisible = true;
        Q3D.Config.viewpoint = {
            lookAt: {x: 743975.912670398, y: 1710354.996044841, z: 612.403076171875},
            pos: {x: 744215.4570555881, y: 1712971.574306736, z: 2426.0455604225244}
        };
        Q3D.Config.localMode = true;
        Q3D.Config.northArrow.enabled = true;
        Q3D.Config.northArrow.color = 0x666666;

        var container = document.getElementById("view"),
            app = Q3D.application,
            gui = Q3D.gui;

        app.init(container); // initialize viewer

        // load the scene
        app.loadSceneFile("assets/pages/js/indexDem/data/scene.js", function (scene) {
            // scene file has been loaded
            app.start();
        }, function (scene) {
            // all relevant files have been loaded
        });
    </script>
    <script src="assets/pages/js/indexDem/main.js"></script>
</body>