<!-- views/LandingPage.php -->

<?php
$title = 'Welcome to the Bus Transportation Management System'; // Set the page title
include('main.php'); // Include the main layout
?>

<!-- Content specific to Landing Page -->
<div class="container">
    <header class="text-center mt-5" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 30px; border-radius: 8px;">
        <h1>Welcome to Our Bus Transportation Management System</h1>
        <p>Your one-stop solution for all your bus travel needs!</p>
        <a href="index.php?url=BookTicket" class="btn btn-light btn-lg">Book a Ticket</a>
    </header>

    <section class="mt-5" style="background-color: rgba(0, 123, 255, 0.8); padding: 30px; border-radius: 8px;">
        <h2 style="color: white;">Why Choose Us?</h2>
        <ul class="list-group">
            <li class="list-group-item" style="background-color: transparent; color: white; border: 1px solid white;">Reliable and Comfortable Buses</li>
            <li class="list-group-item" style="background-color: transparent; color: white; border: 1px solid white;">Real-time Tracking of Buses</li>
            <li class="list-group-item" style="background-color: transparent; color: white; border: 1px solid white;">Easy Online Booking System</li>
            <li class="list-group-item" style="background-color: transparent; color: white; border: 1px solid white;">Affordable Prices and Discounts</li>
            <li class="list-group-item" style="background-color: transparent; color: white; border: 1px solid white;">24/7 Customer Support</li>
        </ul>
    </section>

    <section class="mt-5" style="background-color: rgba(0, 123, 255, 0.8); padding: 30px; border-radius: 8px;">
        <h2 style="color: white;">Explore Our Services</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4" style="border: 1px solid white; border-radius: 8px; background-color: transparent;">
                    <div class="card-body">
                        <h3 style="color: white;">View Schedules</h3>
                        <p style="color: white;">Check out our bus schedules to find the best travel times.</p>
                        <a href="index.php?url=ViewSchedules" class="btn btn-light">View Schedules</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4" style="border: 1px solid white; border-radius: 8px; background-color: transparent;">
                    <div class="card-body">
                        <h3 style="color: white;">User Accounts</h3>
                        <p style="color: white;">Manage your bookings and personal information.</p>
                        <a href="index.php?url=UserAccount" class="btn btn-light">My Account</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4" style="border: 1px solid white; border-radius: 8px; background-color: transparent;">
                    <div class="card-body">
                        <h3 style="color: white;">Contact Us</h3>
                        <p style="color: white;">Have questions? Reach out to our customer service.</p>
                        <a href="index.php?url=Contact" class="btn btn-light">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center mt-5" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 20px; border-radius: 8px;">
        <p>&copy; 2024 Bus Transportation Management System | All rights reserved.</p>
    </footer>
</div>