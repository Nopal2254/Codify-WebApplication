# Codify — Онлайн Билим Берүү Платформасы

## 📋 Проект жөнүндө
Codify — Coursera/Udemy стилиндеги онлайн курс платформасы.
Laravel 11 + PostgreSQL + Bootstrap 5 менен жасалган.

## 🛠 Технологиялар
- **Backend:** PHP 8.4, Laravel 11
- **Database:** PostgreSQL 18
- **Frontend:** Bootstrap 5, Alpine.js, Tailwind CSS
- **Auth:** Laravel Breeze

## 👥 Колдонуучу роллору
| Роль | Email | Password |
|------|-------|----------|
| Admin | admin@edu.com | admin123 |
| Мугалим | teacher@edu.com | admin123 |
| Студент | student@edu.com | admin123 |

## 🗄 Маалымат базасы таблицалары
- users — Колдонуучулар
- categories — Категориялар
- courses — Курстар
- lessons — Сабактар
- enrollments — Жазылуулар
- reviews — Пикирлер
- announcements — Жарыялар
- contacts — Байланыштар

## 🚀 Орнотуу

### Талаптар
- PHP 8.2+
- PostgreSQL
- Composer
- Node.js

### Кадамдар

```bash
# 1. Жүктөп ал
git clone / zip ачып ал

# 2. Dependency орнот
composer install
npm install && npm run build

# 3. .env даярда
cp .env.example .env
php artisan key:generate

# 4. .env өзгөрт
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=eduplatform
DB_USERNAME=өзүңдүн_username
DB_PASSWORD=

# 5. Database түзүп migrate кыл
php artisan migrate:fresh --seed

# 6. Storage link
php artisan storage:link

# 7. Сервер баштат
php artisan serve
```

## 📱 Беттер
- `/` — Башкы бет
- `/login` — Кирүү
- `/register` — Катталуу
- `/forgot-password` — Паролду калыбына келтирүү
- `/admin/courses` — Курстар (Admin)
- `/admin/categories` — Категориялар (Admin)
- `/admin/announcements` — Жарыялар (Admin)
- `/admin/users` — Колдонуучулар (Admin)
- `/admin/contacts` — Байланыштар (Admin)

## ✅ Өзгөчөлүктөр
- Толук CRUD операциялары
- Роль негизиндеги мүмкүндүк
- Responsive дизайн
- Файл жүктөө
- Flash билдирүүлөр
# Codify-WebApplication
