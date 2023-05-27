<?php
declare(strict_types=1);

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    $query = "DELETE FROM iframe_layers WHERE id='$id'";

    if (isset($pg_connect)) {
        $result = pg_query($pg_connect, $query);

        if ($result) {
            echo "Xóa dữ liệu thành công.";
        } else {
            echo "Xóa dữ liệu thất bại.";
        }
    } else {
        echo "Lỗi kết nối CSDL.";
    }
}
?>
