# Laravel Blog App

A comprehensive Laravel web application for managing posts, users, and content with role-based access control.

## 🚀 Features

### Authentication & Authorization
- **User Registration & Login** - Secure authentication with Laravel Breeze
- **Role-Based Access Control** - Admin and regular user roles
- **Profile Management** - Users can update their profiles
- **Password Reset** - Email-based password reset functionality

### Content Management
- **Posts System** - Full CRUD operations for blog posts
- **Post Status** - Draft and published states
- **Rich Content** - Title, content, and status management
- **Author Attribution** - Posts are linked to their authors

### User Management (Admin Only)
- **User Listing** - View all users with statistics
- **User Creation** - Add new users with role assignment
- **User Editing** - Update user information and roles
- **User Deletion** - Remove users (with safety checks)

### Dashboard & Analytics
- **Statistics Dashboard** - Post counts, user counts, and activity
- **Recent Posts** - Quick access to latest content
- **Quick Actions** - Direct links to common tasks
- **Responsive Design** - Works on all devices

## 🛠️ Technology Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Blade Templates with Tailwind CSS
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **Authentication:** Laravel Breeze
- **JavaScript:** Alpine.js for interactivity
- **Styling:** Tailwind CSS (via CDN)

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js (optional, for asset compilation)
- Web server (Apache/Nginx) or PHP built-in server

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone <your-repository-url>
   cd laravel-blog-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/path/to/your/database.sqlite
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   Open your browser and go to `http://localhost:8000`

## 🔑 Default Login Credentials

### Super Admin
- **Email:** `admin@example.com`
- **Password:** `password`

### Test User
- **Email:** `test@example.com`
- **Password:** `password`

## 📁 Project Structure

```
laravel-blog-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PostController.php
│   │   │   ├── UserController.php
│   │   │   └── Auth/
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   │       └── PostRequest.php
│   ├── Models/
│   │   ├── Post.php
│   │   └── User.php
│   └── Policies/
│       └── PostPolicy.php
├── database/
│   ├── migrations/
│   │   ├── create_posts_table.php
│   │   └── add_is_admin_to_users_table.php
│   └── seeders/
│       ├── SuperAdminSeeder.php
│       ├── PostSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── posts/
│       ├── users/
│       ├── layouts/
│       └── components/
└── routes/
    └── web.php
```

## 🔐 Security Features

- **CSRF Protection** - All forms are protected
- **SQL Injection Prevention** - Eloquent ORM with prepared statements
- **XSS Protection** - Blade template escaping
- **Authorization Policies** - Role-based access control
- **Input Validation** - Form request validation
- **Password Hashing** - Secure password storage

## 🎨 UI/UX Features

- **Modern Design** - Clean and professional interface
- **Responsive Layout** - Mobile-friendly design
- **Interactive Elements** - Dropdowns, modals, and animations
- **User Feedback** - Success/error messages
- **Loading States** - Visual feedback for actions
- **Accessibility** - Semantic HTML and ARIA labels

## 📊 Database Schema

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `is_admin` - Boolean admin flag
- `email_verified_at` - Email verification timestamp
- `created_at` / `updated_at` - Timestamps

### Posts Table
- `id` - Primary key
- `title` - Post title
- `content` - Post content
- `user_id` - Foreign key to users table
- `status` - Enum: 'draft' or 'published'
- `created_at` / `updated_at` - Timestamps

## 🔧 Customization

### Adding New Features
1. Create migrations for new tables
2. Add models with relationships
3. Create controllers with proper authorization
4. Add routes in `routes/web.php`
5. Create views in `resources/views/`
6. Update navigation if needed

### Styling
- Modify Tailwind classes in Blade templates
- Add custom CSS in `resources/css/app.css`
- Update Tailwind config in `tailwind.config.js`

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Configure your web server (Apache/Nginx)
3. Set up SSL certificate
4. Configure database for production
5. Run `php artisan config:cache`
6. Set proper file permissions

### Environment Variables
```env
APP_NAME="Ministry of Foreign Affairs Notification App"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the Laravel documentation

## 🔄 Version History

- **v1.0.0** - Initial release with authentication, posts, and user management
- **v1.1.0** - Added dashboard statistics and improved UI
- **v1.2.0** - Enhanced user management and role-based access

---

**Built with ❤️ using Laravel**
