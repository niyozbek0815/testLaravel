# Laravel 12 Project with Docker, PostgreSQL, and Redis

**Note:** Since Laravel 12 is still new, some packages may not work, so I rewrote them manually as best I could.

## Requirements

- **PHP**: 8.2+
- **Laravel**: 12.0+
- **Composer**: Latest version
- **Node.js & NPM**: Latest LTS version
- **Docker & Docker Compose**

## Installation

### 1. Clone Repository

```sh
git clone https://github.com/niyozbek0815/testLaravel.git
cd testLaravel
```

### 2. Setup Environment

```sh
cp .env.example .env
```

Update `.env` file with your configurations (e.g., database, cache, queue, etc.).

### 3. Install Dependencies

```sh
composer install
npm install
```

### 4. Start Docker Services

```sh
./vendor/bin/sail up -d
```

This will start PostgreSQL, Redis, and the Laravel application inside a Sail container.

### 5. Run Migrations & Seeders

```sh
./vendor/bin/sail artisan migrate --seed
```

### 6. Generate Application Key

```sh
./vendor/bin/sail artisan key:generate
```

### 7. Build Frontend Assets

```sh
npm run dev
```

## Features & Packages Used

- **Laravel Jetstream (Livewire)** – Authentication & Dashboard
- **Sanctum** – API Authentication
- **Spatie Medialibrary** – Media File Management
- **Spatie Response Cache** – API Response Cachin
