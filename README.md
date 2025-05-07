
# Dorm Management System (DMS)

Full documentation for the **Dorm Management System** project. Paste this into your `README.md` and adjust as needed.

---
## Team Members

| Student Name           | Student ID  |
|------------------------|-------------|
| Suleimenova Zhasmin    | 22B030444   |
| Temirgali Rustem       | 22B030451   |
| Taubayev Azamat        | 22B030450   |
| Tulepbergen Nurkhan    | 22B030445   |

## Table of Contents

- [Project Overview](#project-overview)  
- [Key Features](#key-features)  
- [Requirements](#requirements)  
- [Installation](#installation)  
- [Environment Setup](#environment-setup)  
- [Running the Project](#running-the-project)  
  - [With Docker / Sail](#with-docker--sail)  
  - [Without Docker](#without-docker)  
- [Database](#database)  
  - [Migrations & Seeders](#migrations--seeders)  
  - [Viewing Data](#viewing-data)  
- [Project Structure](#project-structure)  
- [Artisan Commands](#artisan-commands)  
- [Testing](#testing)  
- [Tips & Tricks](#tips--tricks)  
- [Support & Contact](#support--contact)

---

## Project Overview

The **Dorm Management System (DMS)** is a Laravel web application designed to manage dormitory buildings, rooms, students, staff, and a campus‑wide marketplace. It uses [Laravel Sail](https://laravel.com/docs/sail) and Docker for seamless local development and deployment.

---

## Key Features

- User registration & authentication (students, managers, admins)  
- Room booking applications for students  
- “Buy & Sell” marketplace with create, edit, delete capabilities  
- Real‑time notifications and private messaging  
- Maintenance and repair request tracking  
- News feed and events calendar  

---

## Requirements

- Docker & Docker Desktop (WSL2 integration on Windows)  
- Git  
- PHP ≥ 8.0  
- Composer  

---

## Installation

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-org/dorm-management-system.git
   cd dorm-management-system
   ```

2. **Install PHP dependencies**  
   ```bash
   composer install
   ```

3. *(Optional)* **Install frontend dependencies**  
   ```bash
   npm install
   ```

4. **Copy environment file & generate key**  
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

---

## Environment Setup

Edit your `.env` file to configure your environment:

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
FORWARD_DB_PORT=5432

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=database
SESSION_DRIVER=database
```

> **Tip**: On Windows, use WSL2 with Docker Desktop and enable integration for your Ubuntu distro.

---

## Running the Project

### With Docker / Sail

1. Ensure **Docker Desktop** is running.  
2. From the project root, start all services:
   ```bash
   ./vendor/bin/sail up -d
   ```
3. Run migrations and seed data:
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```
4. Open your browser at `http://localhost`.

### Without Docker

1. Configure your local PHP server (Valet, Homestead, XAMPP, etc.).  
2. Ensure **PostgreSQL** and **Redis** are running locally.  
3. Run:
   ```bash
   php artisan migrate --force
   php artisan db:seed
   php artisan serve
   ```
4. Browse to `http://127.0.0.1:8000`.

---

## Database

### Migrations & Seeders

- **Run migrations**:
  ```bash
  ./vendor/bin/sail artisan migrate
  ```
- **Reset & seed**:
  ```bash
  ./vendor/bin/sail artisan migrate:fresh --seed
  ```

### Viewing Data

Use **psql** or a GUI client (DataGrip, DBeaver):

```bash
./vendor/bin/sail exec pgsql psql -U sail -d laravel
```

Then, for example:

```sql
SELECT * FROM students;
```

---

## Project Structure

```
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Services/         # e.g. KaspiPaymentService
│   └── ...
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── docker-compose.yml    # Docker Compose config
├── .env
├── README.md
└── vendor/
```

---

## Artisan Commands

- `php artisan migrate` — run migrations  
- `php artisan db:seed` — run seeders  
- `php artisan route:list` — list routes  
- `php artisan tinker` — interactive shell  
- `php artisan config:clear` — clear config cache  

---

## Testing

If tests are available:

```bash
./vendor/bin/sail artisan test
```

---

## Tips & Tricks

- **Alias Sail**  
  ```bash
  alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
  ```
  Then use `sail up -d` instead of the full path.

- **Enable Xdebug**  
  Set `SAIL_XDEBUG_MODE=debug` in your `.env`.

- **View logs**  
  ```bash
  sail logs laravel.test
  sail logs pgsql
  ```

---

# API Documentation

## Authentication
- **POST /** - Login to the system
- **POST /logout** - Logout from the system (requires authentication)

## Admin Panel
*Requires authentication and admin role*

### User Management
- **GET /admin/dashboard/users/create** - Display user creation form
- **POST /admin/dashboard/users** - Create new user
- **GET /admin/dashboard/users** - List all users
- **DELETE /admin/dashboard/users/{id}** - Delete user
- **GET /admin/users/{id}/json** - Get user information in JSON format

## Student Panel
*Requires authentication and student role*

### Profile and Personal Account
- **GET /student/dashboard** - Student dashboard
- **GET /student/personal** - Personal account
- **POST /student/personal/profile/update** - Update profile
- **PATCH /student/personal/profile/update** - Update profile details

### Marketplace
- **GET /student/ads** - View advertisements
- **POST /student/ads** - Create advertisement
- **PUT /student/ads/{ad}** - Update advertisement
- **DELETE /student/ads/{ad}** - Delete advertisement

### Room Booking
- **GET /student/personal/floors/{building_id}** - Get list of floors in building
- **GET /student/personal/rooms/{building_id}/{floor}** - Get list of rooms
- **POST /student/personal/booking/store** - Create booking
- **POST /student/personal/booking/change-room** - Change room

### Payments
- **POST /payment/initiate** - Initialize payment
- **GET /payment/callback** - Payment system callback
- **GET /payment/status/{id}** - Check payment status

### Maintenance Requests
- **GET /personal/create-request** - Display request creation form
- **POST /personal** - Create request
- **GET /personal/requests** - List requests
- **GET /personal/requests/{id}** - View request details
- **PUT /personal/requests/{repairRequest}** - Update request
- **DELETE /personal/requests/{repairRequest}** - Delete request

## Employee Panel
*Requires authentication and employee role*

### Request Management
- **GET /employee/dashboard/requests** - List requests
- **GET /employee/dashboard/requests/{id}** - View request details
- **PUT /employee/dashboard/requests/{id}** - Update request status

## Common Endpoints
- **POST /language-switch** - Switch language
- **GET /notifications** - Get notifications
- **POST /notifications/{id}/read** - Mark notification as read

## Response Format

### Success Response
