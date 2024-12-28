<?php
require_once 'config/database.php';
require_once 'config/constants.php';

if(isset($_POST['submit'])) {
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['user-id'] ?? null;
    $comment_text = trim($_POST['comment']);

    if($user_id) {
        if($comment_text) {
            $comment_text = mysqli_real_escape_string($connection, $comment_text);
            $insert_query = "INSERT INTO comments (user_id, post_id, comment_text) VALUES ($user_id, $post_id, '$comment_text')";
            mysqli_query($connection, $insert_query);

            // Redirect back to the post page with post id
            header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        } else {
            $_SESSION['add-comment'] = "Please enter a comment.";
            header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
        }
    } else {
        $_SESSION['signin'] = 'Please signin to comment.';
        header('Location: ' . ROOT_URL . 'signin.php');
    }
} else {
    header('Location: ' . ROOT_URL . 'index.php');
}
die();
?>