<?php
    include 'auth_check.php'; 

    include './database.php';

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
        <?php include("./header.php"); ?>

        <?php 
            while ($row = $result->fetch_assoc()) { ?>
            <a href="#">
                <div>
                    <h1><?php echo $row['career_name']; ?></h1>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </a>
        <?php } ?>

        <a href="logout.php">
            <button>Logout</button>
        </a>

        <?php include("./footer.php"); ?>
    </main>
</body>
</html>