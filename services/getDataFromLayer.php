<?php
declare(strict_types=1);
require 'config.php';
?>

<?php
header('Content-Type: application/json');

$table_layer = $_GET['option'];
$query = 'SELECT * FROM ' . '"' . $table_layer . '"';

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
    $final_datatable = [];
    foreach ($original_data as $key_object => $value) {
        unset($value['geom']);
        $final_datatable[] = $value;
    }

    echo json_encode($final_datatable);
} else {
    echo json_encode([]);
}
?>
