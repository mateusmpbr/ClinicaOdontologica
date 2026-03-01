# Clinica Odontologica

> A lightweight dental clinic management application (PHP) — patient records, appointments, billing and basic clinic administration.

## Key Features

- Patient management (create, edit, list)
- Appointment scheduling and consultation records
- Billing, payments and receipt handling
- Staff, dentists and specialty management
- Expense tracking and simple financial overview

## Tech Stack

- PHP (framework-agnostic structure)
- Composer for dependency management
- Docker / docker-compose for local development
- SQLite/MySQL (configured in `config/database.php`)

## Repository Structure

- `app/` — application controllers, helpers, models and services
- `views/` — server-rendered templates used by controllers
- `public/` — web root (index.php, assets)
- `config/` — configuration files (database, etc.)
- `database/` — SQL schema and model files
- `storage/` — logs and runtime storage

## Prerequisites

- Docker & Docker Compose (recommended) or PHP + web server + Composer
- Composer (if running without Docker)

## Quick Start (Docker)

1. Build and start containers:

```bash
docker-compose up --build -d
```

2. Check logs or the web service to confirm the app is running. Access the app using the port exposed in `docker-compose.yml`.

## Quick Start (Local / Composer)

1. Install PHP dependencies:

```bash
composer install
```

2. Configure your web server to serve the `public/` directory as the document root, or use PHP's built-in server for quick testing:

```bash
php -S 127.0.0.1:8000 -t public
```

3. Open `http://127.0.0.1:8000` in your browser.

## Configuration

- Database settings live in `config/database.php`. Update credentials and driver there.
- Some SQL model and seed files are in `database/model/sql` to initialize schema/tables.

## Development Notes

- Controllers are located in `app/Controllers/` and follow a simple organization: Create/Edit/List controllers for each entity.
- Views are plain PHP templates in `views/` and `public/views` (assets served from `public/`).
- Logs are written to `storage/logs/`.

## Contributing

Contributions are welcome. Please open issues for bugs or feature requests and submit pull requests with clear descriptions.

## License

This project does not include a license file. Add a `LICENSE` file if you intend to open-source or specify licensing terms.

## Known Improvements

The project has a couple of already-identified areas for improvement that would reduce duplication and simplify maintenance:

- **Unify `determineSidebar()`**: centralize sidebar determination logic to avoid duplicated code across controllers/views.
- **Reduce repeated request parsing**: minimize repetition of `request()->getParsedBody()` and `request()->getQueryParams()` by extracting values into variables for each context (controller/method) to improve readability and testability.
