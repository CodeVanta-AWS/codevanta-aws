<?php
session_start();
include("./database.php");

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $ipAddress = $_SERVER['REMOTE_ADDR'];  
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $os = php_uname('s') . ' ' . php_uname('r');  
    $browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
    $location = get_location($ipAddress);  
    $processorDetails = php_uname('m'); 

    $logStmt = $conn->prepare("INSERT INTO audit_logs (user_id, action, ip_address, user_agent, os, browser, location, processor_details) VALUES (?, 'User Logged Out', ?, ?, ?, ?, ?, ?)");
    $logStmt->bind_param("issssss", $userId, $ipAddress, $userAgent, $os, $browser, $location, $processorDetails);
    $logStmt->execute();
    $logStmt->close();
}

session_unset();
session_destroy();
header("Location: http://codevanta-test.s3-website-ap-southeast-1.amazonaws.com/");
exit();

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
