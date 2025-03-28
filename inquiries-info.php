<?php
    include './database.php';

    $inquiry_page = isset($_GET['inquiry_page']) && is_numeric($_GET['inquiry_page']) && $_GET['inquiry_page'] > 0 ? (int)$_GET['inquiry_page'] : 1;
    $results_per_page = 10;
    $start_from = ($inquiry_page - 1) * $results_per_page;

    $sql = "SELECT * FROM inquiries ORDER BY created_at DESC LIMIT $start_from, $results_per_page";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $total_query = "SELECT COUNT(*) AS total FROM inquiries";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_pages = ceil($total_row["total"] / $results_per_page);

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
    <link rel="stylesheet" href="./src/assets/styles/pagination.css" />
    
</head>
<body>
    
    <main>
        <section>
            <h2>Inquiries Info</h2>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["message"] . "</td>";
                            echo "<td>" . $row["created_at"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                ?>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = $i == $inquiry_page ? "class='active'" : "";
                            echo "<a href='admin_dashboard.php?page=inquiries-info&inquiry_page=$i' $active>$i</a> ";
                        }
                    ?>
                </div>
            <?php endif; ?>

        </section>
    </main> 
</body>
</html>
