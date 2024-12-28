<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_URL', 'http://localhost:3000/');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','nauffalaja');
define('DB_NAME','socialnews');

?>