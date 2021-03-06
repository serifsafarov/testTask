
```
cd docker // переходим в директорию docker

docker-compose build   собрать

docker-compose up  запустить  // docker-compose up  -d  запуск в демоне

docker-compose down  остановить 
```

*-d* в демоне

зайти в контейнер Mysql

```
docker exec -it mysql bash
```

Создать базу данных (если не запускался раньше)

```
mysql -h "localhost" -u "root" "-p2t9k51hP" < "/mysql/scripts/create_db.sql"
```

зайти в контейнер Laravel

```
docker exec -it php bash
```

Запустить composer (если не запускался раньше)

```
php composer.phar update
```

Очистить кеш приложения (если не запускался раньше)

```
php artisan config:cache
```

Запустить миграции (если не запускался раньше)

```
php artisan migrate:fresh --seed
```

Запустить необработанные призы (если по какой-то причине они не обработались в очереди)

```$xslt
php artisan prizes:proceed
 или 
php artisan prizes:proceed <кол-во призов>
```

Запустить тесты

```$xslt
php artisan test
```

зайти в контейнер Nuxt

```
docker exec -it nuxt bash
```

Запустить npm install (если не запускался раньше)

```
npm install
```

Запустить nuxt сервер

```
npm run dev
```

Просмотреть запущеные

```$xslt
docker ps
```

###Приложение доступно по адресу localhost:27001

