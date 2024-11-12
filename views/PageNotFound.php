<!-- views/PageNotFound.php -->

<?php
$title = 'Page Not Found'; // Set the page title
include('main.php'); // Include the main layout
?>

<!-- Content specific to Page Not Found -->
<div class="container text-center my-5">
    <section class="mt-5" style="background-color: rgba(0, 123, 255, 0.8); padding: 30px; border-radius: 8px;">
        <h1 class="display-4" style="color: white;">404 - Page Not Found</h1>
        <p class="lead" style="color: white;">Oops! The page you're looking for doesn't exist.</p>
        <p style="color: white;">It might have been moved, deleted, or the URL may be incorrect.</p>
        <a href="index.php?url=LandingPage" class="btn btn-light mt-3">Go Back to Homepage</a>
    </section>
</div>