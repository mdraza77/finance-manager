# Finance Manager

A comprehensive web-based finance management system built with Laravel for tracking income, expenses, and financial transactions with role-based access control.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0-38B2AC?style=flat&logo=tailwindcss)
![Database](https://img.shields.io/badge/Database-PostgreSQL-336791?style=flat&logo=postgresql)

---

## 📋 Features

### Dashboard Analytics
- Total Income, Expenses, and Net Balance
- Category-wise breakdown
- Monthly trends chart (last 6 months)
- Recent activity overview
- Interactive Chart.js visualizations

### Transaction Management
- Record income and expenses
- Categorize transactions (Salary, Rent, Food, Transport, etc.)
- Edit and delete transactions
- View transaction history with user details
- Soft delete support

### User Management
- Role-based access control (Admin, Analyst, Viewer)
- Permission-based actions
- User creation, editing, and deletion
- Soft delete with restore functionality
- Mobile number support

### Roles & Permissions
- Granular permission system via Spatie
- Custom role creation
- Permission assignment per role

### Data Export
- Export to Excel, PDF, CSV
- Print-friendly reports
- Search and filter functionality
- DataTables with sorting

### Responsive Design
- Mobile-friendly interface
- Modern TailwindCSS UI
- Collapsible sidebar
- Smooth animations

---

## 🚀 Installation

### Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js 18+ & NPM
- PostgreSQL or MySQL
- Git

### Step-by-Step Setup

1. **Clone the repository**
   ```bash
   git clone (https://github.com/mdraza77/finance-manager.git)
   cd finance-manager
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Setup environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   
   Update `.env` file (default is PostgreSQL):
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=finance_manager
   DB_USERNAME=[Your Username]
   DB_PASSWORD=[Your Password]
   ```
   
   Or for MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=finance_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database** (creates admin user & permissions)
   ```bash
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    ```
    http://localhost:8000
    ```

---

## 📁 Project Structure

```
finance-manager/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── UserController.php
│   │   │   ├── RoleController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   └── Transaction.php
│   └── ...
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── header.blade.php
│   │   │   └── main.blade.php
│   │   ├── dashboard/
│   │   │   └── index.blade.php
│   │   ├── transactions/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── users/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   └── roles/
│   └── js/
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_04_01_135047_create_permission_tables.php
│   │   ├── 2026_04_01_181342_add_mobile_to_users_table.php
│   │   ├── 2026_04_01_181851_add_soft_delete_to_users_table.php
│   │   └── 2026_04_01_194138_create_transactions_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── PermissionSeeder.php
├── routes/
│   └── web.php
└── public/
```

---

## 🔐 Default Credentials

After running the seeder, login with:

| Role  | Email             | Password        |
|-------|-------------------|-----------------|
| Admin | admin@gmail.com   | Success2026$    |

> ⚠️ **Change default credentials immediately in production!**

---

## 📊 Database Schema

### Users Table
| Column           | Type         | Description              |
|------------------|--------------|--------------------------|
| id               | bigint       | Primary key              |
| name             | string       | User full name           |
| email            | string       | Unique email             |
| password         | string       | Hashed password          |
| mobile           | string       | 10-digit mobile number   |
| remember_token   | string       | Session token            |
| created_at       | timestamp    | Record creation time     |
| updated_at       | timestamp    | Record update time       |
| deleted_at       | timestamp    | Soft delete timestamp    |

### Transactions Table
| Column           | Type         | Description              |
|------------------|--------------|--------------------------|
| id               | bigint       | Primary key              |
| user_id          | bigint       | Foreign key to users     |
| type             | enum         | 'income' or 'expense'    |
| amount           | decimal(15,2)| Transaction amount       |
| category         | string       | Category name            |
| transaction_date | date         | Date of transaction      |
| description      | text         | Optional notes           |
| created_at       | timestamp    | Record creation time     |
| updated_at       | timestamp    | Record update time       |
| deleted_at       | timestamp    | Soft delete timestamp    |

---

## 🔒 Roles & Permissions

### Available Roles

| Role     | Description                              |
|----------|------------------------------------------|
| Admin    | Full access to all features              |
| Analyst  | Data analysis and record entry           |
| Viewer   | Read-only access to dashboard & records  |

### Available Permissions

| Module              | Permissions                              |
|---------------------|------------------------------------------|
| Dashboard           | Dashboard-View, Analytics-View           |
| Transactions        | Transaction-Index, Create, Edit, View, Delete |
| User Management     | UserManagement-Index, Create, Edit, View, Delete |
| Access Management   | AccessManagement-Index, Create, Edit, View, Delete |

### Permission Assignment

```php
// Admin: All permissions
$admin->syncPermissions(Permission::all());

// Analyst: Limited permissions
$analyst->syncPermissions([
    'Dashboard-View',
    'Analytics-View',
    'Transaction-Index',
    'Transaction-Create',
    'Transaction-Edit',
    'Transaction-View',
]);

// Viewer: Read-only
$viewer->syncPermissions([
    'Dashboard-View',
    'Transaction-Index',
    'Analytics-View',
    'Transaction-View',
]);
```

---

## 🛠️ Available Commands

```bash
# Setup (fresh install)
composer setup

# Run migrations
php artisan migrate

# Seed database (creates admin user)
php artisan db:seed

# Fresh migration with seed
php artisan migrate:fresh --seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run development server (with queue & Vite)
composer run dev

# Build assets
npm run dev      # Development (watch mode)
npm run build    # Production

# Run tests
composer test
```

---

## 🎨 Technologies Used

| Technology         | Version | Purpose                      |
|--------------------|---------|------------------------------|
| Laravel            | 13.x    | Backend Framework            |
| PHP                | 8.3+    | Server-side Language         |
| TailwindCSS        | 3.x     | Styling                      |
| jQuery             | 3.7.1   | DOM Manipulation             |
| DataTables         | 2.3.7   | Tables with sorting/export   |
| Chart.js           | Latest  | Analytics charts             |
| Font Awesome       | 6.4.0   | Icons                        |
| Bootstrap Icons    | 1.11.1  | Additional icons             |
| Spatie Permission  | 7.2     | Role & Permission management |
| PostgreSQL/MySQL   | Latest  | Database                     |

---

## 📝 Routes Overview

### Protected Routes (Require Authentication)

```php
GET  /                    → Dashboard
GET  /dashboard          → Dashboard
GET  /profile            → Profile edit
PATCH /profile           → Profile update
DELETE /profile          → Delete account

// Users
GET  /users              → User list
GET  /user/create        → Create user form
POST /user/store         → Store user
GET  /user/show/{id}     → View user
GET  /user/edit/{id}     → Edit user form
PUT  /user/update/{id}   → Update user
DELETE /user/delete/{id} → Delete user
DELETE /user/restore/{id}→ Restore user

// Roles & Permissions
GET  /roles              → Role list
GET  /roles/create       → Create role form
POST /roles              → Store role
// ... (full resource)

// Transactions
GET  /transactions       → Transaction list
GET  /transactions/create → Create transaction
POST /transactions       → Store transaction
GET  /transactions/{id}  → View transaction
GET  /transactions/{id}/edit → Edit transaction
PUT  /transactions/{id}  → Update transaction
DELETE /transactions/{id}→ Delete transaction
```

---

## 🐛 Troubleshooting

### Common Issues

**1. Permission denied errors**
```bash
chmod -R 775 storage bootstrap/cache
```

**2. Class not found**
```bash
composer dump-autoload
```

**3. Assets not loading**
```bash
npm run build
php artisan view:clear
```

**4. Database connection error**
- Check `.env` database credentials
- Ensure PostgreSQL/MySQL is running
- Verify database exists

**5. Permission/Role errors**
```bash
php artisan cache:clear
php artisan config:clear
php artisan db:seed
```

**6. Spatie Permission cache issue**
```bash
php artisan permission:cache-clear
```

---

## 🧪 Testing

```bash
# Run all tests
composer test

# Run tests with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/TransactionTest.php
```

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📧 Support

For support, email **mdraza8397@gmail.com** or create an issue in the repository.

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - PHP Framework
- [TailwindCSS](https://tailwindcss.com) - CSS Framework
- [DataTables](https://datatables.net) - Table plugin
- [Chart.js](https://www.chartjs.org) - Charting library
- [Spatie Permission](https://spatie.be/docs/laravel-permission) - Permission management
- [Font Awesome](https://fontawesome.com) - Icons

---

## 📌 Project Info

- **Version**: 1.0.0
- **Last Updated**: April 2026
- **Author**: Md Raza

---

<p align="center">Made with ❤️ using Laravel</p>
