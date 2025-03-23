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
    <title>Careers — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
</head>
<body> 

    <?php include("./header.php"); ?>

    <main>
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
    </main>

    <?php include("./footer.php"); ?>
</body>
</html>
