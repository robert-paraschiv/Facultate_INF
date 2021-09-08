<?php
/* Detaliile de conectare la baza de date */
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_concurs');
define('DB_USER', 'concursuser');
define('DB_PASS', 'changeit');
/*Se reporteaza toate erorrile cu exceptia celor de tip NOTICE si DEPRECATED */
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
?>