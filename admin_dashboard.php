<?php
    // // FOR VPN VALIDATION
    function isValidAdminIP($ip, $allowedOctets) {
        $firstOctet = explode('.', $ip)[0]; // Get the first octet of user's IP
        return in_array($firstOctet, $allowedOctets);
    }
    
    $adminIP = $_SERVER['REMOTE_ADDR']; // Get the user's IP
    $allowedOctets = [51, 94];
    
    if (isValidAdminIP($adminIP, $allowedOctets) == false) {
        http_response_code(403);
        die("Access denied: You must be connected to the VPN. Your IP: " . $adminIP);
    }
    // // END OF VPN VALIDATION CODE

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
