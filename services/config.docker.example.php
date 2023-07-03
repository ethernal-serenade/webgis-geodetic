<?php
$pg_connect = pg_connect('host=db
            port=5432
            dbname=webgis-geodetic-ninhthuan
            user=postgres
            password=postgres'
);
if (!$pg_connect) {
    echo "Kết nối thất bại.\n";
}