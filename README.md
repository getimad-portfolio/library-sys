# Library Management System

A web-based library management system built with Laravel 10. It provides role-based tools for managing books, categories, members, borrowing activity, reviews, and administrative audit logs.

## Features

- Authentication and profile management
- Role-based access for administrators and librarians
- Separate dashboards for administrators and librarians
- Book catalog management
  - Create, view, update, and delete books
  - Track available stock
  - Organize books by category
- Category management with customizable colors
- Member management
- Borrowing workflow for issuing and updating borrowed books
- Book reviews
- Administrative audit logs powered by Laravel Auditing
- Token-based authentication support through Laravel Sanctum
- Responsive frontend built with Blade, Tailwind CSS, Alpine.js, and Vite

## Tech Stack

- **Backend:** PHP 8.1+, Laravel 10
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Build tool:** Vite
- **Database:** MySQL
- **Authentication:** Laravel Breeze and Laravel Sanctum
- **Testing:** PHPUnit
- **Other integrations:** Telegram Bot SDK, Guzzle, Laravel Auditing

## Requirements

Make sure the following are installed before running the project:

- PHP 8.1 or newer
- Composer
- Node.js and npm
- MySQL 5.7+ or MySQL-compatible database
- A PHP database extension for MySQL

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/getimad-portfolio/library-sys.git
   cd library-sys
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install frontend dependencies:

   ```bash
   npm install
   ```

4. Create the environment file:

   ```bash
   cp .env.example .env
   ```

5. Configure the database in `.env`. The default configuration expects a MySQL database named `library_sys`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library_sys
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Generate the application key:

   ```bash
   php artisan key:generate
   ```

7. Run database migrations:

   ```bash
   php artisan migrate
   ```

8. Build the frontend assets:

   ```bash
   npm run build
   ```

## Running Locally

Start the Laravel development server:

```bash
php artisan serve
```

For frontend development with Vite hot reloading, run the Vite development server in a separate terminal:

```bash
npm run dev
```

The application will normally be available at [http://localhost:8000](http://localhost:8000).

## Database

The database schema includes tables for:

- Users and personal access tokens
- Categories
- Books and inventory stock
- Members
- Borrowing records
- Reviews
- Audit history

To reset and rebuild the database during development, use:

```bash
php artisan migrate:fresh
```

> **Warning:** `migrate:fresh` deletes all existing tables and data. Use it only in a development environment unless you intentionally want to reset the database.

## Testing

Run the test suite with:

```bash
php artisan test
```

or:

```bash
./vendor/bin/phpunit
```

## Project Structure

```text
app/                 Application code, controllers, models, enums, and middleware
database/            Migrations, factories, and seeders
resources/views/     Blade templates
routes/              Web and authentication routes
public/              Public assets and application entry point
tests/               PHPUnit tests
```

## Access Control

The application uses authenticated, role-based routes. Administrative users can access system dashboards and audit logs, while librarians have access to librarian-specific functionality and shared library management features.

## Contributing

1. Fork the repository.
2. Create a feature branch:

   ```bash
   git checkout -b feature/your-feature
   ```

3. Make your changes and add tests where appropriate.
4. Run the test suite and frontend build.
5. Commit your changes and open a pull request.

## License

This project is released under the MIT License. See the repository for more information.
