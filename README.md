# Laravel 12 Project with Docker, PostgreSQL, and Redis

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
- **Spatie Response Cache** – API Response Caching
- **TailwindCSS** – UI Styling
- **PostgreSQL** – Database
- **Redis** – Cache & Queue Driver
- **Adminer** – Database Management

## API Routes

### Authentication

```http
POST /api/register    # User Registration
POST /api/login       # User Login
GET  /api/logout      # Logout
GET  /api/user        # Get Authenticated User
```

### Posters

```http
POST   /api/poster        # Create (Admin Only)
GET    /api/poster/{id}   # Read
PUT    /api/poster/{id}   # Update (Admin Only)
DELETE /api/poster/{id}   # Delete (Admin Only)
POST   /api/posterall     # Fetch All Posters with Filters
GET    /api/posterlike/{id} # Toggle Like
```

### Categories & Regions

```http
GET /api/regandcat  # Fetch Categories and Regions (Cached with Redis)
```

## Deployment

### 1. Build Optimized Files

```sh
npm run build
```

### 2. Clear and Cache Configurations

```sh
./vendor/bin/sail artisan config:cache
```

### 3. Run in Production Mode

```sh
./vendor/bin/sail up -d --build
```

## License

This project is licensed under the MIT License.

