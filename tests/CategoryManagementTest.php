<?php
// filepath: tests/CategoryManagementTest.php
use PHPUnit\Framework\TestCase;

class CategoryManagementTest extends TestCase
{
    public function testAddCategoryWithValidData()
    {
        // Simulate form data
        $_POST['title'] = 'Technology';
        $_POST['description'] = 'All about tech.';
        $_POST['submit'] = 'submit';

        // Include the add category logic
        ob_start();
        include __DIR__ . '/../admin/add-category-logic.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Category added successfully', $_SESSION['add-category-success']);
    }

    public function testEditCategoryWithInvalidData()
    {
        // Simulate form data
        $_POST['id'] = '2';
        $_POST['title'] = '';
        $_POST['description'] = '';

        // Include the edit category logic
        ob_start();
        include __DIR__ . '/../admin/edit-category-logic.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid form input on edit category form', $_SESSION['edit-category']);
    }
}
?>