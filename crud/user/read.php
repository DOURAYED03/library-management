<?php
require_once __DIR__ . '/../../config.php';

function readUser($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, name, last_name, email FROM users WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}
?>
