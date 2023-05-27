<?php
declare(strict_types=1);

require '../config.php';

$query = "SELECT * FROM iframe_layers";

if (isset($pg_connect)) {
    $result = pg_query($pg_connect, $query);

    if ($result) {
        $data = pg_fetch_all($result);
        echo json_encode($data);
    } else {
        echo "Lỗi truy vấn dữ liệu.";
    }
} else {
    echo "Lỗi kết nối CSDL.";
}
?>
