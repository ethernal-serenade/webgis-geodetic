<?php
declare(strict_types=1);
$pg_connect = pg_connect('host=localhost
            port=5432
            dbname=webgis-geodetic
            user=postgres
            password=0815985051'
);
/* $pg_connect = pg_connect('host=db.local
            port=5432
            dbname=webgis-geodetic
            user=postgres
            password=^^lam2lam#'
); */
if (!$pg_connect) {
    echo "Kết nối thất bại.\n";
}