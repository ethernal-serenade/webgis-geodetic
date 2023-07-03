/*----- Proj4String Converter Projection -----*/
const wgs84 = '+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs';
const vn2000_province = '';

/*----- Geoserver -----*/
var protocol = 'http://';
/*var subdomain_geoserver = 'localhost:8080/';
var subdomain_interpolation = 'localhost:8000/'*/
/*var protocol = 'https://';
var subdomain_geoserver = '10.151.46.88:8080/';
var subdomain_geoserver = 'geo.projgis.link/';*/

var host_geoserver = 'geoserver/';
var workspace = '';

/*--- Services for WMTS ---*/
var wmts = 'gwc/service/wmts?'
var services = '&style=' +
    '&tilematrixset=EPSG:900913' +
    '&Service=WMTS' +
    '&Request=GetTile' +
    '&Version=1.0.0' +
    '&Format=image/png' +
    '&TileMatrix=EPSG:900913:{z}&TileCol={x}&TileRow={y}&useCache=true&tiled=true';

/*----- Component Of Map -----*/
/*--- Center of Map ---*/
var center = [11.72477, 109.0113]

/*--- BaseMap Control ---*/
var l_basemap_control = [
    L.tileLayer('https://mt1.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        attribution: 'Google Map',
        subdomains: 'abcd',
        maxZoom: 20,
        minZoom: 0,
        label: 'Bản đồ Google',
        iconURL: 'https://mt1.google.com/vt/lyrs=p&x=101&y=60&z=7'
    }),

    L.tileLayer('https://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}', {
        attribution: 'Google Satellite',
        subdomains: 'abcd',
        maxZoom: 20,
        minZoom: 0,
        label: 'Ảnh vệ tinh Google',
        iconURL: 'https://mt0.google.com/vt/lyrs=s&hl=en&x=101&y=60&z=7'
    }),
]

/*--- Geocoder ---*/
var l_geocoder = L.Control.geocoder({
    geocoder: L.Control.Geocoder.nominatim(),
    showUniqueResult: true,
    showResultIcons: false,
    collapsed: false,
    expand: 'touch',
    position: 'topleft',
    placeholder: 'Tìm kiếm địa điểm...',
    errorMessage: 'Không tìm thấy địa điểm',
    iconLabel: 'Tìm kiếm địa điểm mới',
    query: '',
    queryMinLength: 1,
    suggestMinLength: 3,
    suggestTimeout: 250,
    defaultMarkGeocode: true
})

/*--- Fullscreen ---*/
var l_fullscreen = L.control.fullscreen({
    position: 'topleft',
    title: 'Phóng to bản đồ',
    titleCancel: 'Thu nhỏ bản đồ ',
})

/*--- Located User ---*/
var l_locate = L.control.locate({
    icon: 'fa fa-map-marker',
    locateOptions: {
        maxZoom: 20
    }
})

/*--- Zoom Home ---*/
var l_zoomhome = L.Control.zoomHome();

/*--- Measure Control ---*/
var l_measure_control = new L.Control.Measure({
    position: 'topleft',
    primaryLengthUnit: 'meters',
    secondaryLengthUnit: 'kilometers',
    primaryAreaUnit: 'hectares',
    secondaryAreaUnit: 'sqmeters',
    popupOptions: {
        className: 'leaflet-measure-resultpopup',
        autoPanPadding: [10, 10]
    },
    activeColor: '#ff0000',
    completedColor: '#f27000'
})

/*--- LatLong Show ---*/
var l_latlon_show = L.control.latLng({
    position: 'bottomleft'
})

/*--- MarkerCluster ---*/
function customMarkerCluster() {
    return L.markerClusterGroup({
        maxClusterRadius: 100,
        showCoverageOnHover: false,
        spiderLegPolylineOptions: {
            weight: 2,
            opacity: 1
        },
        iconCreateFunction: function (cluster) {
            var markers = cluster.getAllChildMarkers();
            huyen_style = '';
            name_huyen = '';
            markers.forEach(function (m) {
                district = m.feature.properties.huyen
                style_custom = gen_style_markercluster(district);
            })
            return L.divIcon({
                html: "<div><span class='text-dark' style='text-align: center'>" + style_custom.name_huyen +
                    markers.length + '</span></div>',
                className: 'marker-cluster ' + style_custom.huyen_style,
                iconSize: L.point(40, 40)
            })
        },
        disableClusteringAtZoom: 15,
        spiderfyOnMaxZoom: false,
        zoomToBoundsOnClick: true
    });
}

/*--- Draggable Popup ---*/
function makeDraggable(map, popup) {
    var pos = map.latLngToLayerPoint(popup.getLatLng());
    L.DomUtil.setPosition(popup._wrapper.parentNode, pos);
    var draggable = new L.Draggable(popup._container, popup._wrapper);
    draggable.enable();
}

/*--- DOM view latlng Map ---*/
function view_latlng_map(center) {
    $('.leaflet-control-lat').val(center[0]);
    $('.leaflet-control-lng').val(center[1]);
}
