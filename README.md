# Blogging Platform
---

### Install Dependencies
- Open your terminal and navigate to the project's root directory.
- Run the following command to install the necessary PHP dependencies: `composer install`

### Create .env file
- Copy the example environment file (.env.example) to create a new .env file: `cp .env.example .env`

### Generate the Application Key
- Generate one using: `php artisan key:generate`

### Configure .env file
```
DB_CONNECTION=mysql
DB_HOST=YOUR_HOST
DB_PORT=YOUR_PORT
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USERNAME
DB_PASSWORD=YOUR_DATABASE_PASSWORD

FILESYSTEM_DISK=public
```

### Run Migrations
- To create the necessary database tables, run the following command to apply the migrations: `php artisan migrate`

### Install Node.js Dependencies
- Run the following command to install node.js dependencies: `npm install`

### Create Symbolic Link
- Run the following command to create symbolic link: `php artisan storage:link`

### Compile Frontend Assets
- Run the following command to compile frontend assets: `npm run dev`

### Serve the Application
- Run the following command to serve the application locally: `php artisan serve`

---

## The application should be accessible via the local server (http://127.0.0.1:8000/).