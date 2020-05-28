1. Run <code>composer install</code>;

2. Run <code>npm install</code>;

3. Configure .env file ;

4. Run <code>php artisan key:generate</code>;

5. Change connection to DB in .env;

6. Run <code>php artisan migrate</code>;

7. Run <code>php artisan serve</code>;

8. Run <code>npm run watch</code>;

## После загрузки CSV файла, необходимо выполнить:
<code>php artisan queue:work</code>
## Затем начнется загрузка данных из файла.

## Routes: 
<p>/api/get-data - получить все данные из таблицы import_data (GET)</p>
<p>/api/import-data - загрузки файла, принимает параметр file (POST)</p>
<p>/api/find-zip - получение данных по зип коду (точное вхождение), принимает параметр zip (POST)</p>
<p>/api/find-city - получение данных по городу (частичное совпадение по 2м и более буквам в названии города), принимает параметр city (POST)</p>