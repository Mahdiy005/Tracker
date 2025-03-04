<p style="height: 50px" align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/Mahdiy005/Tracker/blob/main/public/logo.png" width="400" alt="Laravel Logo"></a></p>


# Laravel Project Setup Guide

This guide will help you set up and run a Laravel project after cloning it from GitHub.

## 1️⃣ Clone the Repository

```sh
git clone https://github.com/Mahdiy005/Tracker.git
cd Tracker
```

## 2️⃣ Install Dependencies

Ensure you have **PHP**, **Composer**, and **Node.js** installed.

```sh
composer install
npm install  # If frontend assets are used
```

## 3️⃣ Set Up Environment Variables

Copy the `.env.example` file to `.env` and configure it.

```sh
cp .env.example .env
```

Then, generate the application key:

```sh
php artisan key:generate
```

## 4️⃣ Configure Database

Edit the `.env` file and set up the database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tracker
DB_USERNAME=root
DB_PASSWORD=
```

## 5️⃣ Run Migrations and Seed Database

Run database migrations:

```sh
php artisan migrate
```

If your project has seeders, run:

```sh
php artisan db:seed
```

Or run both together:

```sh
php artisan migrate --seed
```

## 7️⃣ Start the Server

Run the Laravel development server:

```sh
php artisan serve
```

Your application should now be running at `http://127.0.0.1:8000/`

## 8️⃣ (Optional) Run Vite for Frontend (if applicable)

If your project uses Vite for frontend assets:

```sh
npm run dev
```
