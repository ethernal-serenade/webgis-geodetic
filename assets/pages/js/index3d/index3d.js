// wrld3d
// let map = Wrld.map("map", "a26053eebfc4e94f95c3667b6573413f", {
//     center: [10.76532, 106.68164],
//     zoom: 16,
//     trafficEnabled: false,
//     frameRateThrottleWhenIdleEnabled: true,
//     throttledTargetFrameIntervalMilliseconds: 1000,
//     idleSecondsBeforeFrameRateThrottle: 1000
// });

var map = new OSMBuildings({
    container: 'map',
    position: { latitude: 10.76532, longitude: 106.68164 },
    // Độ nghiêng
    tilt: 40,
    zoom: 18,
    fastMode: true
});

map.addMapTiles('https://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}',{
    attribution: 'WebGIS Geodetic'
});

map.addGeoJSONTiles('http://{s}.data.osmbuildings.org/0.2/anonymous/tile/{z}/{x}/{y}.json');

// My testing data
map.addGeoJSON('data/test-show-height.geo.json')


function rotate () {
    map.setRotation(rotation);
    rotation = (rotation+1) % 360;
    requestAnimationFrame(rotate);
}
// rotate ()
