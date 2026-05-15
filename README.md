# SIMS - Student Internship Management System

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-8.2%2B-blue.svg" alt="PHP Version">
<img src="https://img.shields.io/badge/MySQL-8.0%2B-orange.svg" alt="MySQL Version">
<img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## Overview

SIMS (Student Internship Management System) is a comprehensive web application designed to streamline the management of student internship programs. It provides a complete workflow for students, coordinators, supervisors, and administrators to manage internship applications, placements, logbooks, and evaluations.

## Features

### For Students
- Browse and apply for available internships
- Track application status with visual timeline
- Submit weekly logbook entries
- View supervisor evaluations and feedback
- Upload required documents
- Manage profile information

### For Coordinators
- Review and approve/reject internship applications
- Assign supervisors to placements
- Monitor logbook submissions
- Review and grade student placements
- Generate PDF reports
- Export data to CSV

### For Supervisors
- View assigned students
- Review and provide feedback on logbook entries
- Submit midterm and final evaluations
- Score students on 5 criteria (each /20)

### For Administrators
- Manage users (CRUD operations)
- Manage companies and internship postings
- Configure system settings
- View system-wide statistics

## Requirements

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **npm** >= 9.x
- **MySQL** >= 8.0 (or SQLite for development)

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd sims
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file and configure your database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sims
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup

```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Frontend Assets

```bash
npm run build
```

For development with hot reloading:
```bash
npm run dev
```

### 7. Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default User Credentials

After running the seeders, you can log in with these test accounts:

| Role        | Email                    | Password   |
|-------------|--------------------------|------------|
| Admin       | admin@sims.test          | password   |
| Coordinator | coordinator@sims.test    | password   |
| Supervisor  | supervisor1@sims.test    | password   |
| Supervisor  | supervisor2@sims.test    | password   |
| Student     | student1@sims.test       | password   |
| Student     | student2@sims.test       | password   |
| Student     | student3@sims.test       | password   |
| Student     | student4@sims.test       | password   |
| Student     | student5@sims.test       | password   |

## Role Permissions

### Admin
- Full access to all system features
- User management (create, edit, delete, activate/deactivate)
- Company management
- Internship management
- System settings

### Coordinator
- View and manage applications (approve/reject)
- Assign supervisors to placements
- Review logbook entries
- View evaluations
- Generate reports (PDF/CSV)
- Submit final grades

### Supervisor
- View assigned students only
- Review logbook entries with feedback
- Submit midterm and final evaluations
- Cannot access other supervisors' students

### Student
- Apply for one internship at a time
- Submit weekly logbook entries
- View own evaluations
- Upload documents
- Cannot access other students' data

## Queue Configuration

For email notifications to work in production, run the queue worker:

```bash
php artisan queue:work
```

For development, you can use synchronous queue:
```env
QUEUE_CONNECTION=sync
```

## PDF Generation

PDF reports are generated using [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf). Ensure the storage directory is writable:

```bash
chmod -R 775 storage bootstrap/cache
```

## Testing

Run the test suite:

```bash
php artisan test
```

## Deployment Checklist

1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Run `php artisan view:cache`
5. Run `php artisan optimize`
6. Configure queue worker (Supervisor recommended)
7. Set up scheduled tasks in cron
8. Configure proper file permissions
9. Set up SSL certificate
10. Configure backup strategy

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin module controllers
│   ├── Coordinator/    # Coordinator module controllers
│   ├── Supervisor/     # Supervisor module controllers
│   └── Student/        # Student module controllers
├── Models/             # Eloquent models
├── Notifications/      # Notification classes
└── Policies/           # Authorization policies

resources/views/
├── admin/              # Admin views
├── coordinator/        # Coordinator views
├── supervisor/         # Supervisor views
├── student/            # Student views
├── components/         # Reusable Blade components
├── emails/             # Email templates
└── layouts/            # Layout templates
```

## Key Packages

- [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze-and-blade) - Authentication scaffolding
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Role & permission management
- [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) - PDF generation
- [Tailwind CSS](https://tailwindcss.com/) - UI styling
- [Alpine.js](https://alpinejs.dev/) - JavaScript interactions

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please open an issue in the repository.

---

**Built with Laravel** - The PHP Framework for Web Artisans
