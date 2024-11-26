<!-- views/passenger/Dashboard.php -->

<?php
$title = 'Passenger Dashboard'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout

// Database connection
$db = dbConnect();

// Fetch passenger data
$user_id = $_SESSION['user_id']; // Assuming passenger ID is stored in the session

// Fetch total bookings and payments
$total_bookings = $db->query("SELECT COUNT(*) AS total FROM bookings WHERE user_id = $user_id")->fetch(PDO::FETCH_ASSOC)['total'];
$total_payments = $db->prepare("
    SELECT SUM(p.amount) AS total
    FROM payments p
    INNER JOIN bookings b ON p.booking_id = b.id
    WHERE b.user_id = :user_id
");
$total_payments->execute(['user_id' => $user_id]);
$total_payments = $total_payments->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Fetch past bookings
$past_bookings = $db->prepare("
    SELECT b.id, s.date, s.time 
    FROM bookings b
    INNER JOIN schedules s ON b.schedule_id = s.id
    WHERE b.user_id = :user_id AND s.date < CURDATE()
    ORDER BY s.date DESC
");
$past_bookings->execute(['user_id' => $user_id]);

// Fetch future bookings
$future_bookings = $db->prepare("
    SELECT b.id, s.date, s.time 
    FROM bookings b
    INNER JOIN schedules s ON b.schedule_id = s.id
    WHERE b.user_id = :user_id AND s.date >= CURDATE()
    ORDER BY s.date ASC
");
$future_bookings->execute(['user_id' => $user_id]);
?>

<div class="container-fluid">
    <div class="row">
        <!-- Main content area -->
        <div class="main-content">
            <div class="card shadow mt-5 p-4">
                <header class="text-center mb-4">
                    <h1>Passenger Dashboard</h1>
                </header>

                <!-- Summary Section -->
                <div class="row text-center mt-4">
                    <div class="col-md-6">
                        <div class="card shadow p-3">
                            <h3>Total Bookings</h3>
                            <p><?= $total_bookings; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow p-3">
                            <h3>Total Payments</h3>
                            <p>₱<?= number_format($total_payments, 2); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Past Bookings -->
                <div class="mt-5">
                    <h3>Past Bookings</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($past_bookings as $booking): ?>
                                    <tr>
                                        <td><?= $booking['id']; ?></td>
                                        <td><?= date('F d, Y', strtotime($booking['date'])); ?></td>
                                        <td><?= date('h:i A', strtotime($booking['time'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Future Bookings -->
                <div class="mt-5">
                    <h3>Future Bookings</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($future_bookings as $booking): ?>
                                    <tr>
                                        <td><?= $booking['id']; ?></td>
                                        <td><?= date('F d, Y', strtotime($booking['date'])); ?></td>
                                        <td><?= date('h:i A', strtotime($booking['time'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row mt-5">
                    <div class="col-md-6">
                        <h4>Bookings Trend</h4>
                        <canvas id="bookingsTrendChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h4>Payments Breakdown</h4>
                        <canvas id="paymentsBreakdownChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart 1: Bookings Trend (Past vs Future)
    const bookingsTrendCtx = document.getElementById('bookingsTrendChart').getContext('2d');
    const bookingsTrendChart = new Chart(bookingsTrendCtx, {
        type: 'bar',
        data: {
            labels: ['Past Bookings', 'Future Bookings'],
            datasets: [{
                label: 'Number of Bookings',
                data: [<?= $past_bookings->rowCount(); ?>, <?= $future_bookings->rowCount(); ?>],
                backgroundColor: ['#007bff', '#28a745']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart 2: Payments Breakdown
    const paymentsBreakdownCtx = document.getElementById('paymentsBreakdownChart').getContext('2d');
    const paymentsBreakdownChart = new Chart(paymentsBreakdownCtx, {
        type: 'pie',
        data: {
            labels: ['Total Payments'],
            datasets: [{
                label: 'Payments',
                data: [<?= $total_payments; ?>],
                backgroundColor: ['#ffc107']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>