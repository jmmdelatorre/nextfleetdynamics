<!-- views/auth/Login.php -->

<?php
$title = 'Login'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<!-- Content specific to Login Page -->
<div class="container">
    <header class="text-center mt-5" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 30px; border-radius: 8px;">
        <h1>Login to Your Account</h1>
        <p>Please enter your credentials to continue.</p>
    </header>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card mb-4" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 30px; border-radius: 8px;">
                <div class="card-body">
                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>

                    <form action="index.php?url=Login" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="index.php?url=Register" style="color: white;">Don't have an account? Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>