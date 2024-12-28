<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require '../partials/header.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user-id']) || !isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
?>