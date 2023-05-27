<?php
declare(strict_types=1);

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $iframe_url = $_POST['iframe_url'] ?? '';
    $name_iframe = $_POST['name_iframe'] ?? '';

    $query = "UPDATE iframe_layers SET iframe_url='$iframe_url', name_iframe='$name_iframe' WHERE id='$id'";

    if (isset($pg_connect)) {
        $result = pg_query($pg_connect, $query);

        if ($result) {
            echo "Cập nhật dữ liệu thành công.";
        } else {
            echo "Cập nhật dữ liệu thất bại.";
        }
    } else {
        echo "Lỗi kết nối CSDL.";
    }
}
?>
