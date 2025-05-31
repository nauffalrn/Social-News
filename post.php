<?php include 'partials/header.php'; ?>
<?php
require 'config/database.php';

// Ensure the post ID is set
if(isset($_GET['id'])) {
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Fetch post details
    $post_query = "SELECT * FROM posts WHERE id = $post_id";
    $post_result = mysqli_query($connection, $post_query);

    if (!$post_result) {
        die("Query Failed: " . mysqli_error($connection));
    }

    $post = mysqli_fetch_assoc($post_result);
    
    // Fetch like count
    $like_count_query = "SELECT COUNT(*) AS total_likes FROM likes WHERE post_id = $post_id";
    $like_count_result = mysqli_query($connection, $like_count_query);
    $like_count = mysqli_fetch_assoc($like_count_result)['total_likes'];
    
    // Check if the current user has liked the post
    $user_id = $_SESSION['user-id'] ?? null;
    $is_liked = false;
    if ($user_id) {
        $like_check_query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
        $like_check_result = mysqli_query($connection, $like_check_query);
        $is_liked = mysqli_num_rows($like_check_result) > 0;
    }
    
    // Fetch comments
    $comments_query = "SELECT comments.*, users.firstname, users.lastname, users.avatar FROM comments 
                      JOIN users ON comments.user_id = users.id 
                      WHERE comments.post_id = $post_id ORDER BY comments.created_at DESC";
    $comments_result = mysqli_query($connection, $comments_query);
} else {
    // Redirect if no post ID is set
    header('Location: ' . ROOT_URL . 'index.php');
    exit();
}
?>

<?php
    // Allow <b> and <strong> tags and convert line breaks to <br> for proper formatting
    $body = nl2br(strip_tags($post['body'], '<b><strong>'));
?>

<section class="singlepost">
    <div class="container singlepost__container">
        
        <!-- Notifikasi Section - Dipindahkan ke dalam container -->
        <?php if(isset($_SESSION['like-success'])): ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['like-success'];
                    unset($_SESSION['like-success']);
                    ?>
                </p>
            </div>
        <?php endif ?>

        <?php if(isset($_SESSION['comment-success'])): ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['comment-success'];
                    unset($_SESSION['comment-success']);
                    ?>
                </p>
            </div>
        <?php endif ?>

        <?php if(isset($_SESSION['comment-error'])): ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['comment-error'];
                    unset($_SESSION['comment-error']);
                    ?> 
                </p>
            </div>
        <?php endif ?>
        
        <h2>
            <?= $post['title'] ?>
        </h2>
        <div class="post__author">
                    <?php
                        //fetch author from users table using author_id of post
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id = '$author_id'";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                    ?>
                    <div class="post__author-avatar">
                        <img src="<?= ROOT_URL ?>images/<?= $author['avatar'] ?>">
                    </div>
                    <div class="post__author-info">
                    <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small>
                            <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                        </small>
                    </div>
                </div>
        <div class="post__thumbnail">
            <img src="<?= ROOT_URL ?>images/<?= $post['thumbnail'] ?>">
        </div>
        <div class="post__body">
            <?= $body ?>
        </div>
        <div class="post__actions">
            <?php if($user_id): ?>
                <form action="<?= ROOT_URL ?>like-post.php" method="post">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <button type="submit" name="like" class="btn">
                        <?= $is_liked ? 'Unlike' : 'Like' ?> (<?= $like_count ?>)
                    </button>
                </form>
            <?php else: ?>
                <p><a href="<?= ROOT_URL ?>signin.php">Signin</a> to like this post. (<?= $like_count ?>)</p>
            <?php endif; ?>
        </div>
        
        <?php if($user_id): ?>
            <section class="comments">
                <form action="<?= ROOT_URL ?>add-comment.php" method="post">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <label for="comment" class="comment__label">Komentar Anda</label>
                    <textarea name="comment" id="comment" rows="5" placeholder="Tulis komentar Anda di sini..." required></textarea>
                    <button type="submit" name="submit" class="btn">Submit Comment</button>
                </form>
            </section>
        <?php else: ?>
            <p><a href="<?= ROOT_URL ?>signin.php">Signin</a> untuk berkomentar pada postingan ini.</p>
        <?php endif; ?>
        
        <section class="comments">
            <h3>Comments (<?= mysqli_num_rows($comments_result) ?>)</h3>
            <?php if(mysqli_num_rows($comments_result) > 0): ?>
                <?php while($comment = mysqli_fetch_assoc($comments_result)): ?>
                    <div class="comment">
                        <div class="comment__author">
                            <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($comment['avatar']) ?>" alt="<?= htmlspecialchars("{$comment['firstname']} {$comment['lastname']}") ?>">
                            <h4><?= htmlspecialchars("{$comment['firstname']} {$comment['lastname']}") ?></h4>
                        </div>
                        <div class="comment__content">
                            <p><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                            <small><?= date("M d, Y - H:i", strtotime($comment['created_at'])) ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </section>
    </div>
</section>
<!--END OF SINGLE POST-->

<?php include 'partials/footer.php'; ?>