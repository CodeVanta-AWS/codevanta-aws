<?php
session_start();
include("./database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "<span>Username already exists!</span>";
    } 
    else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $message = "<span>Registration successful! You can now <a href='login.php' class='orange'>login</a>.</span>";
        } 
        else {
            $message = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register — CodeVanta</title>
        <link rel="stylesheet" href="./src/assets/styles/global.css" />
    </head>
    <body>

        <section class="hero hero-register">
            <div class="hero-contact-left">
                <h1 class="ms-b lg-80">Step Into CodeVanta.<br>One Click Away</h1>
                <hr class="w-50">
                <p class="ms-t md-50">Creating an account is your first step toward building with purpose. Collaborate, grow, and explore endless tech possibilities.</p>
            </div>
            <div class="hero-register-right w-50 mxl-t">
                <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                <form method="POST">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                    <br>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                    <br>
                    <button type="submit" class="button-orange-outline l-w-50">Register</button>
                </form>
                <p class="ms-t">Already have an account? <a href="login.php" class="white">Login here</a></p>
            </div>
        </section>
        
         
    </body>
</html>
