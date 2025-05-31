<?php
require_once 'config/database.php';
require_once 'config/constants.php';

if(isset($_POST['like'])) {
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['user-id'] ?? null;

    if($user_id) {
        // Check if the user has already liked the post
        $check_query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
        $check_result = mysqli_query($connection, $check_query);

        if(mysqli_num_rows($check_result) > 0) {
            // Unlike the post
            $delete_query = "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id";
            mysqli_query($connection, $delete_query);
            $_SESSION['like-success'] = "Berita berhasil di-unlike! 👎";
        } else {
            // Like the post
            $insert_query = "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)";
            mysqli_query($connection, $insert_query);
            $_SESSION['like-success'] = "Berita berhasil di-like! 👍";
        }

        // Redirect back to the post page
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        exit();
    } else {
        $_SESSION['signin'] = 'Please signin to like posts';
        header('Location: ' . ROOT_URL . 'signin.php');
        exit();
    }
} else {
    header('Location: ' . ROOT_URL . 'index.php');
    exit();
}
?>