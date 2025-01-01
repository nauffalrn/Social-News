<?php
session_start();
require 'config/database.php';

// Disable detailed error reporting for production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Ensure the user is an admin
if(!isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $body = mysqli_real_escape_string($connection, $_POST['body']);
    $category_id = intval($_POST['category_id']);
    $author_id = $_SESSION['user-id'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Handle file upload
    if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK){
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = __DIR__ . '/../../images/';
            $dest_path = $uploadFileDir . $newFileName;

            // Debugging Path
            if (!file_exists($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $stmt = $connection->prepare("INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssiii", $title, $body, $newFileName, $category_id, $author_id, $is_featured);

                if($stmt->execute()) {
                    $_SESSION['add-post-success'] = "New post added successfully";
                    header('Location: ../index.php');
                    exit();
                } else {
                    $_SESSION['add-post'] = "Failed to add post: " . $stmt->error;
                }
            } else {
                $_SESSION['add-post'] = "There was an error uploading the file.";
            }
        } else {
            $_SESSION['add-post'] = "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    } else {
        $_SESSION['add-post'] = "No file uploaded or there was an upload error.";
    }

    header('Location: ../add-post.php');
    exit();
}
?>