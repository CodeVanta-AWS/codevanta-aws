<?php
    include './database.php';

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
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
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>Encrypted!</td>";
                            echo "<td>" . $row["role"] . "</td>";
                            echo "<td>" . $row["created_at"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                ?>
            </table>
        </section>
    </main>
</body>
</html>
