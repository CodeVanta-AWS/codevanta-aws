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
    <link rel="stylesheet" href="./src/assets/styles/careers.css" />
</head>
<body> 

    <?php include("./header.php"); ?>

    <main>

        <section class="hero hero-careers">
            <div>
                <h1 class="ms-b lg-80">Create With Purpose. Grow With Passion.</h1>
                <hr class="w-50">
                <p class="ms-t md-50">Every project at CodeVanta is a chance to learn, innovate, and lead. Whether you're starting out or stepping up, we’ll help you thrive in your career.</p>
            </div>
        </section>

        <section class="career-section container">
            <div class="career-container">
                <?php 
                    while ($row = $result->fetch_assoc()) { ?>
                    <div>
                        <div>
                            <h2 class="orange ms-b bold"><?php echo $row['career_name']; ?></h2>
                            
                        </div>
                        <div>
                            <p><?php echo $row['description']; ?></p>
                            <a href="contact.php" class="white"><button class="button-white-outline ms-t">Apply Now</button></a>
                        </div>
                    </div>

                <?php } ?>
            </div>

        </section>


    </main>

    <?php include("./footer.php"); ?>
</body>
</html>
