<?php
require_once __DIR__ . '/../../config.php';

function deleteBook($bookId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM livres WHERE bookId = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $bookId);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>
