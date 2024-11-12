<?php
// controllers/AuthController.php

class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }

    public function login()
    {

        // Check if the user is already logged in
        if (isset($_SESSION['user_id'])) {
            // If session is active, redirect to dashboard
            header("Location: index.php?url=admin/Dashboard");
            exit;
        }

        // Process the login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validate user credentials
            if ($this->authenticate($username, $password)) {
                header("Location: index.php?url=LandingPage");
                exit;
            } else {
                $errorMessage = "Invalid credentials!";
            }
        }

        require __DIR__ . '/../views/auth/Login.php'; // Load the login form view
    }


    private function authenticate($username, $password)
    {
        try {
            // Prepare the SQL statement
            $query = "SELECT id, username, password, first_name, last_name, position_id FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // Fetch the user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password if the user exists
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id']; // Store the user ID in the session
                $_SESSION['position_id'] = $user['position_id']; // Store the position_id in the session
                $_SESSION['username'] = $user['username']; // Store the username in the session
                $_SESSION['first_name'] = $user['first_name']; // Store the first_name in the session
                $_SESSION['last_name'] = $user['last_name']; // Store the last_name in the session

                // Update last_login time
                $updateQuery = "UPDATE users SET last_login = NOW() WHERE id = :id";
                $updateStmt = $this->db->prepare($updateQuery);
                $updateStmt->bindParam(':id', $user['id']);
                $updateStmt->execute();

                return true; // Authenticated
            } else {
                return false; // Authentication failed
            }
        } catch (PDOException $e) {
            // Log or handle the database error as needed
            logDebug("Database error: " . $e->getMessage());
            return false;
        }
    }


    public function register()
    {
        // Assume form submission method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $errorMessage = '';

            // Basic validation
            if (empty($username) || empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
                $errorMessage = "All fields are required!";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = "Invalid email format!";
            } elseif ($password !== $confirmPassword) {
                $errorMessage = "Passwords do not match!";
            } else {
                // Check if username already exists
                if ($this->usernameExists($username)) {
                    $errorMessage = "Username already taken!";
                } elseif ($this->emailExists($email)) {
                    // Check if email already exists
                    $errorMessage = "Email already taken!";
                } else {
                    // Securely save the user to the database (make sure to hash the password)
                    if ($this->saveUser($username, $email, password_hash($password, PASSWORD_DEFAULT), $firstName, $lastName)) {
                        header("Location: index.php?url=Login");
                        exit;
                    } else {
                        $errorMessage = "Registration failed. Please try again.";
                    }
                }
            }
        }

        require __DIR__ . '/../views/auth/Register.php'; // Load the registration form view
    }

    // Example of a method to save user data
    private function saveUser($username, $email, $hashedPassword, $firstName, $lastName)
    {
        // Use prepared statements to insert user into the database
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, first_name, last_name, position_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, 2, NOW(), NOW())");
        return $stmt->execute([$username, $email, $hashedPassword, $firstName, $lastName]);
    }

    private function usernameExists($username)
    {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function emailExists($email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }


    public function logout()
    {
        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: index.php?url=Login");
        exit;
    }
}
