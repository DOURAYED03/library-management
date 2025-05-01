<?php
require_once 'config.php';

$genres = ['Fiction', 'Non-fiction', 'Mystery', 'Sci-fi', 'Biography', 'Fantasy', 'Romance', 'Thriller'];
$search = '';
if (isset($_GET['bookSearch']) && trim($_GET['bookSearch']) !== '') {
    $search = trim($_GET['bookSearch']);
}

if ($search) {
    $stmt = $conn->prepare("SELECT bookId, title, author, year, genre FROM livres WHERE title LIKE CONCAT('%', ?, '%') OR author LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("ss", $search, $search);
} else {
    $stmt = $conn->prepare("SELECT bookId, title, author, year, genre FROM livres");
}
$stmt->execute();
$result = $stmt->get_result();
$books = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Haven - Manage Books</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body class="content-page">
    <header class="header">
        <h1>Library Haven</h1>
    </header>

    <div class="page-wrapper">
        <aside class="vertical-sidebar">
            <h2 class="sidebar-title">Menu</h2>
            <nav class="vertical-nav">
                <ul>
                    <li><a href="index.php" class="nav-link">🏠 Home</a></li>
                    <li><a href="books.php" class="nav-link active">📚 Books</a></li>
                    <li><a href="users.php" class="nav-link">👥 Users</a></li>
                    <li><a href="list-books.php" class="nav-link">📖 List Books</a></li>
                    <li><a href="list-users.php" class="nav-link">👥 List Users</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <section class="section fade-in">
                <h2><span class="icon">📚</span> Manage Books</h2>
                
                <div class="search-bar">
                    <form action="books.php" method="GET">
                        <input type="text" id="bookSearch" name="bookSearch" placeholder="Search by title or author" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-search">🔍 Search</button>
                    </form>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="add-book" class="toggle-input">
                    <label for="add-book" class="btn btn-primary">🖋️ Add Book</label>
                    <form action="api.php" method="POST" class="form-card toggle-form centered-form">
                        <h3>Add Book</h3>
                        <input type="hidden" name="bookId" value="">
                        <input type="text" name="bookTitle" placeholder="Book Title" required>
                        <input type="text" name="bookAuthor" placeholder="Author" required>
                        <input type="number" name="bookYear" placeholder="Year" required>
                        <select name="bookGenre" required>
                            <option value="">Select Genre</option>
                            <?php foreach ($genres as $genreOption): ?>
                                <option value="<?php echo htmlspecialchars($genreOption); ?>"><?php echo htmlspecialchars($genreOption); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="button-group">
                            <button type="submit" name="action" value="saveBook" class="btn btn-primary">Save</button>
                            <label for="add-book" class="btn btn-cancel">Cancel</label>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <table class="card-table" id="booksTable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Year</th>
                                <th>Genre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars($book['year']); ?></td>
                                <td><?php echo htmlspecialchars($book['genre']); ?></td>
                                <td class="table-actions">
                                    <div class="action-container">
                                        <input type="checkbox" id="edit-book-<?php echo $book['bookId']; ?>" class="toggle-input">
                                        <label for="edit-book-<?php echo $book['bookId']; ?>" class="btn btn-primary">✏️ Edit</label>
                                        <form action="api.php" method="POST" class="form-card toggle-form centered-form">
                                            <h3>Edit Book</h3>
                                            <input type="hidden" name="bookId" value="<?php echo $book['bookId']; ?>">
                                            <input type="text" name="bookTitle" placeholder="Book Title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                                            <input type="text" name="bookAuthor" placeholder="Author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                                            <input type="number" name="bookYear" placeholder="Year" value="<?php echo htmlspecialchars($book['year']); ?>" required>
                                            <select name="bookGenre" required>
                                                <option value="">Select Genre</option>
                                                <?php foreach ($genres as $genreOption): ?>
                                                    <option value="<?php echo htmlspecialchars($genreOption); ?>" <?php if ($genreOption === $book['genre']) echo 'selected'; ?>>
                                                        <?php echo htmlspecialchars($genreOption); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="button-group">
                                                <button type="submit" name="action" value="saveBook" class="btn btn-primary">Save</button>
                                                <label for="edit-book-<?php echo $book['bookId']; ?>" class="btn btn-cancel">Cancel</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="action-container">
                                        <input type="checkbox" id="delete-book-<?php echo $book['bookId']; ?>" class="toggle-input">
                                        <label for="delete-book-<?php echo $book['bookId']; ?>" class="btn btn-danger">🗑️ Delete</label>
                                        <form action="api.php" method="POST" class="form-card toggle-form centered-form">
                                            <h3>Confirm Deletion</h3>
                                            <p>Are you sure you want to delete "<?php echo htmlspecialchars($book['title']); ?>"?</p>
                                            <input type="hidden" name="bookId" value="<?php echo $book['bookId']; ?>">
                                            <div class="button-group">
                                                <button type="submit" name="action" value="deleteBook" class="btn btn-danger">Delete</button>
                                                <label for="delete-book-<?php echo $book['bookId']; ?>" class="btn btn-cancel">Cancel</label>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($books)): ?>
                            <tr>
                                <td colspan="5">No books found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <footer class="footer">
        <p>© 2025 Library Haven. All Rights Reserved.</p>
    </footer>
</body>
</html>