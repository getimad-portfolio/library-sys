# Library Management System

A Laravel demo application for managing a library catalog, members, book loans, and reviews.

## Features

- Manage books, categories, and cover images.
- Manage library members and staff accounts.
- Track book loans and returns.
- Collect book reviews and ratings.
- View audit history for library records.

## Setup

Requirements: PHP, Composer, Node.js/npm, and a database supported by Laravel.

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Configure the database connection in `.env`, then create the database tables and populate them with demo data:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Open the URL printed by `php artisan serve` in your browser.

## Demo data

The seeder creates sample admin and librarian accounts, categories, books, members, loans, reviews, and audit entries. It uses the cover images in `storage/app/public/covers`; keep at least one supported image there.

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@library.test` | `password` |
| Librarian | `librarian@library.test` | `password` |

Running the seeder again updates its demo records without duplicating them:

```bash
php artisan db:seed
```

To run the focused seeder test:

```bash
php artisan test tests/Feature/LibraryDemoSeederTest.php
```

> **Warning:** `php artisan migrate:fresh --seed` deletes all existing database tables and data before recreating and seeding them. Use it only when you intend to reset the database.
