Yii 2 Library API
==================
Установка
===============================

Скачайте репозиторий

Выполните следующую команду в корне проекта:

```
php init
```

Обновите Composer:

```
composer update
```

Настройте подключение к БД в следующих файле:    

`
/commom/config/main-local.php
`

Выполнение миграций:
```
php yii migrate/up
```

Запуск тестового сервера
===============================
Чтобы запустить сервер выполните команду
```
php yii serve --docroot=@root --port=8081
```
После этого сайт будет доступен через  

http://localhost:8081/frontend/web/

http://localhost:8081/backend/web/

http://localhost:8081/api/web/


Тестирование API
===============================
**Проверка работоспособности**

```
curl -i -H "Content-Type:application/json" -XPOST "http://localhost:8081/api/web/" -d ''
```

Должен придти ответ - _API_



**Авторизация пользователя**




Имя пользователей - Пароль

erau - password_0


john - password_0







```
curl -i -H "Content-Type:application/json" -XPOST "http://localhost:8081/api/web/auth" -d '{"username":"erau","password":"password_0"}'
```

Должен прийти токен аутентификации

Копируем его и вставляем в заголовок запроса _"Authorization:Bearer ВАШ_ТОКЕН"_

**Взать книгу из библеотеки**

```
curl -i -H "Content-Type:application/json" -H "Authorization:Bearer ВАШ_ТОКЕН"  -XPOST "http://localhost:8081/api/web/library/take" -d '{"book_id":1}'
```

**Положить книгу обратно**

```
curl -i -H "Content-Type:application/json" -H "Authorization:Bearer ВАШ_ТОКЕН"  -XPOST "http://localhost:8081/api/web/library/return" -d '{"book_id":1}'
```

Запуск тестов
===============================
Сначала создайте новую **тестовую** базу данных 
и укажите ее в файле
`
/commom/config/test-local.php
`


Чтобы запустить тесты выполните команду




```
vendor/bin/codecept run
```
