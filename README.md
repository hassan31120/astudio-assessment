📌 Project Name: Laravel EAV API
Setup Instructions
Clone the repository

bash
Copy
Edit
git clone https://github.com/YOUR_GITHUB_USERNAME/laravel-eav-api.git
cd laravel-eav-api
Install dependencies

bash
Copy
Edit
composer install
Create and configure .env file

bash
Copy
Edit
cp .env.example .env
Generate the application key

bash
Copy
Edit
php artisan key:generate
Configure the database
Update .env with your database details:

makefile
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_eav
DB_USERNAME=root
DB_PASSWORD=
Run Migrations & Seeders

bash
Copy
Edit
php artisan migrate --seed
Install Laravel Passport

bash
Copy
Edit
php artisan passport:install
Start the development server

bash
Copy
Edit
php artisan serve
