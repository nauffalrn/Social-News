<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/test_db.php';
require '../partials/header.php';

//check login status
if (!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}