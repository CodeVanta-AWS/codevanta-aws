<?php
session_start();
include("./database.php");
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $ipAddress = $_SERVER['REMOTE_ADDR'];  
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $os = php_uname('s') . ' ' . php_uname('r');  
    $browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
    $location = get_location($ipAddress);  
    $processorDetails = php_uname('m'); 

    // Log the logout event
    $logStmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, ip_address, user_agent, os, browser, location, processor_details) VALUES (?, 'User Logged Out', ?, ?, ?, ?, ?, ?)");
    $logStmt->bind_param("issssss", $userId, $ipAddress, $userAgent, $os, $browser, $location, $processorDetails);
    $logStmt->execute();
    $logStmt->close();
}

// Destroy session and redirect to login page
session_unset();
session_destroy();
header("Location: login.php");
exit();

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
