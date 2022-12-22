var map = L.map('map', {
    center: center,
    zoomSnap: 0.25,
    zoom: 10.75,
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