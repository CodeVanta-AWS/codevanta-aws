<?php
    include './database.php';

    $audit_page = isset($_GET['audit_page']) && is_numeric($_GET['audit_page']) && $_GET['audit_page'] > 0 ? (int)$_GET['audit_page'] : 1;
    $results_per_page = 10;
    $start_from = ($audit_page - 1) * $results_per_page;

    $sql = "SELECT * FROM audit_logs ORDER BY timestamp DESC LIMIT $start_from, $results_per_page";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $total_query = "SELECT COUNT(*) AS total FROM audit_logs";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_pages = ceil($total_row["total"] / $results_per_page);

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
    <link rel="stylesheet" href="./src/assets/styles/pagination.css" />
</head>
<body>
    <main>
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

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = $i == $audit_page ? "class='active'" : "";
                            echo "<a href='admin_dashboard.php?page=audit_log-info&audit_page=$i' $active>$i</a> ";
                        }
                    ?>
                </div>
            <?php endif; ?>

        </section>
    </main> 
</body>
</html>

