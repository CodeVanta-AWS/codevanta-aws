<?php
    include './database.php';

    $sql = "SELECT * FROM audit_logs";
    $result = $conn->query($sql);
?> 

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
    </section>
</main> 