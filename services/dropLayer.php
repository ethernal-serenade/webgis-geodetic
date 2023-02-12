<?php
declare(strict_types=1);
require 'config.php';
?>

<?php
header('Content-Type: application/json');
$table_layer = $_GET['table_layer'];
$query = 'DROP TABLE IF EXISTS ' . '"' . $table_layer . '"';
if (isset($pg_connect)) {
    echo pg_query($pg_connect, $query);
} else {
    echo "Error";
}
?>
