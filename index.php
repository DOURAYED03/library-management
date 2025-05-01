<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Haven - Home</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo filemtime('styles.css'); ?>">
</head>
<body>
    <header class="header">
        <h1>Library Haven</h1>
        <p>Welcome to Your Modern Bibliothèque</p>
    </header>

    <main class="container">
        <section class="section fade-in">
            <h2 style="text-align: center;">Explore the Shelves</h2>
            <nav class="horizontal-nav" id="main-nav" style="text-align: center;">
                <ul>
                    <li><a href="books.php" class="nav-link"><span class="icon">📚</span> <span class="link-text">Books</span></a></li>
                    <li><a href="users.php" class="nav-link"><span class="icon">👥</span> <span class="link-text">Users</span></a></li>
                    <li><a href="list-books.php" class="nav-link"><span class="icon">📖</span> <span class="link-text">List Books</span></a></li>
                    <li><a href="list-users.php" class="nav-link"><span class="icon">👥</span> <span class="link-text">List Users</span></a></li>
                </ul>
            </nav>
        </section>
    </main>

    <footer class="footer">
        <p>© 2025 Library Haven. All Rights Reserved.</p>
    </footer>

       <!-- Other HTML content -->

       <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.horizontal-nav .nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent immediate navigation

                    // Add fade-out class to body for exit animation
                    document.body.classList.add('fade-out');

                    // After animation duration, navigate to the link's href
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 500); // Match this duration with CSS animation duration
                });
            });
        });
    </script>
</body>
</html>