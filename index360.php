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

    <!-- Map Plugins CSS -->
    <!-- <link href="vendor/map/css/leaflet.css" rel="stylesheet"/>
    <link href="vendor/map/css/leaflet.groupedlayercontrol.css" rel="stylesheet"/>
    <link href="vendor/map/css/leaflet.zoomhome.css" rel="stylesheet"/>
    <link href="vendor/map/css/leaflet-geoman.css" rel="stylesheet"/>
    <link href="vendor/map/css/leaflet-gps.css" rel="stylesheet"/>
    <link href="vendor/map/css/leaflet-measure.css" rel="stylesheet"/>
    <link href="vendor/map/css/leaflet-sidebar.css" rel="stylesheet"/>
    <link href="vendor/map/css/Control.FullScreen.css" rel="stylesheet"/>
    <link href="vendor/map/css/Control.Geocoder.css" rel="stylesheet"/>
    <link href="vendor/map/css/Control.LatLng.css" rel="stylesheet"/>
    <link href="vendor/map/css/easy-button.css" rel="stylesheet"/>
    <link href="vendor/map/css/L.Control.Basemaps.css" rel="stylesheet"/>
    <link href="vendor/map/css/L.Control.Locate.css" rel="stylesheet"/>
    <link href="vendor/map/css/L.Icon.Pulse.css" rel="stylesheet"/>
    <link href="vendor/map/css/MarkerCluster.css" rel="stylesheet"/> -->

    <!--<link href="assets/pages/js/index3d/OSMBuildings.css" rel="stylesheet">-->

    <!-- Map Custom CSS -->
    <link href="assets/pages/css/mapStyle.css" rel="stylesheet"/>
    <style>
        .osmb, .osmb-viewport {
            width: 100%;
            height: 100%;
        }
        .osmb-attribution {
            display: none;
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
                    <li class="nav-item active">
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
                    <div id="map">
                        <iframe
                                src="https://www.arcgis.com/apps/360vr/index.html?id=bb619b6cee12465ba4262fffebb1bf8c&fbclid=IwAR2ZwLsAc4c9JnOY9E2KwEePQVOjXZ1ISdLieoBy7_R1Nfa76r2r5nuS-n4"
                                title=""
                                style="overflow:hidden; height:calc(100vh - 71px); width:100%"
                                height="100%"
                                width="100%"
                        >
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/app/js/vendor.js"></script>
<script src="assets/app/js/app.min.js"></script>

<!-- Map Plugins JS
<script src="vendor/map/js/leaflet.js"></script> -->

<!-- wrld3d -->
<script src="https://unpkg.com/wrld.js@1.x.x"></script>

<!-- OSM Building -->
<script src="assets/pages/js/index3d/OSMBuildings.js"></script>

<!--<script src="vendor/map/js/leaflet_old.js'"></script>
<script src="vendor/map/js/leaflet-src.esm.js"></script>
<script src="vendor/map/js/leaflet-src.esm.js.map"></script>
<script src="vendor/map/js/leaflet-src.js"></script>
<script src="vendor/map/js/leaflet-src.js.map"></script>
<script src="vendor/map/js/leaflet.js.map"></script>
<script src="vendor/map/js/leaflet.ajax.js"></script>-->
<script src="vendor/map/js/leaflet.ajax.min.js"></script>
<script src="vendor/map/js/leaflet.pattern.js"></script>
<script src="vendor/map/js/Control.FullScreen.js"></script>
<script src="vendor/map/js/Control.Geocoder.js"></script>
<script src="vendor/map/js/Control.LatLng.js"></script>
<script src="vendor/map/js/easy-button.js"></script>
<script src="vendor/map/js/geojson-bbox.min.js"></script>
<script src="vendor/map/js/L.Control.Basemaps-min.js"></script>
<!--<script src="vendor/map/js/geojson-bbox.js"></script>
<script src="vendor/map/js/geojson-bbox.js.map"></script>
<script src="vendor/map/js/L.Control.Basemaps.js"></script>-->
<script src="vendor/map/js/L.Control.Locate.js"></script>
<script src="vendor/map/js/L.Geoserver.js"></script>
<script src="vendor/map/js/L.Icon.Pulse.js"></script>
<script src="vendor/map/js/L.Map.Sync.js"></script>
<script src="vendor/map/js/rbush.js"></script>
<script src="vendor/map/js/labelgun.js"></script>
<script src="vendor/map/js/leaflet-bounce.js"></script>
<script src="vendor/map/js/leaflet-geoman.min.js"></script>
<!--<script src="vendor/map/js/leaflet-google.js"></script>
<script src="vendor/map/js/leaflet-gps.js"></script>-->
<script src="vendor/map/js/leaflet-measure.js"></script>
<script src="vendor/map/js/leaflet-sidebar.js"></script>
<script src="vendor/map/js/Leaflet.Control.Custom.js"></script>
<script src="vendor/map/js/leaflet.groupedlayercontrol.js"></script>
<script src="vendor/map/js/leaflet.markercluster.js"></script>
<!--<script src="vendor/map/js/leaflet.markercluster-src.js"></script>
<script src="vendor/map/js/leaflet.markercluster-src.js.map"></script>
<script src="vendor/map/js/leaflet.markercluster.js.map"></script>-->
<script src="vendor/map/js/leaflet.zoomhome.js"></script>
<script src="vendor/map/js/geotiff.js"></script>
<script src="vendor/map/js/plotty.js"></script>
<script src="vendor/map/js/leaflet-geotiff.js"></script>
<script src="vendor/map/js/leaflet.textpath.js"></script>
<script src="vendor/map/js/leaflet.featuregroup.subgroup.js"></script>
<script src="vendor/map/js/proj4.js"></script>
<!--<script src="vendor/map/js/leaflet-geotiff-plotty.js"></script>
<script src="vendor/map/js/leaflet-geotiff-vector-arrows.js"></script>-->

<!-- Map 3D Custom JS -->
<!--<script src="assets/pages/js/index3d/index3d.js"></script>-->
</body>