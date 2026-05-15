# SIMS Master Prompt — Student Internship Management System

## Laravel Full Stack Web Application

---

## MASTER CONTEXT (include this at the start of every phase)

```
You are building a full stack web application called SIMS (Student Internship Management System)
using Laravel (latest stable version), MySQL, Blade templating, Tailwind CSS, and Alpine.js.

The system has four user roles:
- Student: applies for internships, submits weekly logbook entries, tracks progress
- Coordinator: university staff who approves applications, assigns supervisors, grades students
- Supervisor: company staff who evaluates and gives feedback on assigned students
- Admin: manages all system data — users, companies, internships, settings

Core packages to use:
- spatie/laravel-permission (role & permission management)
- laravel/breeze (authentication scaffolding)
- barryvdh/laravel-dompdf (PDF generation)
- intervention/image (image/file handling)

Database: MySQL. Use migrations for all schema changes. Use seeders for test data.
Follow Laravel conventions: resourceful controllers, form requests for validation,
policies for authorization, Eloquent relationships for all model interactions.
Use Blade components and layouts for a consistent, clean UI with Tailwind CSS.
```

---

## PHASE 1 — Project Initialization & Authentication

```
MASTER CONTEXT (above) applies.

Task: Set up the Laravel project foundation.

1. Initialize the Laravel project:
   - Install Laravel Breeze with Blade + Tailwind stack
   - Install and configure spatie/laravel-permission
   - Configure the .env file for MySQL database connection
   - Set APP_NAME to "SIMS"

2. Create the following database migrations (in this order):
   - users table (extend default: add fields — student_id, phone, department, profile_photo)
   - roles and permissions tables (via Spatie)
   - companies table (name, address, industry, contact_person, contact_email, contact_phone, website, logo, is_active)
   - internships table (company_id FK, title, description, slots, start_date, end_date, is_active)
   - applications table (student_id FK, internship_id FK, status ENUM[pending,approved,rejected], applied_at, reviewed_at, reviewed_by FK)
   - placements table (application_id FK, student_id FK, internship_id FK, supervisor_id FK, coordinator_id FK, start_date, end_date, status ENUM[active,completed,terminated])
   - logbooks table (placement_id FK, student_id FK, week_number, activities, challenges, skills_gained, submitted_at, status ENUM[draft,submitted,reviewed])
   - evaluations table (placement_id FK, evaluated_by FK, type ENUM[midterm,final], scores JSON, comments, total_score, submitted_at)
   - documents table (user_id FK, placement_id FK nullable, type, file_path, original_name, uploaded_at)
   - notifications table (use Laravel default notifications table)

3. Create Eloquent models for all tables above with:
   - Correct $fillable properties
   - All relationships (hasMany, belongsTo, hasOne, belongsToMany)
   - Relevant scopes (e.g. active(), pending(), byRole())

4. Create and seed the following roles using Spatie:
   - admin, coordinator, supervisor, student

5. Create a DatabaseSeeder that seeds:
   - 1 admin user (email: admin@sims.test, password: password)
   - 1 coordinator user (email: coordinator@sims.test, password: password)
   - 2 supervisor users
   - 5 student users
   - 3 sample companies
   - 3 sample internships linked to those companies

6. Create the main Blade layout:
   - resources/views/layouts/app.blade.php — main authenticated layout
   - Sidebar navigation that shows different links per role
   - Top navbar with user avatar dropdown (profile, logout)
   - Flash message component (success, error, warning)
   - Mobile responsive sidebar

7. Create a role-based redirect after login:
   - Admin → /admin/dashboard
   - Coordinator → /coordinator/dashboard
   - Supervisor → /supervisor/dashboard
   - Student → /student/dashboard

Run migrations and seeders. Confirm all role-based redirects work.
```

---

## PHASE 2 — Admin Module

```
MASTER CONTEXT applies. Phase 1 is complete.

Task: Build the full Admin module.

Create an AdminController (or use separate resource controllers under App\Http\Controllers\Admin namespace).
All admin routes should be prefixed with /admin and protected by middleware: ['auth', 'role:admin'].

Build the following admin features:

1. Admin Dashboard (/admin/dashboard)
   - Summary cards: total students, total companies, total internships, active placements
   - Recent applications table (last 10)
   - Chart placeholder div (use a simple bar chart with Chart.js showing applications per month)

2. User Management (/admin/users)
   - List all users with role badge, status, and search/filter
   - Create user form (name, email, role, department, student_id for students, phone)
   - Edit user form
   - Activate / Deactivate user (soft toggle on is_active column)
   - Reset user password button (generates a random password and emails it)

3. Company Management (/admin/companies)
   - List all companies with logo, name, industry, contact, status
   - Create/Edit company form (with logo upload, validate image max 2MB)
   - Toggle company active/inactive
   - View company detail — shows linked internships and placed students

4. Internship Management (/admin/internships)
   - List internships with company name, slots, dates, status
   - Create/Edit internship form linked to a company
   - Toggle active/inactive
   - View internship detail — shows applications and approved students

5. Settings Page (/admin/settings)
   - Update system name, contact email, academic year (stored in a settings table or config file)

Use Form Request classes for all create/edit validation.
Use Resource Controllers. Add Policy: AdminPolicy to ensure only admins access these routes.
All tables must have pagination (15 per page).
```

