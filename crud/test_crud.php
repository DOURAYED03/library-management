<?php
require_once 'config.php';
require_once 'crud/book/create.php';
require_once 'crud/book/read.php';
require_once 'crud/book/update.php';
require_once 'crud/book/delete.php';
require_once 'crud/user/create.php';
require_once 'crud/user/read.php';
require_once 'crud/user/update.php';
require_once 'crud/user/delete.php';

// Test Book CRUD
echo "Testing Book CRUD:\n";

// Create book
$bookId = createBook("Test Book", "Author Name", 2023, "Fiction");
if ($bookId) {
    echo "Book created with ID: $bookId\n";
} else {
    echo "Failed to create book\n";
}

// Read book
$book = readBook($bookId);
if ($book) {
    echo "Book read: " . print_r($book, true) . "\n";
} else {
    echo "Failed to read book\n";
}

// Update book
$updateResult = updateBook($bookId, "Updated Book", "Updated Author", 2024, "Non-fiction");
echo $updateResult ? "Book updated successfully\n" : "Failed to update book\n";

// Delete book
$deleteResult = deleteBook($bookId);
echo $deleteResult ? "Book deleted successfully\n" : "Failed to delete book\n";

// Test User CRUD
echo "\nTesting User CRUD:\n";

// Create user
$userId = createUser("testuser", "Test User", "test@example.com");
if ($userId) {
    echo "User created with ID: $userId\n";
} else {
    echo "Failed to create user\n";
}

// Read user
$user = readUser($userId);
if ($user) {
    echo "User read: " . print_r($user, true) . "\n";
} else {
    echo "Failed to read user\n";
}

// Update user (without password change)
$updateUserResult = updateUser($userId, "updateduser", "Updated User", "updated@example.com");
echo $updateUserResult ? "User updated successfully\n" : "Failed to update user\n";

// Update user (with password change)
$updateUserResultPwd = updateUser($userId, "updateduser", "Updated User", "updated@example.com");
echo $updateUserResultPwd ? "User updated successfully a second time\n" : "Failed to update user a second time\n";

// Delete user
$deleteUserResult = deleteUser($userId);
echo $deleteUserResult ? "User deleted successfully\n" : "Failed to delete user\n";

?>
