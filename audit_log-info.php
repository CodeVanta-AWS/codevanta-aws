<?php
    include './database.php';

    $sql = "SELECT * FROM audit_logs";
    $result = $conn->query($sql);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
</head>
<body>
    <main>
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

        <section>
            <h2>Audit Log Info</h2>
            <table border="1">
                <tr>
                    <th>User ID</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["action"] . "</td>";
                            echo "<td>" . $row["timestamp"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No records found</td></tr>";
                    }
                ?>
            </table>
        </section>
    </main> 
</body>
</html>

