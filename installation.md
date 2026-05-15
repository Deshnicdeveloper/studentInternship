# SIMS (Student Internship Management System) - Installation Guide

This guide covers the step-by-step process required to set up the SIMS Laravel application on your local development environment.

## Prerequisites
- PHP >= 8.3 (If you are using an older version like PHP 8.2, see the composer flag below)
- Composer
- Node.js and NPM
- MySQL or another supported database

## Step-by-Step Installation

### 1. Clone the Repository
Clone the project repository to your local machine:
```bash
git clone <repository-url>
cd studentInternship
```

### 2. Install PHP Dependencies
Install the required PHP packages. 

> [!WARNING]  
> If you are using a PHP version lower than 8.3 (e.g., PHP 8.2 via XAMPP), Laravel 12+ requires PHP 8.3+. You **must** use the `--ignore-platform-reqs` flag to bypass the platform requirement check.

```bash
# If your PHP version is >= 8.3:
composer install

# If your PHP version is < 8.3:
composer install --ignore-platform-reqs
```

### 3. Install NPM Dependencies
Install and build the frontend assets using Vite:
```bash
npm install
npm run build
```

### 4. Configure the Environment
Copy the example environment file and create your own `.env` file:
```bash
cp .env.example .env
```

Open the `.env` file and make sure your database credentials are correct. For example:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sims
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
Generate the Laravel encryption key:
```bash
php artisan key:generate
```

### 6. Run Migrations & Seed the Database
Run the database migrations and seeders to create all necessary tables, roles, permissions, and test accounts. 

> [!NOTE]  
> If the `sims` database does not exist, Laravel will prompt you and ask if you would like to create it. Select "Yes".

```bash
php artisan migrate:fresh --seed
```

### 7. Link Storage Directory
Create a symbolic link for the storage folder so that uploaded files and documents can be publicly accessible:
```bash
php artisan storage:link
```

### 8. Start Development Servers
You will need to run both the Laravel backend server and the Vite frontend server simultaneously.

In your first terminal tab, start the Laravel server:
```bash
php artisan serve
```

In a second terminal tab, start the Vite development server:
```bash
npm run dev
```

Your application should now be accessible at `http://localhost:8000` (or `http://127.0.0.1:8001` if port 8000 is occupied).

---

## Test Accounts

The seeder automatically generates the following default accounts for testing the application roles:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sims.test | password |
| Coordinator | coordinator@sims.test | password |
| Supervisor | supervisor1@sims.test | password |
| Supervisor | supervisor2@sims.test | password |
| Student | student1@sims.test | password |
| Student | student2@sims.test | password |
| Student | student3@sims.test | password |
| Student | student4@sims.test | password |
| Student | student5@sims.test | password |

You can log in with any of these accounts via the `/login` route.
