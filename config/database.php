<?php
require_once __DIR__ . '/constants.php';

// Parse host dan port
$host_parts = explode(':', DB_HOST);
$host = $host_parts[0];
$port = isset($host_parts[1]) ? (int)$host_parts[1] : 3306;

// Connect dengan port spesifik
$connection = mysqli_connect($host, DB_USER, DB_PASS, DB_NAME, $port);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset untuk menghindari masalah encoding
mysqli_set_charset($connection, "utf8");
?>