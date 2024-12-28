<?php
require_once __DIR__ . '/../../config/constants.php';

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(!$connection){
    die("Connection Failed: " . mysqli_connect_error());
}
?>