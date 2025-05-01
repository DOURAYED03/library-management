<?php
require_once __DIR__ . '/../../config.php';

function updateUser($id, $name, $lastName, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET name = ?, last_name = ?, email = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssi", $name, $lastName, $email, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>
