<!-- views/admin/Dashboard.php -->

<?php
$title = 'Admin Dashboard'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout

// Database connection
$db = dbConnect();

try {
    // Fetch statistics
    $buses_count = $db->query("SELECT COUNT(*) AS total FROM buses")->fetch(PDO::FETCH_ASSOC)['total'];
    $drivers_count = $db->query("SELECT COUNT(*) AS total FROM drivers")->fetch(PDO::FETCH_ASSOC)['total'];
    $terminals_count = $db->query("SELECT COUNT(*) AS total FROM terminals")->fetch(PDO::FETCH_ASSOC)['total'];
    $schedules_count = $db->query("SELECT COUNT(*) AS total FROM schedules")->fetch(PDO::FETCH_ASSOC)['total'];
    $bookings_count = $db->query("SELECT COUNT(*) AS total FROM bookings")->fetch(PDO::FETCH_ASSOC)['total'];
    $total_payments = $db->query("SELECT SUM(amount) AS total FROM payments")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (PDOException $e) {
    die("Query error: " . $e->getMessage());
}
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Main content area -->
                    <header class="text-center mb-4">
                        <h1>Admin Dashboard</h1>
                    </header>

                    <!-- Statistics -->
                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <div class="card shadow p-3">
                                <h3>Total Buses</h3>
                                <p><?= $buses_count; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow p-3">
                                <h3>Total Drivers</h3>
                                <p><?= $drivers_count; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow p-3">
                                <h3>Total Terminals</h3>
                                <p><?= $terminals_count; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <div class="card shadow p-3">
                                <h3>Total Schedules</h3>
                                <p><?= $schedules_count; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow p-3">
                                <h3>Total Bookings</h3>
                                <p><?= $bookings_count; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow p-3">
                                <h3>Total Payments</h3>
                                <p>₱<?= number_format($total_payments, 2); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <canvas id="busesDriversChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="bookingsPaymentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pass PHP data to JavaScript
    const busesCount = <?= $buses_count; ?>;
    const driversCount = <?= $drivers_count; ?>;
    const bookingsCount = <?= $bookings_count; ?>;
    const totalPayments = <?= $total_payments ?? 0; ?>;

    // Buses vs Drivers Chart
    const ctx1 = document.getElementById('busesDriversChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Buses', 'Drivers'],
            datasets: [{
                label: 'Count',
                data: [busesCount, driversCount],
                backgroundColor: ['#4CAF50', '#2196F3']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true,
                    text: 'Buses vs Drivers'
                }
            }
        }
    });

    // Bookings vs Payments Chart
    const ctx2 = document.getElementById('bookingsPaymentsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Bookings', 'Payments (₱)'],
            datasets: [{
                data: [bookingsCount, totalPayments],
                backgroundColor: ['#FF9800', '#8BC34A']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Bookings vs Payments'
                }
            }
        }
    });
</script>