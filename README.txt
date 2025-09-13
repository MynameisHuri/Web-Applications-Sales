**Sales Web Application / Olorosisimo, Marc Huri A.

Installation Instructions

1. Requirements
    - PHP 7.x or higher
    - MySQL 5.x or higher
    - Web server (XAMPP, WAMP, MAMP, etc.)
    - Browser (Chrome, Edge, Firefox recommended)

2. Setup Steps

    1. Place the submission folder in your web server’s root directory (e.g., htdocs for XAMPP).
    2.Import the database:
        - Open phpMyAdmin or your MySQL client.
        - Create a new database (e.g., exam_db).
        - Import the provided SQL dump file (database_dump.sql).

    3. Update the database connection:
        - Open db.php.
        - Ensure the $servername, $username, $password, and $dbname variables match your environment.

3. Accessing the Application
    - Open your browser and navigate to:
        http://localhost/olorosisimo_huri_takehome_exam/index.php
    - Use the provided interface to manage items, inventory, sales, and reports.

FEATURES
    - Items Maintenance – Add, update, delete items with price details.
    - Inventory Management – Track stock quantities; add new stock.
    - Sales Transactions – Add sales; automatically update inventory.
    - Sales Reports – View sales per item with line graph; filter by item and date.
    - Modals – All actions are done via modals for a clean interface.

NOTES
    - Make sure JavaScript is enabled in your browser.
    - Chart.js library is included via CDN; ensure internet connection when viewing reports.
    - All pages use assets/style.css and assets/script.js for styling and interactivity.
    - Do not include node_modules or other package manager directories.