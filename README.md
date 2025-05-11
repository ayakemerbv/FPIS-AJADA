# Dorm Management System (DMS)

A web‑based application to streamline student housing operations: from room bookings and maintenance requests to payments, a peer‑to‑peer marketplace and campus news.

---

## Team Members

| Student Name           | Student ID  |
|------------------------|-------------|
| Suleimenova Zhasmin    | 22B030444   |
| Taimas Ayazhan         | 22B030447   |
| Taubayev Azamat        | 22B030450   |
| Tokanova Ayazhan       | 22B030455   |
| Oryngaly Dauir         | 22B030576   |

## Table of Contents

- [Project Overview](#project-overview)  
- [Key Features](#key-features)  
- [Requirements](#requirements)  
- [Installation](#installation)  
- [Environment Setup](#environment-setup)  
- [Backend Setup (Laravel, Sanctum)](#backend-setup-laravel-sanctum)  
- [Frontend Setup (React, Vite)](#frontend-setup-react-vite)  
- [Running the Project](#running-the-project)  
  - [With Docker / Sail](#with-docker--sail)  
  - [Without Docker](#without-docker)  
- [Database](#database)  
  - [Migrations & Seeders](#migrations--seeders)  
  - [Viewing Data](#viewing-data)  
- [API Documentation](#api-documentation)  
- [Project Structure](#project-structure)  
- [Artisan Commands](#artisan-commands)  
- [Testing](#testing)  
- [Tips & Tricks](#tips--tricks)  
- [Support & Contact](#support--contact)  
- [Changelog](#changelog)  
- [Security Considerations](#security-considerations)  

---

## Project Overview

The **Dorm Management System (DMS)** is a Laravel web application with a React frontend designed to manage dormitory buildings, rooms, students, staff, and a campus‑wide marketplace. The backend is a RESTful API secured by Laravel Sanctum, and the frontend is built with React and Vite for a seamless SPA experience.

---

## Key Features

- Role‑based authentication (student, manager, employee, admin) via Laravel Sanctum  
- RESTful JSON API backend  
- React SPA frontend with Vite and Tailwind CSS  
- Room booking and assignment workflow  
- Maintenance/repair request tracking  
- Document upload and management  
- Campus news publication  
- Peer‑to‑peer marketplace (ads)  
- Real‑time notifications  
- Payment integration (e.g., Kaspi)  

---

## Requirements

- Docker & Docker Desktop (WSL2 integration on Windows)  
- Git  
- PHP ≥ 8.1  
- Composer  
- Node.js ≥ 16  
- npm or Yarn  

---

## Installation

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-org/dorm-management-system.git
   cd dorm-management-system
   ```

2. **Backend dependencies**  
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Frontend dependencies**  
   ```bash
   cd dms-frontend
   npm install   # or yarn install
   cp .env.example .env
   ```

---

## Environment Setup

Edit your **backend** `.env`:

```dotenv
APP_NAME="DMS"
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1,localhost:5173
SESSION_DOMAIN=127.0.0.1

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=redis

MAIL_MAILER=log
```

Edit your **frontend** `.env`:  
```env
VITE_API_BASE_URL=http://localhost/api
```

---

## Backend Setup (Laravel, Sanctum)

1. **Install Sanctum**  
   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

2. **Configure CORS** (`config/cors.php`):  
   ```php
   'paths' => ['api/*', 'sanctum/csrf-cookie'],
   'allowed_origins' => ['http://localhost:5173'],
   'supports_credentials' => true,
   ```

3. **Kernel middleware** (`app/Http/Kernel.php`):  
   - In the **web** group:
     ```php
     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
     ```
   - In the **api** group:
     ```php
     'auth:sanctum',
     ```

4. **API routes** (`routes/api.php`):  
   ```php
   Route::get('/sanctum/csrf-cookie', fn() => response()->noContent());
   Route::post('/login',  [AuthController::class, 'login']);
   Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
   Route::get('/user',    [AuthController::class, 'user'])->middleware('auth:sanctum');
   // ... other resource routes (users, bookings, documents, service-requests, news, ads)
   ```

5. **Role middleware** (`app/Http/Middleware/RoleMiddleware.php`):  
   ```php
   public function handle($request, Closure $next, ...$roles)
   {
       if (!in_array(Auth::user()->role, $roles)) {
           return response()->json(['error'=>'Access denied'], 403);
       }
       return $next($request);
   }
   ```

---

## Frontend Setup (React, Vite)

1. **API client** (`src/api.js`):
   ```js
   import axios from 'axios';

   const API = axios.create({
     baseURL: import.meta.env.VITE_API_BASE_URL,
     withCredentials: true
   });

   API.interceptors.request.use(config => {
     // XSRF token handling is automatic with axios & withCredentials
     return config;
   });

   export default API;
   ```

2. **Run development server**  
   ```bash
   cd dms-frontend
   npm run dev   # or yarn dev
   ```

3. **Build for production**  
   ```bash
   npm run build
   ```

---

## Running the Project

### With Docker / Sail

1. Ensure Docker Desktop is running.  
2. Start services:
   ```bash
   ./vendor/bin/sail up -d
   ```
3. Migrate & seed:
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```
4. Start frontend:
   ```bash
   cd dms-frontend
   sail npm install
   sail npm run dev
   ```
5. Visit `http://localhost` (Laravel) and `http://localhost:5173` (React).

### Without Docker

1. Set up local PHP, Postgres, Redis.  
2. Run migrations & seed:
   ```bash
   php artisan migrate --seed
   ```
3. Serve backend:
   ```bash
   php artisan serve
   ```
4. Serve frontend:
   ```bash
   cd dms-frontend
   npm run dev
   ```

---

## Database

### Migrations & Seeders

- **Run migrations**: `php artisan migrate`
- **Reset & seed**: `php artisan migrate:fresh --seed`

### Viewing Data

```bash
psql -h localhost -U laravel -d laravel
```

---

## API Documentation

All endpoints are prefixed with `/api`. Authentication uses Laravel Sanctum (cookie-based).

### Authentication
- **GET** `/sanctum/csrf-cookie` — fetch CSRF cookie  
- **POST** `/login` — body: `{email, password}`  
- **POST** `/logout` (auth)  
- **GET** `/user` (auth) — current user  

### Users (admin, manager)
- **GET** `/users`  
- **POST** `/users` — `{name, email, password, role}`  
- **DELETE** `/users/{id}`  

### Bookings
- **POST** `/bookings` — create booking (student)  
- **GET** `/bookings` — list (student: own, manager: all)  
- **PUT** `/bookings/{id}` — update status (manager)  

### Documents
- **POST** `/documents` — upload file (multipart)  
- **GET** `/documents` — list own documents  

### Service Requests
- **POST** `/service-requests`  
- **GET** `/service-requests`  
- **PUT** `/service-requests/{id}`  

### News
- **GET** `/news`  
- **POST** `/news` — (admin/manager)  

### Ads
- **GET** `/ads`  
- **POST** `/ads`  
- **DELETE** `/ads/{id}`  

_For detailed request/response formats, see inline docblocks in controllers._

---

## Project Structure

```
backend/
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Middleware/
│   └── ...
├── routes/
│   ├── api.php
│   └── web.php
├── database/
│   ├── migrations/
│   └── seeders/
└── ...
frontend/
├── src/
│   ├── api.js
│   ├── components/
│   ├── pages/
│   └── ...
├── public/
└── ...
```

---

## Artisan Commands

- `php artisan migrate`  
- `php artisan db:seed`  
- `php artisan route:list`  
- `php artisan config:cache`  

---

## Testing

```bash
php artisan test
```

---

## Tips & Tricks

- **Alias Sail**: `alias sail='bash vendor/bin/sail'`  
- **Xdebug**: Set `SAIL_XDEBUG_MODE=debug` in `.env`  
- **Logs**: `sail logs laravel.test`  

---

## Changelog

### v1.1.0 (2025-05-11)
- Migrated to REST API with Laravel Sanctum  
- Introduced React SPA frontend with Vite  
- Unified endpoints for all roles  

---

## Security Considerations

- Do not commit `.env`  
- Use strong DB credentials  
- Enable HTTPS and secure cookies in production  
- Rate-limit auth endpoints  

---
