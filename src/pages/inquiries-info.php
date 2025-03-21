<?php
    include '../../database.php';

    $sql = "SELECT * FROM inquiries";
    $result = $conn->query($sql);
?> 

<main>
    <section>
        <h2>Audit Log Info</h2>
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
    </section>
</main> 