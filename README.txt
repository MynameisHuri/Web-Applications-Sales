Sales Web Application - README.txt

Project Overview:
This is a Laravel-based Sales Web Application that manages items, inventories, and sales reports. The system allows users to add, update, and delete items, view sales reports with graphs, and filter sales data by date or item.

Requirements:
1. PHP >= 8.x
2. Composer
3. MySQL / MariaDB
4. Node.js & NPM (optional, for compiling assets)
5. Web server (XAMPP, WAMP, or Laravel Sail)

Installation Instructions:

1. Clone or extract the project into your local development folder:
   e.g., C:\xampp\htdocs\sales_web_app

2. Install PHP dependencies:
   Open a terminal in the project folder and run:
   composer install

3. Copy the .env.example to .env:
   cp .env.example .env   (Linux/Mac)
   copy .env.example .env (Windows)

4. Configure your database in the .env file:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sales_web_app
   DB_USERNAME=root
   DB_PASSWORD=    

5. Import the database:
   Use the included 'sales_web_app.sql' file to import into your MySQL database (via phpMyAdmin or command line).

6. Generate application key:
   php artisan key:generate

7. (Optional) Compile front-end assets:
   npm install
   npm run dev

8. Serve the application:
   php artisan serve
   Access via: http://127.0.0.1:8000

Notes:
- Screenshots of the working application are in the 'screenshots' folder.
- Ensure your MySQL server is running before starting the application.
- Default user login is not required for this demo project (or mention if you have login credentials).
- For any errors related to missing packages, run 'composer install' again.

Contact:
For questions, contact Marc Huri A. Olorosisimo / 0915-416-9015