---

## PHASE 3 — Student Module

```
MASTER CONTEXT applies. Phases 1 & 2 are complete.

Task: Build the full Student module.

All routes prefixed with /student, protected by middleware: ['auth', 'role:student'].

1. Student Dashboard (/student/dashboard)
   - Status card: current application status (or prompt to apply if none)
   - Active placement details (company, supervisor, start/end date)
   - Logbook completion progress (weeks submitted vs total weeks)
   - Recent notifications list

2. Internship Listings (/student/internships)
   - Browse all active internships with company logo, title, slots, dates
   - Search by title or company name
   - View internship detail page
   - Apply button — one-click application (student can only apply to one internship at a time)
   - Show "Application Pending" badge if already applied

3. My Application (/student/application)
   - Show current application status with a timeline (Applied → Under Review → Approved/Rejected)
   - If rejected: show reason and allow re-application
   - If approved: show placement details

4. Logbook (/student/logbook)
   - List all logbook entries by week number with status badges
   - Create new weekly entry form:
     - Week number (auto-calculated from placement start date)
     - Activities carried out (rich textarea)
     - Challenges encountered
     - Skills gained
     - Save as Draft or Submit
   - View/Edit draft entries
   - View submitted entries (read-only after submission)

5. Evaluations (/student/evaluations)
   - View midterm and final evaluation scores submitted by supervisor
   - Show breakdown of scores per criterion
   - Show comments from supervisor

6. Documents (/student/documents)
   - Upload documents (acceptance letter, insurance, etc.)
   - List uploaded documents with download links
   - File types allowed: PDF, DOC, DOCX, JPG, PNG (max 5MB each)

7. Profile (/student/profile)
   - Edit profile: name, phone, department, student_id, profile photo upload

All forms must use Laravel Form Requests for validation.
Notify the coordinator via Laravel Notification (database + mail) when a student submits an application.
```

---

## PHASE 4 — Coordinator Module

```
MASTER CONTEXT applies. Phases 1–3 are complete.

Task: Build the full Coordinator module.

All routes prefixed with /coordinator, protected by middleware: ['auth', 'role:coordinator'].

1. Coordinator Dashboard (/coordinator/dashboard)
   - Cards: pending applications, active placements, pending logbook reviews, evaluations due
   - Applications awaiting review (quick action table with Approve/Reject buttons)
   - List of students with overdue logbook submissions

2. Application Management (/coordinator/applications)
   - List all applications with filters: status (pending/approved/rejected), company, date range
   - View application detail:
     - Student info card
     - Internship info card
     - Action panel: Approve (with supervisor assignment dropdown) or Reject (with reason textbox)
   - On approval: automatically create a Placement record linking student, internship, supervisor, and coordinator
   - Send notification to student on approval or rejection

3. Placement Management (/coordinator/placements)
   - List all active and completed placements
   - View placement detail:
     - Student and company info
     - Logbook submission history with review button
     - Evaluation scores summary

4. Logbook Review (/coordinator/logbooks)
   - List all submitted (unreviewed) logbook entries
   - View a logbook entry in full
   - Add coordinator comment and mark as reviewed
   - Flag entry if content is insufficient (triggers notification to student)

5. Evaluation Management (/coordinator/evaluations)
   - View all evaluations submitted by supervisors
   - View evaluation detail with full score breakdown
   - Submit final coordinator grade/comment per placement

6. Reports (/coordinator/reports)
   - Generate a PDF report for a selected student placement:
     - Student details, company details, logbook summary, evaluation scores
     - Use barryvdh/laravel-dompdf to render the PDF
   - Export all placements to CSV (using Laravel's built-in response streamDownload)

All notifications (database + mail channel) must be sent for:
- Application approval/rejection → to student
- Logbook flagged → to student
- Supervisor evaluation submitted → to coordinator
```

---

## PHASE 5 — Supervisor Module

