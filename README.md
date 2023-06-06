<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to run:

1. Clone the repository to your local machine:
   git clone https://github.com/danykrass/ox.git.git

2. Navigate to the project directory:
   cd <your-repository>

3. Create a `.env` file in the root directory of the project based on the `.env.example` file. 
Fill in your database information in the `.env` file.

4. Install the PHP dependencies using Composer and the JavaScript dependencies using npm:
   `composer install`
   `npm install`

5. Generate the application key:
   `php artisan key:generate`

6. Create a symbolic link for storing files:
   `php artisan storage:link`

7. Cache the configuration for faster application loading:
   `php artisan config:cache`

8. Run the database migration and seed it with test data:
   `php artisan migrate --seed`

9. Build the JavaScript and CSS assets:
   `npm run build`

10. Start the Laravel development server:
   `php artisan serve`

Once you have completed these steps, your Laravel + Vue project should be up and running. You can access it by navigating to the URL provided in the output of the `php artisan serve` command.
