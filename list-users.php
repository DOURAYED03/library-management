<?php
require_once 'config.php';

$search = '';
if (isset($_GET['userSearch'])) {
    $search = $_GET['userSearch'];
}

if ($search) {
    $stmt = $conn->prepare("SELECT id, name, last_name, email FROM users WHERE name LIKE CONCAT('%', ?, '%') OR last_name LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("ss", $search, $search);
} else {
    $stmt = $conn->prepare("SELECT id, name, last_name, email FROM users");
}
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Haven - List Users</title>
    <link rel="stylesheet" href="styles.css">
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
                    <li><a href="list-books.php" class="nav-link">📖 List Books</a></li>
                    <li><a href="list-users.php" class="nav-link active">👥 List Users</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <section class="section fade-in">
                <h2><span class="icon">👥</span> List Users</h2>
                
                <div class="search-bar">
                    <form action="list-users.php" method="GET">
                        <input type="text" id="userSearch" name="userSearch" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-search">🔍 Search</button>
                    </form>
                </div>

                <div class="table-container">
                    <table class="card-table" id="usersTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="3">No users found.</td>
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