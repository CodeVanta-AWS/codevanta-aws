<?php
    include '../../database.php';

    $sql = "SELECT * FROM careers";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers — Code Vanta</title>
</head>
<body>
    <main>
        <h2>Career Opportunities</h2>
        <table border="1">  
            <tr>
                <th>ID</th>
                <th>Career Name</th>
                <th>Description</th>
                <th>Created At</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['career_name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "</tr>";
                }
            } 
            else {
                echo "<tr><td colspan='4'>No careers found</td></tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
