<!-- views/CheckValidity.php -->

<?php
$title = 'Check QR Code Validity'; // Set the page title
include('main.php'); // Include the main layout
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h1>QR Code Validity Check</h1>

            <?php if ($checkValidity): ?>
                <div class="alert alert-success mt-4" role="alert">
                    <h4 class="alert-heading">Booking Found!</h4>
                    <p>Congratulations! The booking reference <strong><?php echo htmlspecialchars($_GET['reference']); ?></strong> is valid.</p>
                    <hr>
                    <p>Details:</p>
                    <ul class="list-unstyled">
                        <li><strong>Name:</strong> <?php echo htmlspecialchars($checkValidity['user_name']); ?></li>
                        <li><strong>Departure:</strong> <?php echo htmlspecialchars($checkValidity['departure']); ?></li>
                        <li><strong>Destination:</strong> <?php echo htmlspecialchars($checkValidity['destination']); ?></li>
                        <li><strong>Date:</strong> <?php echo htmlspecialchars($checkValidity['date']); ?></li>
                        <li><strong>Time:</strong> <?php echo htmlspecialchars($checkValidity['time']); ?></li>
                        <li><strong>Quantity:</strong> <?php echo htmlspecialchars($checkValidity['quantity']); ?></li>
                        <li><strong>Total Fare:</strong> <?php echo htmlspecialchars($checkValidity['fare']); ?></li>
                    </ul>
                    <p class="mb-0">Please present this QR code to the bus operator upon boarding.</p>
                </div>
            <?php else: ?>
                <div class="alert alert-danger mt-4" role="alert">
                    <h4 class="alert-heading">Invalid Booking</h4>
                    <p>The booking reference <strong><?php echo htmlspecialchars($_GET['reference']); ?></strong> is not valid. Please double-check the reference number and try again.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>