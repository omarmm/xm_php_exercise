PHP (Laravel) Application to get Historical data "opens and closes prices" for companies , integrated with RapidApi.
```
1- composer install
Please copy .env.example file and add "X_RAPIDAPI_KEY" to .env file :
2- cp .env.example .env

- I'm using two ways to get Companies symbols:
    a- saving a JSON file.
    b- storing it to SQLite DB so that I can apply server-side search and pagination with Select2 compo box.
 So, you don't need to wait for storing Symbols to database process to finish (fetch:symbols),
 you can test it since it reads from a JSON file by default.

3- php artisan migrate

- fetch:symbols  command is updating "companies_sumbols.json" file then create new symbols in the database if not exist:

4- php artisan fetch:symbols
5- npm install && npm run dev
6- php artisan serve

```

