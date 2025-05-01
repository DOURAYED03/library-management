<?php
require_once __DIR__ . '/../../config.php';

function createUser($name, $lastName, $email) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO users (name, last_name, email) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $name, $lastName, $email);
    if ($stmt->execute()) {
        return $conn->insert_id;
    } else {
        return false;
    }
    $stmt->close();
}
?>
