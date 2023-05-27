<?php
declare(strict_types=1);

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iframe_url = $_POST['iframe_url'] ?? '';
    $name_iframe = $_POST['name_iframe'] ?? '';

    $query = "INSERT INTO iframe_layers (iframe_url, name_iframe) VALUES ('$iframe_url', '$name_iframe')";

    if (isset($pg_connect)) {
        $result = pg_query($pg_connect, $query);

        if ($result) {
            echo "Thêm dữ liệu thành công.";
        } else {
            echo "Thêm dữ liệu thất bại.";
        }
    } else {
        echo "Lỗi kết nối CSDL.";
    }
}
?>
