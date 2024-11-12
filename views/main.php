<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Default Title'; ?></title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="../public/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/style.css">

    <!-- Include DataTables CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


    <style>
        /* Remove body margin and padding */
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <header style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 10px 0;">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <div class="container">
                <a class="navbar-brand" href="index.php?url=LandingPage" style="color: white;">NexFleet Dynamics</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?url=LandingPage" style="color: white;">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?url=UserAccount" style="color: white;">My Account</a>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php foreach ($navigations as $item): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>" style="color: white;"><?php echo htmlspecialchars($item['name']); ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger ms-2" href="index.php?url=Logout" style="color: white;">Logout</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?php
        // Include the content of the specific page
        if (isset($content)) {
            include($content);
        }
        ?>
    </main>

    <!-- Include jQuery, Bootstrap JS, and DataTables JS -->
    <script src="../public/js/jquery/dist/jquery.min.js"></script>
    <script src="../public/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include DataTables and jQuery from CDN -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom script file -->
    <script src="../public/js/script.js"></script>
</body>

</html>