```
MASTER CONTEXT applies. Phases 1–4 are complete.

Task: Build the full Supervisor module.

All routes prefixed with /supervisor, protected by middleware: ['auth', 'role:supervisor'].

1. Supervisor Dashboard (/supervisor/dashboard)
   - Cards: assigned students count, pending logbook reviews, evaluations pending
   - List of assigned students with placement status badges

2. Assigned Students (/supervisor/students)
   - List students assigned to this supervisor
   - View student detail:
     - Personal info
     - Placement info (company, dates)
     - Logbook submission timeline (week by week, with status)

3. Logbook Review (/supervisor/logbooks)
   - List all logbook entries from assigned students
   - Filter by student, week, status
   - View a logbook entry in full
   - Add supervisor feedback comment
   - Mark as Reviewed

4. Evaluations (/supervisor/evaluations)
   - List placements that require midterm and final evaluations
   - Show which are submitted and which are pending
   - Evaluation form (create/edit):
     - Evaluation type: Midterm or Final
     - Criteria-based scoring (e.g. Punctuality, Technical Skills, Communication, Initiative, Overall — each scored /20)
     - Comments textarea
     - Submit button (once submitted, locked for editing)
   - Scores are stored as JSON in the evaluations table

5. Profile (/supervisor/profile)
   - Edit name, phone, profile photo

On evaluation submission, send a Laravel Notification (database + mail) to the assigned coordinator.
```

---

## PHASE 6 — Notifications, Polish & Final Touches

```
MASTER CONTEXT applies. Phases 1–5 are complete.

Task: Finalize the application — notifications, UI polish, security hardening, and deployment prep.

1. Notification Center
   - Create a unified /notifications route accessible to all roles
   - Show all database notifications (unread on top, mark as read on click)
   - Add a notification bell icon in the navbar with unread count badge
   - "Mark all as read" button

2. Email Notifications (Mail Channel)
   - Confirm all Notification classes send emails using a clean Blade email template
   - Create a master email layout: resources/views/emails/layout.blade.php
   - Notifications to wire up:
     - ApplicationSubmitted → to coordinator
     - ApplicationApproved → to student
     - ApplicationRejected → to student
     - LogbookFlagged → to student
     - EvaluationSubmitted → to coordinator

3. UI Polish
   - Ensure all pages are fully mobile responsive
   - Add loading spinner on form submissions (Alpine.js)
   - Empty state illustrations/messages on all list pages when no data exists
   - Breadcrumb navigation on all inner pages
   - Consistent table row hover states
   - All status badges use consistent color coding:
     - pending → amber, approved → green, rejected → red, active → blue, completed → gray

4. Security Hardening
   - Ensure all routes are protected by correct role middleware
   - Add Policies for all sensitive actions (approve application, submit evaluation, etc.)
   - Validate all file uploads (type, size)
   - Add CSRF protection confirmation (already in Laravel, verify forms)
   - Prevent students from accessing other students' data (scope all queries to auth()->id())

5. Deployment Preparation
   - Create a .env.example with all required keys documented
   - Write a README.md with:
     - Project overview
     - Requirements (PHP 8.2+, MySQL 8, Composer, Node)
     - Installation steps
     - Seeder credentials table
     - Role permission summary
   - Run php artisan optimize and ensure config caching works
   - Confirm php artisan queue:work handles all mail jobs (use database queue driver)

6. Final QA Checklist (ask Claude Code to run through this):
   - All 4 roles can log in and see their correct dashboard
   - Student can apply, track application, submit logbook
   - Coordinator can approve/reject, review logbooks, generate PDF report
   - Supervisor can view students, review logbooks, submit evaluations
   - Admin can manage users, companies, internships
   - Emails are queued and sent correctly
   - PDF report downloads correctly
   - CSV export works
   - All forms validate correctly and show errors
```

---

## QUICK REFERENCE

| Phase | Focus              | Key Deliverable                             |
| ----- | ------------------ | ------------------------------------------- |
| 1     | Setup & Auth       | Project scaffold, roles, seeded DB, layouts |
| 2     | Admin Module       | User, company, internship management        |
| 3     | Student Module     | Apply, logbook, documents, profile          |
| 4     | Coordinator Module | Approve, review, reports, PDF export        |
| 5     | Supervisor Module  | Evaluate, feedback, logbook review          |
| 6     | Polish & Deploy    | Notifications, security, README, QA         |

---

## TIPS FOR USING WITH CLAUDE CODE

- Run one phase at a time. Do not move to the next phase until the current one is working.
- After each phase, test by logging in as each relevant user role.
- If Claude Code asks for clarification on any feature, refer it back to this document.
- You can ask Claude Code to generate tests for each phase using: _"Write feature tests for Phase X using PHPUnit"_
- For any phase, you can add: _"Follow the existing code style and conventions already in the project"_
