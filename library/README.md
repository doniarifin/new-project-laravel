# Laravel 8.0 Simple CRUD Library App

## Setup and Usage

1. Clone this repository.

2. Navigate to the application folder using the cd command in your command prompt or terminal.

3. Install dependencies by running the following command

   ```
   composer install && npm install && npm run dev
   ```

4. Duplicate the .env.example file and rename it to .env in the root directory:
   ```
   cp .env.example .env
   ```

5. Create a database with the name specified in the DB_DATABASE field of your .env file.

6. Execute the following commands:
    ```
    php artisan key:generate
    php artisan migrate
    php artisan serve