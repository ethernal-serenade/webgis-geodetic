<?php
declare(strict_types=1);
$pg_connect = pg_connect('host=localhost
            port=5432
            dbname=webgis-geodetic
            user=postgres
            password=postgres'
);
if (!$pg_connect) {
    echo "Kết nối thất bại.\n";
}