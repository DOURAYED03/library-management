<?php
require_once 'config.php';

$search = '';
if (isset($_GET['bookSearch'])) {
    $search = $_GET['bookSearch'];
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
    <title>Library Haven - List Books</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo filemtime('styles.css'); ?>">
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
                    <li><a href="books.php" class="nav-link">📚 Books</a></li>
                    <li><a href="users.php" class="nav-link">👥 Users</a></li>
                    <li><a href="list-books.php" class="nav-link active">📖 List Books</a></li>
                    <li><a href="list-users.php" class="nav-link">👥 List Users</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <section class="section fade-in">
                <h2><span class="icon">📖</span> List Books</h2>
                
                <div class="search-bar">
                    <form action="list-books.php" method="GET">
                        <input type="text" id="bookSearch" name="bookSearch" placeholder="Search by title or author" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-search">🔍 Search</button>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars($book['year']); ?></td>
                                <td><?php echo htmlspecialchars($book['genre']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($books)): ?>
                            <tr>
                                <td colspan="4">No books found.</td>
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