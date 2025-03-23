<?php
    include("./database.php");

    $username = "test";
    $password = "abc123";
    $role = "admin";

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Admin created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>
