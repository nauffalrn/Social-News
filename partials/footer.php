<footer>
    <div class="footer__socials">
        <a href="https://www.youtube.com" target="_blank"><i class="uil uil-youtube"></i></a>
        <a href="https://www.linkedin.com" target="_blank"><i class="uil uil-linkedin"></i></a>
        <a href="https://www.instagram.com" target="_blank"><i class="uil uil-instagram-alt"></i></a>
        <a href="https://www.facebook.com" target="_blank"><i class="uil uil-facebook"></i></a>
        <a href="https://www.x.com" target="_blank"><i class="uil uil-twitter"></i></a>
    </div>
    <div class="container footer__container">
        <article>
            <h4>Categories</h4>
            <ul>
                <?php
                    // Ensure the database connection is available
                    if (!isset($connection)) {
                        require __DIR__ . '/../config/database.php';
                    }

                    // Fetch categories from the database
                    $fetch_categories_query = "SELECT id, title FROM categories";
                    $categories_result = mysqli_query($connection, $fetch_categories_query);

                    if ($categories_result && mysqli_num_rows($categories_result) > 0) :
                        while ($category = mysqli_fetch_assoc($categories_result)) :
                ?>
                    <!-- Updated Category Link -->
                    <li>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>">
                            <?= htmlspecialchars($category['title']) ?>
                        </a>
                    </li>
                <?php
                        endwhile;
                    else :
                ?>
                    <li><a href="#">No Categories Found</a></li>
                <?php endif; ?>
            </ul>
        </article>
        <article>
            <h4>Support</h4>
            <ul>
                <li><a href="">Online Support</a></li>
                <li><a href="">Call Numbers</a></li>
                <li><a href="">Emails</a></li>
                <li><a href="">Social Support</a></li>
                <li><a href="">Location</a></li>
            </ul>
        </article>
        <article>
            <h4>Permalinks</h4>
            <ul>
                <li><a href="<?= ROOT_URL ?>index.php">Home</a></li>
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
            </ul>
        </article>
    </div>
    <div class="footer__copyright">
        <small>&copy; <?php echo date("Y"); ?> Social News</small>
    </div>
</footer>

<script src="<?= ROOT_URL ?>js/main.js"></script>
</body>
</html>