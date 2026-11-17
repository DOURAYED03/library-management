<?php
require_once 'crud/book/create.php';
require_once 'crud/book/read.php';
require_once 'crud/book/update.php';
require_once 'crud/book/delete.php';
require_once 'crud/user/create.php';
require_once 'crud/user/read.php';
require_once 'crud/user/update.php';
require_once 'crud/user/delete.php';

$action = $_POST['action'] ?? '';
$allowedRedirects = ['index.php', 'books.php', 'users.php', 'list-books.php', 'list-users.php'];
$refererPath = parse_url($_SERVER['HTTP_REFERER'] ?? '', PHP_URL_PATH);
$referer = $refererPath ? basename($refererPath) : '';
$redirect = in_array($referer, $allowedRedirects, true) ? $referer : 'index.php';

switch ($action) {
    case 'saveBook':
        $bookId = $_POST['bookId'] ?? '';
        $title = $_POST['bookTitle'] ?? '';
        $author = $_POST['bookAuthor'] ?? '';
        $year = $_POST['bookYear'] ?? '';
        $genre = $_POST['bookGenre'] ?? '';
        if ($bookId) {
            updateBook((int)$bookId, $title, $author, (int)$year, $genre);
        } else {
            createBook($title, $author, (int)$year, $genre);
        }
        break;

    case 'deleteBook':
        $bookId = $_POST['bookId'] ?? '';
        if ($bookId) {
            deleteBook((int)$bookId);
        }
        break;

    case 'saveUser':
        $userId = $_POST['userId'] ?? '';
        $firstName = $_POST['userFirstName'] ?? '';
        $lastName = $_POST['userLastName'] ?? '';
        $email = $_POST['userEmail'] ?? '';
        if ($userId) {
            updateUser((int)$userId, $firstName, $lastName, $email);
        } else {
            createUser($firstName, $lastName, $email);
        }
        break;

    case 'deleteUser':
        $userId = $_POST['userId'] ?? '';
        if ($userId) {
            deleteUser((int)$userId);
        }
        break;

    default:
        // Unknown action
        break;
}

header("Location: $redirect");
exit;
