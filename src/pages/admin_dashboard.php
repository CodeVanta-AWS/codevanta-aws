<?php
    include("../components/common/header.php");

    $page = isset($_GET['page']) ? $_GET['page'] : 'user-info';

    include 'auth_check.php';

    // Ensure only admin can access
    if ($_SESSION['role'] !== 'admin') {
        header("Location: about.php"); // Redirect non-admins
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
</head>
<body>
    <main>
        <section>
            <h2>Admin Dashboard</h2>
            
            <div class="button-container">
                <a href="admin_dashboard.php?page=user-info"><button>Users</button></a>
                <a href="admin_dashboard.php?page=career-info"><button>Careers</button></a>
                <a href="admin_dashboard.php?page=audit_log-info"><button>Audit Log</button></a>
                <a href="admin_dashboard.php?page=analytics-info"><button>Analytics</button></a>
                <a href="admin_dashboard.php?page=inquiries-info"><button>Inquiries</button></a>
            </div>

            <div class="content">
                <?php
                    include("$page.php");
                ?>
            </div>
        </section>
        <a href="logout.php">
            <button>Logout</button>
        </a>
    </main>

    <?php include("../components/common/footer.php"); ?>

</body>
</html>