<?php
session_start();
include("./database.php");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $hashedPassword, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['role'] = $role;

            $ipAddress = $_SERVER['REMOTE_ADDR'];  
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $os = php_uname('s') . ' ' . php_uname('r');  
            $browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
            $location = get_location($ipAddress);  
            $processorDetails = php_uname('m'); 

            $logStmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, ip_address, user_agent, os, browser, location, processor_details) VALUES (?, 'User Logged In', ?, ?, ?, ?, ?, ?)");
            $logStmt->bind_param("issssss", $userId, $ipAddress, $userAgent, $os, $browser, $location, $processorDetails);
            $logStmt->execute();
            $logStmt->close();

            if ($role === "admin") {
                header("Location: admin_dashboard.php");
                exit();
            } 
            else {
                header("Location: about.php");
                exit();
            }
        } 
        else {
            $message = "<span>Invalid username or password!</span>";
        }
    } 
    else {
        $message = "<span>User not found!</span>";
    }

    $stmt->close();
}

$conn->close();

function get_browser_name($userAgent) {
    if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
    if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
    if (strpos($userAgent, 'Safari') !== false) return 'Safari';
    if (strpos($userAgent, 'Edge') !== false) return 'Edge';
    if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';
    return 'Unknown';
}

function get_location($ip) {
    $apiURL = "http://ip-api.com/json/" . $ip;
    $response = file_get_contents($apiURL);
    $data = json_decode($response, true);
    return isset($data['city']) ? $data['city'] . ', ' . $data['country'] : 'Unknown';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - CodeVanta</title>
        <link rel="stylesheet" href="src/assets/styles/global.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    </head>
    <body>
        <main>
            <section class="hero hero-login">
                <div class="hero-contact-left">
                    <h1 class="ms-b lg-80">Innovators, Developers, and Dreamers</h1>
                    <hr class="w-50">
                    <p class="ms-t md-50">Have an idea, project, or passion for tech? At CodeVanta, we’re here to support your journey — from inspiration to execution. Log in and let’s grow together.</p>
                </div>
                <div class="hero-login-right w-50 mxl-t">
                    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                    <form method="POST">
                        <label>Username:</label>
                        <input type="text" name="username" required>
                        <br>
                        <label>Password:</label>
                        <input type="password" name="password" required>
                        <br>
                        <button type="submit" class="button-orange-outline l-w-50">Login</button>
                    </form>
                    <p class="ms-t">Don't have an account?<a href="register.php" class="white"> Sign up here</a</p>
                </div>
                
            </section>
        </main>
    </body>
</html>
