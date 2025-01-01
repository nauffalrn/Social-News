<?php
session_start();
require_once __DIR__ . '/../../config/database.php';


// Enable detailed error reporting (for development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure the user is an admin
if(!isset($_SESSION['user_is_admin'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve and sanitize form data
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $body = mysqli_real_escape_string($connection, $_POST['body']);
    $category_id = intval($_POST['category_id']);
    $author_id = $_SESSION['user-id'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Handle file upload
    if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK){
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileSize = $_FILES['thumbnail']['size'];
        $fileType = $_FILES['thumbnail']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Check allowed file extensions
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory in which the uploaded file will be moved
            $uploadFileDir = '../../images/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Insert post into database using prepared statements
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

    // Redirect back to add-post page if there is an error
    header('Location: ../add-post.php');
    exit();
}
?>