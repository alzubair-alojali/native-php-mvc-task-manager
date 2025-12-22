<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

# 🚀 Web Final Project

> A modern **Project Management System** built with Native PHP MVC Architecture. Designed for teams to organize projects, assign tasks, track deadlines, and collaborate effectively.

---

## 📸 Screenshots

<p align="center">
  <img src="docs/screenshots/dashboard.png" alt="Dashboard" width="80%">
</p>

<details>
<summary>View More Screenshots</summary>

| Login Page | Projects List |
|------------|---------------|
| ![Login](docs/screenshots/login.png) | ![Projects](docs/screenshots/projects.png) |

| Task Details | Team Members |
|--------------|--------------|
| ![Task](docs/screenshots/task.png) | ![Members](docs/screenshots/members.png) |

</details>

---

## ✨ Features

### 🔐 Authentication & Security
- Secure Login/Register with password hashing
- Guest Guards (redirect logged-in users away from auth pages)
- Role-Based Access Control (Manager vs Employee)
- Session security with regeneration

### 📊 Dashboard
- Real-time statistics (Projects, Tasks, Completed)
- Recent activity feed
- Quick access to projects and tasks

### 📁 Project Management
- Full CRUD operations
- Ownership protection (only managers can edit their projects)
- Project status tracking (Pending, Active, Completed)
- Deadline management

### ✅ Task Management
- Create, assign, and track tasks
- Priority levels (Low, Medium, High)
- Status workflow (Pending → In Progress → Completed)
- Due date tracking with overdue indicators

### 👥 Team Collaboration
- Add/remove project members
- Chat-style comments on tasks
- Real-time discussion threads

### 🔍 Search
- Global search across projects and tasks
- Instant results with highlighting

### 🎨 Modern UI/UX
- Responsive design (Mobile-first)
- Beautiful Tailwind CSS styling
- Interactive Alpine.js components
- Smooth animations and transitions

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 8.2 (Native MVC), PDO |
| **Frontend** | HTML5, Tailwind CSS (CDN), Alpine.js |
| **Database** | PostgreSQL (Production), MySQL (Development) |
| **Infrastructure** | Docker, Render.com |
| **Architecture** | Custom MVC Pattern |

---

## 📦 Installation

### Method A: Using Docker (Recommended) 🐳

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/web-final-project.git
cd web-final-project

# 2. Create environment file
cp .env.example .env

# 3. Edit .env with your database credentials
nano .env

# 4. Build the Docker image
docker build -t web-final-project .

# 5. Run the container
docker run -p 8080:80 --env-file .env web-final-project

# 6. Access the application
# Open: http://localhost:8080
```

> **Note:** The container automatically runs database migrations and seeds demo data on first startup.

---

### Method B: Manual Setup (Local Development)

#### Prerequisites
- PHP 8.2+
- PostgreSQL 14+ or MySQL 8+
- Apache with mod_rewrite enabled

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/web-final-project.git
cd web-final-project

# 2. Create environment file
cp .env.example .env

# 3. Configure your .env file
DB_DRIVER=pgsql          # or 'mysql' for local development
DB_HOST=localhost
DB_PORT=5432             # or 3306 for MySQL
DB_DATABASE=web_final_project
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 4. Create the database
psql -U postgres -c "CREATE DATABASE web_final_project;"

# 5. Import the schema
psql -U postgres -d web_final_project -f database/schema.sql

# 6. (Optional) Seed demo data
php database/database_seed.php

# 7. Configure Apache virtual host to point to /public directory

# 8. Access the application
# Open: http://localhost/web_final_project/public
```

---

## 🧪 Demo Credentials

After seeding, use these credentials to explore:

| Role | Email | Password |
|------|-------|----------|
| **Manager** | mohammed@tripoli.ly | password123 |
| **Employee** | salim@benghazi.ly | password123 |

---

## 📁 Project Structure

```
web-final-project/
├── app/
│   ├── Controllers/       # Request handlers
│   ├── Models/            # Database models
│   └── Requests/          # Form validation
├── config/
│   └── database.php       # Database configuration
├── core/
│   ├── Controller.php     # Base controller
│   ├── Model.php          # Base model
│   ├── Router.php         # URL routing
│   └── Validator.php      # Input validation
├── database/
│   ├── schema.sql         # PostgreSQL schema
│   └── database_seed.php  # Demo data seeder
├── public/
│   ├── index.php          # Application entry point
│   └── .htaccess          # URL rewriting
├── resources/
│   └── views/             # PHP templates
├── routes/
│   └── web.php            # Route definitions
├── .env.example           # Environment template
├── Dockerfile             # Docker configuration
└── README.md
```

---

## 🌐 Deployment (Render.com)

1. **Create PostgreSQL Database** on Render
2. **Create Web Service** → Connect GitHub repo
3. **Set Environment Variables:**
   ```
   DB_DRIVER=pgsql
   DB_HOST=<from-render-database>
   DB_PORT=5432
   DB_DATABASE=<from-render>
   DB_USERNAME=<from-render>
   DB_PASSWORD=<from-render>
   APP_DEBUG=false
   ```
4. **Deploy** → Render will build using Dockerfile

---

## 🔒 Security Features

- ✅ Password hashing with `password_hash()`
- ✅ PDO Prepared Statements (SQL Injection prevention)
- ✅ XSS protection with `htmlspecialchars()`
- ✅ Session regeneration after login
- ✅ Role-based access control
- ✅ Ownership verification on all mutations

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🎓 Credits

**Built as a Final University Project**

This project was developed as part of a university course to demonstrate proficiency in:
- Native PHP development (without frameworks)
- MVC architectural patterns
- Database design and management
- Modern frontend technologies
- DevOps and containerization

---

## 📞 Contact

For questions or feedback, please open an issue on GitHub.

---

<p align="center">
  Made with ❤️ in Libya 🇱🇾
</p>
