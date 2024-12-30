<?php
// filepath: tests/UserAuthTest.php
use PHPUnit\Framework\TestCase;

class UserAuthTest extends TestCase
{
    public function testUserRegistrationWithValidData()
    {
        // Simulate form data
        $_POST['firstname'] = 'John';
        $_POST['lastname'] = 'Doe';
        $_POST['username'] = 'johndoe';
        $_POST['email'] = 'john@example.com';
        $_POST['createpassword'] = 'Password123';
        $_POST['confirmpassword'] = 'Password123';
        $_POST['userrole'] = '0';

        // Include the registration logic
        ob_start();
        include __DIR__ . '/../admin/add-user-logic.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('User added successfully', $_SESSION['add-user-success']);
    }

    public function testUserLoginWithInvalidCredentials()
    {
        // Simulate form data
        $_POST['username'] = 'invaliduser';
        $_POST['password'] = 'wrongpassword';

        // Include the login logic
        ob_start();
        include __DIR__ . '/../signin-logic.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid Credentials', $_SESSION['signin']);
    }
}
?>