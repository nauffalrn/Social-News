<?php
// filepath: tests/PostManagementTest.php
use PHPUnit\Framework\TestCase;

class PostManagementTest extends TestCase
{
    protected function setUp(): void
    {
        // Initialize session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Mock database connection
        // You can use PHPUnit's mock objects or a library like Mockery
        // Example:
        // $this->connection = $this->createMock(mysqli::class);
    }

    public function testAddPostWithInvalidInput()
    {
        // Simulate POST data with invalid input
        $_POST['title'] = ''; // Missing title
        $_POST['category'] = '1';
        $_POST['body'] = 'This is a test post body.';
        $_FILES['thumbnail'] = ['name' => '', 'tmp_name' => ''];

        // Include the add post logic
        ob_start();
        include __DIR__ . '/../admin/add-post-logic.php';
        ob_end_clean();

        // Assert that the appropriate session message is set
        $this->assertStringContainsString('Invalid form input on add post form', $_SESSION['add-post']);
    }

    public function testDeletePostSuccessfully()
    {
        // Simulate GET data
        $_GET['id'] = '1';

        // Include the delete post logic
        ob_start();
        include __DIR__ . '/../admin/delete-post.php';
        ob_end_clean();

        // Assert that the success message is set
        $this->assertStringContainsString('Post deleted successfully', $_SESSION['delete-post-success']);
    }
}
?>