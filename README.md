# 🎯 Artisans Task Manager & Corporate Portal

A **Full-Stack Web Application** built with Native PHP (MVC Architecture) and PostgreSQL. This system features a public dynamic landing page for customers and a secure private dashboard for task and project management.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169E1?logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?logo=docker&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 👥 Team Members

| Name | Student ID | Role |
|------|------------|------|
| **Alzubair Salaheddin Alojali** | 4426 | Backend Developer |
| **Mohamed Ramadan Alwerfalli** | 5013 | Frontend Developer |
| **Mohammed Jamal Eltarhoni** | 4469 | Frontend Developer |

---

## ✨ Key Features

### 🌐 Public Landing Page
- **Dynamic Services Section** – Content fetched from database, managed via admin panel
- **Editable About Us Section** – Site settings stored in database
- **Contact Form** – Visitor messages saved to database with read/unread status
- **Modern UI** – Responsive design with Tailwind CSS

### 🔐 Admin Dashboard
- **Secure Authentication** – Login/Register with password hashing
- **Role-Based Access** – Manager and Employee roles
- **Project Management** – Full CRUD operations with team assignment
- **Task Management** – Create, assign, track tasks with priorities and due dates
- **Content Management** – Edit landing page content and services
- **Message Inbox** – View and manage contact form submissions

### 🛠️ Tech Stack
| Layer | Technology |
|-------|------------|
| Backend | PHP 8.2 (Native MVC) |
| Database | PostgreSQL / MySQL |
| Frontend | HTML5, Tailwind CSS, Alpine.js |
| Deployment | Docker, Render.com |
| Version Control | Git & GitHub |

---

## 📁 Project Structure

```
web_final_project/
├── app/
│   ├── Controllers/       # Application controllers
│   ├── Models/            # Database models
│   └── Requests/          # Form validation classes
├── config/
│   └── database.php       # Database configuration
├── core/
│   ├── Controller.php     # Base controller class
│   ├── Model.php          # Base model class
│   ├── Router.php         # URL routing
│   └── Env.php            # Environment loader
├── database/
│   ├── schema_mysql.sql   # MySQL schema
│   ├── schema_postgres.sql # PostgreSQL schema
│   └── database_seed.php  # Database seeder
├── public/
│   └── index.php          # Application entry point
├── resources/views/       # View templates
├── routes/
│   └── web.php            # Route definitions
├── .env.example           # Environment template
├── Dockerfile             # Docker configuration
└── README.md
```

---

## 🚀 Setup & Installation

### Option A: Local Development (XAMPP / Laragon)

**Prerequisites:** PHP 8.0+, MySQL/PostgreSQL, Apache

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-repo/web_final_project.git
   cd web_final_project
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` and set your database credentials:
   ```env
   APP_URL=/web_final_project/public
   
   DB_DRIVER=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=web_final_project
   DB_USER=root
   DB_PASS=
   ```

3. **Import database schema**
   
   For MySQL:
   ```bash
   mysql -u root -p web_final_project < database/schema_mysql.sql
   ```
   
   For PostgreSQL:
   ```bash
   psql -U postgres -d web_final_project -f database/schema_postgres.sql
   ```

4. **Seed the database**
   ```bash
   php database/database_seed.php
   ```

5. **Access the application**
   ```
   http://localhost/web_final_project/public
   ```

---

### Option B: Docker / Production (Render.com)

**Prerequisites:** Docker installed

1. **Build the Docker image**
   ```bash
   docker build -t artisans-task-manager .
   ```

2. **Run the container**
   ```bash
   docker run -d -p 8080:80 \
     -e APP_URL="" \
     -e DB_DRIVER=pgsql \
     -e DB_HOST=your-db-host \
     -e DB_PORT=5432 \
     -e DB_NAME=your-db-name \
     -e DB_USER=your-db-user \
     -e DB_PASS=your-db-password \
     artisans-task-manager
   ```

3. **For Render.com deployment:**
   - Connect your GitHub repository
   - Set environment variables in Render dashboard
   - Run the PostgreSQL migration via Supabase SQL Editor using `database/migrations_supa.sql`

---

## 🗄️ Database & Seeding

### Idempotent Seeder

The database seeder is designed to be **re-runnable without duplicating data**. It checks for existing records before inserting.

**Run the seeder:**
```bash
php database/database_seed.php
```

**What gets seeded:**
| Table | Records |
|-------|---------|
| Users | 4 (1 Manager, 3 Employees) |
| Projects | 2 |
| Tasks | 5 |
| Comments | 3 |
| Services | 3 |
| Site Settings | 3 |
| Messages | 2 |

---

## 🔑 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Manager** | `mohammed@tripoli.ly` | `password123` |
| Employee | `salim@benghazi.ly` | `password123` |
| Employee | `fatima@misrata.ly` | `password123` |
| Employee | `ahmed@tripoli.ly` | `password123` |

> ⚠️ **Note:** Change these passwords in production!

---

## 📸 Screenshots

| Landing Page | Dashboard |
|--------------|-----------|
| Public-facing page with services and contact form | Project and task management interface |

---

## 📄 License

This project was developed as part of a university course assignment.

**© 2026 Artisans Team** – Alzubair, Mohamed, Mohammed

---

<p align="center">
  <strong>Built with ❤️ in Libya 🇱🇾</strong>
</p>
