<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About this app

This web application made in: \
**TALL** stack - **T**ailwind, **A**lpine.js, **L**aravel, _but (without Livewire)_

### This application made for learning purpose.

## Features
**You can expect functionalities like:**
- Full responsive (mobile friendly) design
- **Log in with a username or email address** + password
- You can manage your notes
- You can invite people
- You can see users public notes who under your hierarchy
- **Full-fledged JSON web REST API**
  - with full API Documentation
  - Link: <your-vhosts-name>/docs/

## Installation guide
1. Open a terminal
2. Clone this repository
```
git clone https://github.com/nfcrazyhun/laravelnotesproject.git
```
3. `cd` into it
4. Install dependencies
```
composer install
```
5. (Optional) Install npm packages and build Webpack
```
npm install
npm run dev
```
6. Copy then rename .env.example to .env
```
copy .env.example .env
```
7. Generate application key
```
php artisan key:generate
```
8. Create symbolic links
```
php artisan storage:link
```
9. Create a database
   1. Name: foxnotes
   2. (collation: utf8mb4_unicode_ci)

10. (Optional) Create a database for phpunit
    1. Name: foxnotes_test
    2. (collation: utf8mb4_unicode_ci)

11. Update database credentials in the .env 

12. Set up database tables (with demo data)
```
php artisan migrate:refresh --seed
```

13. Set up VirtualHost for the project (recommended)

### The application comes with default user.
- email: `admin@admin.com`
- password: `admin`

## Note
The project was made with the following software versions:
- PHP 8.1.5
- Laravel Framework 9.8.1
- Tailwind CSS 3.0.18
- Alpine.js 3.9.6
- node 16.13.2
- npm 8.1.2

Special thanks to **[Scribe](https://github.com/knuckleswtf/scribe)** \
for the excellent API documentation generator.

## Roadmap
- more refactors
- more tests

## Screenshots
(wip)
