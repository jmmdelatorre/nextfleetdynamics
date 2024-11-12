<!-- views/passenger/BookingQRCode.php -->

<?php
$title = 'Booking QR Code'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        

        <!-- Main content area -->
        <div class=" main-content">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <header class="text-center">
                            <h1>Booking Confirmation</h1>
                            <?php if (!empty($qrCodeDataUrl)): ?>
                                <p class="mt-3 text-success">Congratulations! You have successfully booked your ticket.</p>
                                <p>Please present the QR code below to the bus operator when boarding.</p>

                                <div class="text-center mt-4">
                                    <img src="<?php echo $qrCodeDataUrl; ?>" alt="Booking QR Code" class="img-fluid" />
                                </div>

                                <p class="mt-4">Thank you for choosing our service. Have a safe and pleasant journey!</p>
                            <?php else: ?>
                                <p class="text-danger">No QR code available. Please contact customer support if you need assistance.</p>
                            <?php endif; ?>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>