<?php
require_once __DIR__ . '/constants.php';

// Connect to the database
$connection = mysqli_init();
$connection->ssl_set(NULL, NULL,  __DIR__ . '/DigiCertGlobalRootCA.crt.pem', NULL, NULL);
$connection->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT, NULL, MYSQLI_CLIENT_SSL);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>