<?php
    include 'auth_check.php'; // Restricts access if not logged in

    include '../../database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['message']);
        echo $stmt->execute() ? "<p>Inquiry submitted!</p>" : "<p>Error: " . $stmt->error . "</p>";
        $stmt->close();
    }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>
<body>
<?php include("../components/common/header.php"); ?>
    <main>
        <section>
            <h2>Contact Us</h2>
            <form action="" method="POST">
                <label>Name: <input type="text" name="name" required></label>
                <label>Email: <input type="email" name="email" required></label>
                <label>Message: <textarea name="message" required></textarea></label>
                <button type="submit">Submit</button>
            </form>
        </section>
        <a href="logout.php">
            <button>Logout</button>
        </a>
    </main>

    <?php include("../components/common/footer.php"); ?>
</body>
</html>