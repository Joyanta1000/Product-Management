# Project Setup Guide

This project consists of a **Vue.js** frontend and a **Laravel** backend. Follow the steps below to set up both the frontend and backend for development.

## Frontend (Vue.js)

Follow the steps below to set up the Vue.js frontend:

1. **Install Dependencies**

   Install the necessary npm dependencies by running the following command:

   npm install

2. **Run Development Server**

   npm run dev

## Backend (Laravel)

Follow the steps below to set up the Laravel backend:

1. **Install Dependencies**
   Install the required PHP dependencies for Laravel:

   composer install

3. **Copy .env.example to .env**

   cp .env.example .env

4. **Generate the Application Key**

   Generate the application key for Laravel and set it in the .env file:

   php artisan key:generate

6. **Create a Storage Symlink**

   Create a symbolic link to store files publicly:

   php artisan storage:link

7. **Run Migrations**

   php artisan migrate

8. **Start the Laravel Development Server**

   php artisan serve
