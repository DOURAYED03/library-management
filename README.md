# Library Haven

Small PHP/MySQL library-management application for maintaining books and library users through browser-based CRUD pages.

## Features

- Add, edit, search, list, and delete books.
- Add, edit, search, list, and delete users.
- Prepared MySQLi statements for CRUD operations.
- HTML escaping when values are rendered in pages.
- Simple browser navigation and responsive stylesheet.

## Technology

- PHP
- MySQL
- MySQLi
- HTML and CSS

## Architecture

The application uses PHP pages as both controllers and views. `books.php` and `users.php` read records and render forms; `api.php` dispatches POST actions; CRUD functions under `crud/` execute prepared statements; and `config.php` creates the shared MySQLi connection.

## Project structure

```text
config.php              MySQLi connection configuration
index.php               Landing page
books.php               Book management page
users.php               User management page
list-books.php          Book listing page
list-users.php          User listing page
api.php                 POST action dispatcher
crud/book/              Book CRUD functions
crud/user/              User CRUD functions
crud/test_crud.php      Manual CRUD smoke-test script
test_db_connection.php  Manual connection check
styles.css              Shared styles
```

## Prerequisites

- PHP 8.x with the MySQLi extension.
- MySQL or MariaDB.
- A web server capable of serving PHP, such as Apache, Nginx with PHP-FPM, or PHP's development server.

## Installation

1. Create a MySQL database named `biblio` or choose another database name.
2. Create the tables expected by the application:
   - `livres(bookId, title, author, year, genre)`
   - `users(id, name, last_name, email)`
3. Use a database user with only the permissions required by this application.
4. Configure the connection through environment variables.

The repository does not include an authoritative SQL dump. The table names and columns above are inferred from the current queries; verify them against the real database before applying schema changes.

## Configuration

`config.php` reads:

| Variable | Default | Purpose |
|---|---|---|
| `DB_HOST` | `localhost` | MySQL host |
| `DB_USER` | `root` | MySQL user |
| `DB_PASSWORD` | empty | MySQL password |
| `DB_NAME` | `biblio` | Database name |

Do not commit passwords or production connection strings. The defaults are intended only for local development.

## Run locally

From the repository root:

```bash
php -S localhost:8000
```

Open `http://localhost:8000/`.

## Manual checks

```bash
php test_db_connection.php
php crud/test_crud.php
```

These scripts require a running database with the expected tables and can create and delete test records.

## Security considerations

- CRUD endpoints currently have no authentication or authorization; do not expose this application publicly without adding access control.
- Inputs are sent through prepared statements, but production deployments should add stronger validation and CSRF protection.
- Redirects after POST actions are restricted to known local pages.
- Database connection errors no longer disclose the underlying server error.

## Known limitations and future improvements

- Add an authoritative database migration/schema file after confirming the deployed schema.
- Add authentication, authorization, CSRF protection, and audit logging.
- Add server-side validation for years, names, and email uniqueness.
- Replace `die()`-style error handling with user-safe error pages and server-side logging.

## License

No license file is currently present.
