# Finance Manager

A comprehensive web-based finance management system built with Laravel for tracking income, expenses, and financial transactions.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0-38B2AC?style=flat&logo=tailwindcss)

---

## 📋 Features

- **Dashboard Analytics**
  - Total Income, Expenses, and Net Balance
  - Category-wise breakdown
  - Monthly trends chart
  - Recent activity overview

- **Transaction Management**
  - Record income and expenses
  - Categorize transactions
  - Edit and delete transactions
  - View transaction history

- **User Management**
  - Role-based access control
  - Multiple user roles (Admin, User, etc.)
  - Permission-based actions

- **Data Export**
  - Export to Excel, PDF, CSV
  - Print-friendly reports
  - Search and filter functionality

- **Responsive Design**
  - Mobile-friendly interface
  - Modern TailwindCSS UI
  - Smooth animations

---

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Git

### Step-by-Step Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
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
   
   Update `.env` file with your database credentials:
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

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Create admin user** (if seeder exists)
   ```bash
   php artisan db:seed
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
│   │   ├── Controllers/     # TransactionController, UserController, etc.
│   │   └── Middleware/
│   ├── Models/              # Transaction, User, Role
│   └── ...
├── resources/
│   ├── views/
│   │   ├── layouts/         # Header, Footer
│   │   ├── dashboard/       # Dashboard views
│   │   ├── transactions/    # Transaction CRUD views
│   │   └── users/           # User management views
│   └── js/
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/
    └── web.php
```

---

## 🔐 Default Credentials

After running the seeder, you can login with:

| Role  | Email              | Password |
|-------|--------------------|----------|
| Admin | admin@gmail.com  | Success2026$ |

> ⚠️ **Change default credentials immediately in production!**

---

## 📊 Database Schema

### Transactions Table
| Column           | Type         | Description              |
|------------------|--------------|--------------------------|
| id               | bigint       | Primary key              |
| user_id          | bigint       | Foreign key to users     |
| type             | enum         | 'income' or 'expense'    |
| amount           | decimal      | Transaction amount       |
| category         | string       | Category name            |
| transaction_date | date         | Date of transaction      |
| description      | text         | Optional notes           |
| created_at       | timestamp    | Record creation time     |
| updated_at       | timestamp    | Record update time       |
| deleted_at       | timestamp    | Soft delete timestamp    |

---

## 🛠️ Available Commands

```bash
# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run development server
php artisan serve

# Build assets (development)
npm run dev

# Build assets (production)
npm run build

# Run tests
php artisan test
```

---

## 🔒 Permissions & Roles

The application uses Spatie Permission package for role-based access control.

### Available Permissions

| Permission              | Description                    |
|-------------------------|--------------------------------|
| Dashboard-View          | Access dashboard               |
| Transaction-Index       | View transactions              |
| Transaction-Create      | Create new transaction         |
| Transaction-Edit        | Edit transactions              |
| Transaction-View        | View single transaction        |
| Transaction-Delete      | Delete transactions            |
| UserManagement-Index    | View users                     |
| UserManagement-Create   | Create new user                |
| UserManagement-Edit     | Edit users                     |
| UserManagement-Delete   | Delete/Deactivate users        |

---

## 🎨 Technologies Used

| Technology     | Purpose                    |
|----------------|----------------------------|
| Laravel 11     | Backend Framework          |
| TailwindCSS    | Styling                    |
| jQuery         | DOM Manipulation           |
| DataTables     | Table with sorting/export  |
| Chart.js       | Analytics charts           |
| Font Awesome   | Icons                      |
| Spatie Permission | Role & Permission management |

---

## 📝 API Endpoints

*(If API is implemented)*

| Method | Endpoint              | Description           |
|--------|-----------------------|-----------------------|
| GET    | /api/transactions     | Get all transactions |
| POST   | /api/transactions     | Create transaction   |
| GET    | /api/transactions/{id}| Get single transaction|
| PUT    | /api/transactions/{id}| Update transaction   |
| DELETE | /api/transactions/{id}| Delete transaction   |

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
- Ensure database server is running
- Verify database exists

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

For support, email **support@example.com** or create an issue in the repository.

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com)
- [TailwindCSS](https://tailwindcss.com)
- [DataTables](https://datatables.net)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)

---

<p align="center">Made with ❤️ using Laravel</p>
