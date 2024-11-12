<!-- views/SideBar.php -->
<?php
$userName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest'; // Fetch the user name from the session
?>

<nav class="col-sm-4 col-md-3 col-lg-2 sidebar d-md-block" style="background-color: rgba(0, 123, 255, 0.8); color: white; padding: 20px; height: 100vh;">
    <div class="text-center mb-4">
        <div class="profile-icon" style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto;">
            <img src="assets/images/User_icon_2.svg.png" alt="User Icon" style="width: 100%; height: auto; border-radius: 50%;">
        </div>
        <h5 class="mt-2" style="margin: 0;"><?php echo htmlspecialchars($userName); ?></h5> <!-- User name -->
    </div>

    <div class="list-group">
        <?php foreach ($navigations as $item): ?>
            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="sidebar-link"><?php echo htmlspecialchars($item['name']); ?></a>
        <?php endforeach; ?>
    </div>
</nav>

<style>
    .sidebar-link {
        display: block;
        /* Make the entire link area clickable */
        padding: 10px 15px;
        /* Add padding for better clickability */
        color: white;
        /* Link text color */
        text-decoration: none;
        /* Remove underline */
        border-radius: 5px;
        /* Rounded corners */
        transition: background-color 0.3s;
        /* Smooth transition for hover effect */
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        /* Lighten background on hover */
        color: white;
        /* Ensure text remains white on hover */
    }
</style>