<?php
declare(strict_types=1);
require 'config.php';
?>

<?php
header('Content-Type: application/json');

$table_layer = $_GET['table_layer'];
$query = 'SELECT *, ST_AsGeoJSON(ST_Transform(geom, 4326)) AS geojson FROM ' . '"' . $table_layer . '"';

if (isset($pg_connect)) {
    $result = pg_query($pg_connect, $query);

    if (!$result) {
        echo "Không có dữ liệu.\n";
    }

    $data_convert = [];
    while ($row_convert = pg_fetch_assoc($result)) {
        $data_convert[] = $row_convert;
    }

    $json_data = json_encode($data_convert);
    $original_data = json_decode($json_data, true);
    $final_data = [
        'type' => 'FeatureCollection',
        'features' => []
    ];
    foreach ($original_data as $key_object => $value) {
        unset($value['geom']);

        $final_data['features'][] = [
            'type' => 'Feature',
            'geometry' => json_decode($value['geojson'], true),
            'properties' => $value
        ];
    }

    echo json_encode($final_data);
} else {
    echo json_encode([
        'type' => 'FeatureCollection',
        'features' => []
    ]);
}
?>
