PHP (Laravel) Application to get Historical data "opens and closes prices" for companies , integrated with RapidApi.
```
1- composer install
Please copy .env.example file and add "X_RAPIDAPI_KEY" to .env file :
2- cp .env.example .env

- I have used two ways to get Companies symbols  (a- saving a JSON file, b- storing it to Sqlelite DB so that I can apply server-side search and pagination with Select2 compo box)
3- php artisan migrate
4- php artisan fetch: symbols
5- npm install && npm run dev
6- php artisan serve

```

