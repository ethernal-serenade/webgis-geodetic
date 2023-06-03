var map = L.map('map', {
    center: [14.80847, 108.93658],
    zoomSnap: 0.25,
    zoom: 11.75,
    maxZoom: 20,
    // minZoom: 10.75,
    zoomControl: false,
});

map.addControl(
    L.control.basemaps({
        basemaps: l_basemap_control,
        tileX: 0,
        tileY: 0,
        tileZ: 1
    }),
);

l_geocoder.addTo(map);
l_fullscreen.addTo(map);
l_locate.addTo(map);
l_zoomhome.addTo(map);
l_measure_control.addTo(map);
map.removeControl(map.latLngControl);

map.addControl(l_latlon_show);
view_latlng_map(center)

// Process Panorama
var imageLocations = [
    {
        id: 1,
        lat: 14.70476925,
        lng: 108.991851027778,
        imageUrl: 'assets/pages/js/indexPanorama/images/01_Ham2_PhiaBac.jpg',
        panoramaUrl: 'assets/pages/js/indexPanorama/images/01_Ham2_PhiaBac.jpg',
        nextPanoramaId: 2,
        previousPanoramaId: 4
    },
    {
        id: 2,
        lat: 14.7113158055556,
        lng: 108.989444111111,
        imageUrl: 'assets/pages/js/indexPanorama/images/02_BanDieuHanh_Ham2.jpg',
        panoramaUrl: 'assets/pages/js/indexPanorama/images/02_BanDieuHanh_Ham2.jpg',
        nextPanoramaId: 3,
        previousPanoramaId: 1
    },
    {
        id: 3,
        lat: 14.6594149444444,
        lng: 109.007506222222,
        imageUrl: 'assets/pages/js/indexPanorama/images/03_Ham3_PhiaNam.jpg',
        panoramaUrl: 'assets/pages/js/indexPanorama/images/03_Ham3_PhiaNam.jpg',
        nextPanoramaId: 4,
        previousPanoramaId: 2
    },
    {
        id: 4,
        lat: 14.9504481111111,
        lng: 108.864309444444,
        imageUrl: 'assets/pages/js/indexPanorama/images/04_MuiThiCong_01.jpg',
        panoramaUrl: 'assets/pages/js/indexPanorama/images/04_MuiThiCong_01.jpg',
        nextPanoramaId: 1,
        previousPanoramaId: 3
    }
];

// Thêm vị trí ảnh và liên kết tương ứng lên bản đồ
imageLocations.forEach(function(location) {
    var marker = L.marker([location.lat, location.lng]).addTo(map);
    marker.on('click', function() {
        openPanorama(location);
    });
});

// Mở ảnh panorama khi bấm vào ảnh
function openPanorama(location) {
    $('#panoramaModal').modal('show');

    var panorama = pannellum.viewer('panorama', {
        "default": {
            "sceneFadeDuration": 1000,
            "autoLoad": true
        },
        type: 'equirectangular',
        panorama: location.panoramaUrl,
    });

    $('#nextButton').on('click', function() {
        var nextLocation = imageLocations.find(function(loc) {
            return loc.id === location.nextPanoramaId;
        });

        if (nextLocation) {
            panorama.destroy();
            openPanorama(nextLocation);
        }
    });

    $('#previousButton').on('click', function() {
        var previousLocation = imageLocations.find(function(loc) {
            return loc.id === location.previousPanoramaId;
        });

        if (previousLocation) {
            panorama.destroy();
            openPanorama(previousLocation);
        }
    });
}