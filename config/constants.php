<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_URL', 'socialnews.azurewebsites.net');
define('DB_HOST','socialnews.mysql.database.azure.com');
define('DB_PORT', 3306);
define('DB_USER','socialnews');
define('DB_PASS','Admin123');
define('SSL_MODE','require');
define('DB_NAME','socialnews');

?>