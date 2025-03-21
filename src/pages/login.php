<?php
session_start();
$conn = new mysqli("localhost", "root", "", "codevanta");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // To store login errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Fetch user details
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $hashedPassword, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['role'] = $role;

            // Collect user system information
            $ipAddress = $_SERVER['REMOTE_ADDR'];  
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $os = php_uname('s') . ' ' . php_uname('r');  
            $browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
            $location = get_location($ipAddress);  
            $processorDetails = php_uname('m'); 

            // Log the login event
            $logStmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, ip_address, user_agent, os, browser, location, processor_details) VALUES (?, 'User Logged In', ?, ?, ?, ?, ?, ?)");
            $logStmt->bind_param("issssss", $userId, $ipAddress, $userAgent, $os, $browser, $location, $processorDetails);
            $logStmt->execute();
            $logStmt->close();

            // Redirect based on role
            if ($role === "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: about.php");
            }
            exit();
        } else {
            $message = "Invalid username or password!";
        }
    } else {
        $message = "User not found!";
    }

    $stmt->close();
}

$conn->close();

// Function to extract browser name
function get_browser_name($userAgent) {
    if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
    if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
    if (strpos($userAgent, 'Safari') !== false) return 'Safari';
    if (strpos($userAgent, 'Edge') !== false) return 'Edge';
    if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';
    return 'Unknown';
}

// Function to get user location (Requires external API like ip-api.com)
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
        <title>Login</title>
    </head>
    <body>
        <h2>Login</h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            <br>
            <label>Password:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up here</a></p>
    </body>
</html>
