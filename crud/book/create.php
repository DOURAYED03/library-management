<?php
require_once __DIR__ . '/../../config.php';

function createBook($title, $author, $year, $genre) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO livres (title, author, year, genre) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("siss", $title, $author, $year, $genre);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>
