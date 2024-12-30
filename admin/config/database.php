<?php
require_once __DIR__ . '/../../config/constants.php';

// Connect to the database
$connection = mysqli_init();
$connection->ssl_set(NULL, NULL, '/../DigiCertGlobalRootCA.crt.pem', NULL, NULL);
$connection->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT, NULL, MYSQLI_CLIENT_SSL);

if(!$connection){
    die("Connection Failed: " . mysqli_connect_error());
}
?>