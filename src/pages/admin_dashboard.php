<?php
    include("../components/common/header.php");

    // Set default page to 'user-info' if no page is selected
    $page = isset($_GET['page']) ? $_GET['page'] : 'user-info';
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
            </div>

            <div class="content">
                <?php
                    include("$page.php");
                ?>
            </div>
        </section>
    </main>

    <?php include("../components/common/footer.php"); ?>

</body>
</html>