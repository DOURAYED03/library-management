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
    <title>Library Haven - Manage Users</title>
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
                    <li><a href="books.php" class="nav-link">📚 Books</a></li>
                    <li><a href="users.php" class="nav-link active">👥 Users</a></li>
                    <li><a href="list-books.php" class="nav-link">📖 List Books</a></li>
                    <li><a href="list-users.php" class="nav-link">👥 List Users</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <section class="section fade-in">
                <h2><span class="icon">👤</span> Manage Users</h2>
                
                <div class="search-bar">
                    <form action="users.php" method="GET">
                        <input type="text" id="userSearch" name="userSearch" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-search">🔍 Search</button>
                    </form>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="add-user" class="toggle-input">
                    <label for="add-user" class="btn btn-primary">🆔 Add User</label>
                    <form action="api.php" method="POST" class="form-card toggle-form centered-form">
                        <h3>Add User</h3>
                        <input type="hidden" name="userId" value="">
                        <input type="text" name="userFirstName" placeholder="First Name" required>
                        <input type="text" name="userLastName" placeholder="Last Name" required>
                        <input type="email" name="userEmail" placeholder="Email" required>
                        <div class="button-group">
                            <button type="submit" name="action" value="saveUser" class="btn btn-primary">Save</button>
                            <label for="add-user" class="btn btn-cancel">Cancel</label>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <table class="card-table" id="usersTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="table-actions">
                                    <div class="action-container">
                                        <input type="checkbox" id="edit-user-<?php echo $user['id']; ?>" class="toggle-input">
                                        <label for="edit-user-<?php echo $user['id']; ?>" class="btn btn-primary">✏️ Edit</label>
                                        <form action="api.php" method="POST" class="form-card toggle-form centered-form">
                                            <h3>Edit User</h3>
                                            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                            <input type="text" name="userFirstName" placeholder="First Name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                            <input type="text" name="userLastName" placeholder="Last Name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                            <input type="email" name="userEmail" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                            <div class="button-group">
                                                <button type="submit" name="action" value="saveUser" class="btn btn-primary">Save</button>
                                                <label for="edit-user-<?php echo $user['id']; ?>" class="btn btn-cancel">Cancel</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="action-container">
                                        <input type="checkbox" id="delete-user-<?php echo $user['id']; ?>" class="toggle-input">
                                        <label for="delete-user-<?php echo $user['id']; ?>" class="btn btn-danger">🗑️ Delete</label>
                                        <form action="api.php" method="POST" class="form-card toggle-form centered-form">
                                            <h3>Confirm Deletion</h3>
                                            <p>Are you sure you want to delete "<?php echo htmlspecialchars($user['name'] . ' ' . $user['last_name']); ?>"?</p>
                                            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                            <div class="button-group">
                                                <button type="submit" name="action" value="deleteUser" class="btn btn-danger">Delete</button>
                                                <label for="delete-user-<?php echo $user['id']; ?>" class="btn btn-cancel">Cancel</label>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="4">No users found.</td>
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
