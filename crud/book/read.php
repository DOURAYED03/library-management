<?php
require_once __DIR__ . '/../../config.php';

function readBook($bookId) {
    global $conn;
    $stmt = $conn->prepare("SELECT bookId, title, author, year FROM livres WHERE bookId = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
    return $book;
}
?>
