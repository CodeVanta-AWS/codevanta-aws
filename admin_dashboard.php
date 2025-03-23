<?php
    // FOR VPN VALIDATION
    $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

    if (substr($user_ip, 0, 4) !== "100.") {
        header("HTTP/1.1 403 Forbidden");
        exit("Access Denied - This page is only accessible via the VPN.\nYour detected IP: " . $user_ip);
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
