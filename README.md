<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



Here's a comprehensive `README.md` and `.dockerignore` file for your Laravel 10 Docker project:

### README.md

```markdown
# Laravel 10 Docker Project

A Dockerized Laravel 10 application running on Ubuntu with Nginx, PHP 8.2, MySQL, and Redis.

## Prerequisites

- Docker Engine 20.10+
- Docker Compose 1.29+
- Git (optional)

## Project Structure

```
.
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       └── php.ini
├── docker-compose.yml
├── Dockerfile
├── start.sh
└── .dockerignore
```

## Authentication Credentials

### Super Admin Access
- **Email:** admin@jumuiya.com
- **Password:** password
- **Role:** Super Administrator

### Other Test Users

1. Additional Admins:
   - admin2@jumuiya.com (password: password)
   - admin3@jumuiya.com (password: password)

2. Chairpersons:
   - peterchair@jumuiya.com (St. Peter Jumuiya)
   - paulchair@jumuiya.com (St. Paul Jumuiya)
   - marychair@jumuiya.com (St. Mary Jumuiya)
   - johnchair@jumuiya.com (St. John Jumuiya)
   All with password: password

3. Members:
   - 5 members per Jumuiya (20 total)
   - Email format: stpetermember1@jumuiya.com (for St. Peter members)
   - Email format: stpaulmember1@jumuiya.com (for St. Paul members)
   - And so on...
   All with password: password

## Getting Started

1. Clone the repository:
   ```bash
   git clone [your-repo-url]
   cd your-project
   ```

2. Build and start the containers:
   ```bash
   docker-compose up -d --build
   ```

3. Install PHP dependencies:
   ```bash
   docker-compose exec app composer install
   ```

4. Generate application key:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

5. Run database migrations:
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. Install Node.js dependencies:
   ```bash
   docker-compose exec node npm install
   ```

7. Compile assets:
   ```bash
   docker-compose exec node npm run dev
   ```

## Accessing the Application

- Web application: http://localhost:8000
- MySQL: `localhost:3306` (user: `root`, password: `secret`)
- Redis: `localhost:6379`

## Services

- **app**: Laravel application with PHP 8.2 and Nginx
- **mysql**: MySQL 8.0 database
- **redis**: Redis server
- **node**: Node.js 18 for frontend assets

## Useful Commands

- Stop containers:
  ```bash
  docker-compose down
  ```

- View logs:
  ```bash
  docker-compose logs -f
  ```

- Run artisan commands:
  ```bash
  docker-compose exec app php artisan [command]
  ```

- Run npm commands:
  ```bash
  docker-compose exec node npm [command]
  ```

- Enter container shell:
  ```bash
  docker-compose exec app bash
  ```

## Configuration

- Nginx config: `docker/nginx/default.conf`
- PHP config: `docker/php/php.ini`
- Environment variables: Edit `docker-compose.yml`

## Production Considerations

1. Change `APP_DEBUG=false` in environment variables
2. Set proper database credentials
3. Configure proper SSL certificates
4. Use `npm run prod` for production assets

## WhatsApp Notifications

The system supports sending notifications via WhatsApp to Jumuiya members. This feature allows chairpersons to send notifications both in-app and through WhatsApp.

### Configuration

1. Add these environment variables to your `.env` file:
```bash
WHATSAPP_API_BASE_URL=your_whatsapp_api_url
WHATSAPP_API_KEY=your_whatsapp_api_key
```

2. Configure your queue worker for WhatsApp notifications:
```bash
php artisan queue:work
```

### How It Works

1. **Creating Notifications**
   - Chairpersons can create notifications from their dashboard
   - Option to enable WhatsApp delivery using a checkbox
   - Can select all members or specific members to notify

2. **Notification Types**
   - General notifications
   - Alerts
   - Reminders
   - Updates

3. **Features**
   - Asynchronous message delivery via queue
   - Automatic phone number formatting
   - Failure handling and retries
   - Message delivery tracking
   - Support for both individual and group messages

4. **Requirements**
   - Members must have valid phone numbers recorded
   - WhatsApp Business API credentials
   - Active queue worker for processing notifications

### Usage Example

As a chairperson:
1. Go to Notifications > Create New
2. Fill in the notification details
3. Check "Also send as WhatsApp message"
4. Select recipients
5. Click "Send Notification"

The system will:
- Send in-app notifications immediately
- Queue WhatsApp messages for delivery
- Track delivery status
- Handle any failures automatically
```

### .dockerignore

```
# Ignore everything by default
*

# Allow these files and directories
!docker/
!docker-compose.yml
!Dockerfile
!start.sh

# Laravel specific exceptions
!.env
!composer.json
!composer.lock
!package.json
!package-lock.json
!artisan
!server.php
!webpack.mix.js
!vite.config.js
!bootstrap/
!config/
!database/
!public/
!resources/
!routes/
!storage/
!app/
!tests/

# Development files to ignore
.git/
.gitignore
.idea/
.vscode/
*.md
*.txt
*.log
*.sql
*.env.local
*.env.testing
*.env.production
node_modules/
vendor/
storage/debugbar/
storage/logs/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/
public/storage
public/hot
```

### Key Files to Include in Your Project

1. **Essential Files**:
   - `docker-compose.yml`
   - `Dockerfile`
   - `start.sh`
   - `docker/nginx/default.conf`
   - `docker/php/php.ini`
   - `.dockerignore`

2. **Laravel Files**:
   - `.env` (create from `.env.example`)
   - `composer.json` and `composer.lock`
   - `package.json` and `package-lock.json`
   - All Laravel directories (`app/`, `config/`, `routes/`, etc.)

### Why This Setup Works Well

1. **Security**: The `.dockerignore` prevents sensitive files and development artifacts from being copied into the container
2. **Performance**: Only necessary files are included in the Docker build context
3. **Clarity**: The README provides clear setup instructions and common commands
4. **Maintenance**: Well-organized configuration files make it easy to update settings
5. **Environment Separation**: Different configurations for development vs production

Remember to:
1. Create your `.env` file from `.env.example` before starting
2. Adjust memory limits in `php.ini` based on your server resources
3. Update database credentials in both `.env` and `docker-compose.yml` for production



how ur csv should look

name,email,jumuiya_id,phone,status,joined_date
John Doe,john@example.com,1,1234567890,active,2023-04-25
Jane Smith,jane@example.com,2,0987654321,inactive,2023-04-20
```
