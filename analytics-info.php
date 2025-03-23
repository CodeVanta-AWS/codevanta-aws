<?php
    include './database.php';

    $sql = "SELECT DISTINCT user_id, ip_address, user_agent, os, browser, location, processor_details FROM audit_logs";
    $result = $conn->query($sql);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Info — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
</head>
<body>
    
    <main>
        <section>
            <h2>Analytics Info</h2>
            <table border="1">
                <tr>
                    <th>User ID</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>OS</th>
                    <th>Browser</th>
                    <th>Location</th>
                    <th>Processor Details</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["ip_address"] . "</td>";
                            echo "<td>" . $row["user_agent"] . "</td>";
                            echo "<td>" . $row["os"] . "</td>";
                            echo "<td>" . $row["browser"] . "</td>";
                            echo "<td>" . $row["location"] . "</td>";
                            echo "<td>" . $row["processor_details"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                ?>
            </table>
        </section>
    </main>
</body>
</html>
