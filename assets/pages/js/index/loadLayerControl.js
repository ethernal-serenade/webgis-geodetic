var groupedOverlays = {}
var layerURL = []

$.ajax({
    type: "GET",
    url: "services/listOfLayers.php",
    async: false,
    success: function (data) {
        groupedOverlays["<span class='text-center text-primary font-size-16'>CÁC LỚP DỮ LIỆU</span>"] = {}
        data.forEach(function (layer) {
            let table_layer = layer.layer_name
            let layer_in_map
            $.ajax({
                type: "GET",
                url: "services/getGeoJsonFromLayer.php?table_layer=" + table_layer,
                async: false,
                success: function (data) {
                    layer_in_map = L.geoJSON(data, {
                        onEachFeature: function (feature, layer) {
                            let properties_key_array = Object.keys(feature.properties)
                            let properties_value_array = Object.values(feature.properties)
                            let popup_content = "<table class='table table-bordered table-striped'><tbody>"
                            properties_key_array.forEach(function (keys, index) {
                                if (keys != 'geojson') {
                                    popup_content += "<tr><th>" + keys + "</th>" +
                                        "<td>" + properties_value_array[index] + "</td></tr>"
                                }
                            })
                            popup_content += "</tbody></table>"
                            layer.bindPopup(popup_content)
                        }
                    })
                }
            })
            groupedOverlays["<span class='text-center text-primary font-size-16'>CÁC LỚP DỮ LIỆU</span>"]
                ["<span class='font-size-14'>" + layer.layer_name + "</span>"] = layer_in_map
        })
    }
})

var layerControl = L.control.groupedLayers(null, groupedOverlays, {
    position: 'topleft',
    collapsed: false
}).addTo(map);

map.on("overlayadd", function (e) {
    map.flyToBounds(e.layer.getBounds())
})

/* Zoom Filter by URL */
var currentURL = new URL(window.location.href);
var layer = currentURL.search.split("=")[1].split("&gid")[0];
var gid = currentURL.search.split("=")[2];
if (typeof layer != "undefined" && typeof gid != "undefined") {
    $.ajax({
        type: "GET",
        url: "services/getGeoJsonFromLayerByGid.php?table_layer=" + layer + "&gid=" + gid,
        async: false,
        success: function (data) {
            let properties_key_array = Object.keys(data.features[0].properties)
            let properties_value_array = Object.values(data.features[0].properties)
            let popup_content = "<table class='table table-bordered table-striped'><tbody>"
            properties_key_array.forEach(function (keys, index) {
                if (keys != 'geojson') {
                    popup_content += "<tr><th>" + keys + "</th>" +
                        "<td>" + properties_value_array[index] + "</td></tr>"
                }
            })
            popup_content += "</tbody></table>"

            let layer = L.geoJSON(data).addTo(map)
            // layer.bindPopup(popup_content).openPopup()
            var popup = L.popup()
                .setLatLng(layer.getBounds().getCenter())
                .setContent(popup_content)
            map.openPopup(popup);

            map.flyToBounds(layer.getBounds(), {
                duration: 1,
                // maxZoom: 15
            })
            makeDraggable(map, popup);
        }
    })
}
