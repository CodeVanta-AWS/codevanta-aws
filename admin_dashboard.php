<?php
    // FOR VPN VALIDATION
    // Get the user's IP address
    $admin_ip = $_SERVER['REMOTE_ADDR'];

    // Define the allowed IP range (Example: 10.8.0.0 - 10.8.0.255)
    $allowed_subnet = '10.8.0.0';
    $subnet_mask = 24; // Adjust this based on your VPN subnet

    // Function to check if IP is within the subnet
    function ip_in_range($ip, $subnet, $mask) {
        $ip_dec = ip2long($ip);
        $subnet_dec = ip2long($subnet);
        $mask_dec = -1 << (32 - $mask);
        return ($ip_dec & $mask_dec) === ($subnet_dec & $mask_dec);
    }

    // If IP is not in the allowed range, deny access
    if (!ip_in_range($admin_ip, $allowed_subnet, $subnet_mask)) {
        http_response_code(403);
        die("Access denied: You must be connected to the VPN. Your IP: " . $admin_ip);
    }
    // END OF VPN VALIDATION CODE, DELETE IF NOT WORKING

    $page = isset($_GET['page']) ? $_GET['page'] : 'user-info';

    include 'auth_check.php';

    if ($_SESSION['role'] !== 'admin') {
        header("Location: about.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
    <link rel="stylesheet" href="./src/assets/styles/dashboard.css" />
</head>
<body>
    <?php include("./header.php"); ?> 
    <main class="dashboard__container">
        <section class="admin-section">
            <div class="admin-header">
                <h3 class="white">WELCOME BACK, <span>ADMIN!</span></h3>
                        <a href="logout.php">
                    <button class="button button-orange-outline">Logout</button>
                </a>
            </div>
            
            <div class="button-container ml-b">
                <a href="admin_dashboard.php?page=user-info"><button class="button-admin">Users</button></a>
                <a href="admin_dashboard.php?page=career-info"><button class="button-admin">Careers</button></a>
                <a href="admin_dashboard.php?page=audit_log-info"><button class="button-admin">Audit Log</button></a>
                <a href="analytics-info.php"><button class="button-admin">Analytics</button></a>
                <a href="admin_dashboard.php?page=inquiries-info"><button class="button-admin">Inquiries</button></a>
            </div>

            <div class="content">
                <?php
                    include("$page.php");
                ?>
            </div>
        </section>

    </main>

</body>
</html>
