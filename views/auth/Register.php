<!-- views/auth/Register.php -->

<?php
$title = 'Register'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout

// Initialize variables to store old values if they exist
$oldValues = [
    'first_name' => $_POST['first_name'] ?? '',
    'last_name' => $_POST['last_name'] ?? '',
    'username' => $_POST['username'] ?? '',
    'email' => $_POST['email'] ?? ''
];
?>

<!-- Content specific to Register Page -->
<div class="container">
    <header class="text-center mt-5" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 30px; border-radius: 8px;">
        <h1>Create Your Account</h1>
        <p>Please fill in the details below to register.</p>
    </header>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card mb-4" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 30px; border-radius: 8px;">
                <div class="card-body">
                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <?php if (isset($successMessage)): ?>
                        <div class="alert alert-success text-center"><?php echo $successMessage; ?></div>
                    <?php endif; ?>

                    <form action="index.php?url=Register" method="POST">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($oldValues['first_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($oldValues['last_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($oldValues['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($oldValues['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="index.php?url=Login" style="color: white;">Already have an account? Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>