<?php
    include './database.php';

    // Use 'user_page' instead of 'page' to avoid conflict with admin_dashboard.php
    $user_page = isset($_GET['user_page']) && is_numeric($_GET['user_page']) && $_GET['user_page'] > 0 ? (int)$_GET['user_page'] : 1;
    $results_per_page = 10;
    $start_from = ($user_page - 1) * $results_per_page;

    // Paginated query
    $sql = "SELECT * FROM users LIMIT $start_from, $results_per_page";
    $result = $conn->query($sql);
    if (!$result) {
        die("Main query failed: " . $conn->error);
    }

    // Get total number of records
    $total_query = "SELECT COUNT(*) AS total FROM users";
    $total_result = $conn->query($total_query);
    if (!$total_result) {
        die("Count query failed: " . $conn->error);
    }
    $total_row = $total_result->fetch_assoc();
    $total_pages = ceil($total_row["total"] / $results_per_page);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
    <link rel="stylesheet" href="./src/assets/styles/pagination.css" />

</head>
<body>
    <main>
        <section>
            <h2>User Info</h2>
            <table border="1">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Created At</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td>Encrypted!</td>";
                            echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                ?>
            </table>

            <!-- Pagination Links -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            // Keep page=user-info and pass user_page for pagination
                            $active = $i == $user_page ? "class='active'" : "";
                            echo "<a href='admin_dashboard.php?page=user-info&user_page=$i' $active>$i</a> ";
                        }
                    ?>
                </div>
            <?php else: ?>
                <div class="pagination">
                    <p>Only one page of data.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
