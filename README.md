<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About the project

There are many tier list websites out there, but most of them use a simple drag and drop API. I have found that generally that leaves a lot of room for interpretation when grading items and people might disagree with other lists simply because they used different crtieria.

This app seeks to remedy that, by instead implementing a formula based system, where items will be graded by score.

Each template has a set number of rows, items and a static formula.

The application itself is rather bland featureless, also html2canvas was refusing to cooperate so resulting screenshots might not always turn out the way you would expect them to.

Built using `Laravel 8.40.0`, `PHP 8.0.3`, `Composer 2.0.12`, `Node 14.15`, `npm 6.14.11`.

## How to run

Everything is containerised, the only prerequisite to running this is `docker` and optionally `make` for ease of use

```
make dev-up

# Or without make
# Start up the composer workspace
docker compose up -d workspace
# Set up project and create /vendor
docker compose exec -T workspace composer install --no-interaction --no-progress --prefer-dist
# Start all other services
docker compose up -d
# Run db migrations
docker compose exec -T workspace php artisan migrate --force
```

OPTIONAL: generate a new app encryption key with `php atisan key:generate` *this will automatically also place the key in .env*

5. Create a database

After you are done, fill in the name in .env, under this field: `DB_DATABASE=test`

6. Migrate with `php artisan migrate`

If necessary, you can roll back the migrations with `php artisan migrate:rollback`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
