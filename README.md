<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About the project

There are many tier list websites out there, but most of them use a simple drag and drop API. I have found that generally that leaves a lot of room for interpretation when grading items and people might disagree with other lists simply because they used different crtieria.

This app seeks to remedy that, by instead implementing a formula based system, where items will be graded by score.

Each template has a set number of rows, items and a static formula.

The application itself is rather bland featureless, also html2canvas was refusing to cooperate so resulting screenshots might not always turn out the way you would expect them to.

Built using `Laravel 8.40.0`, `PHP 8.0.3`, `Composer 2.0.12`, `Node 14.15.5`, `npm 6.14.11`.

## How to run

1. Clone the repo

`$ git clone https://github.com/RaresGeo/LaravelTierlist.git`

2. cd into the project

`cd LaravelTierlis`

3. Install dependancies

For Composer run `composer install`
You might have to go into your `php.ini` file and enable a few extensions, such as GD

For the node package manager run `npm install` or `yarn`

4. Create a .env file

Due to potentially sensitive data being stored within them, .env files are usually gitignored; however, there is an example file which you can copy

`cp .env.example .env`

You will then have to fill in the necessary info, such as the database config

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=password123
```

or your app encryption key, which you can generate with `php atisan key:generate` *this will automatically also place the key in .env*

5. Create a database

After you are done, fill in the name in .env, under this field: `DB_DATABASE=test`

6. Migrate with `php artisan migrate`

If necessary, you can roll back the migrations with `php artisan migrate:rollback`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
