<?php
declare(strict_types=1);
require 'config.php';
?>

<?php
header('Content-Type: application/json');
$query = "SELECT table_name as layer_name FROM information_schema.tables WHERE table_schema = 'public' 
                                          and (table_name <> 'geography_columns' 
                                                   and table_name <> 'geometry_columns' 
                                                   and table_name <> 'spatial_ref_sys'
                                                   and table_name <> 'users')";
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
    $option = [];
    foreach ($original_data as $key_object => $value) {
        $option[] = [
            'id' => $key_object,
            'layer_name' => $value['layer_name'],
        ];
    }

    $final_data = json_encode($option);
} else {
    $final_data = json_encode([]);
}

echo $final_data;
?>
