<!-- views/passenger/ViewBookings.php -->

<?php
$title = 'View Bookings'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        

        <!-- Main content area -->
        <div class=" main-content p-4">
            <h1 style="color: white;" class="d-flex justify-content-between align-items-center">
                View Bookings
            </h1>


            <div class="card">
                <div class="card-body">
                    <!-- Display the presentBookings in a table -->
                    <table id="bookingsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Departure</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Quantity</th>
                                <th>Fare</th>
                                <th>Reference Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($presentBookings as $booking): ?>
                                <tr>
                                    <td><?= htmlspecialchars($booking['departure']) ?></td>
                                    <td><?= htmlspecialchars($booking['destination']) ?></td>
                                    <td><?= htmlspecialchars($booking['date']) ?></td>
                                    <td><?= htmlspecialchars($booking['time']) ?></td>
                                    <td><?= htmlspecialchars($booking['quantity']) ?></td>
                                    <td><?= htmlspecialchars($booking['fare']) ?></td>
                                    <td><?= htmlspecialchars($booking['reference_number']) ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize the DataTable
        $('#bookingsTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>