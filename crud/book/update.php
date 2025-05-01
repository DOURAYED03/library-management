<?php
require_once __DIR__ . '/../../config.php';

function updateBook($bookId, $title, $author, $year, $genre) {
    global $conn;
    $stmt = $conn->prepare("UPDATE livres SET title = ?, author = ?, year = ?, genre = ? WHERE bookId = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssisi", $title, $author, $year, $genre, $bookId);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>
