# Laracasts Forum [![Build Status](https://travis-ci.org/poymanov/forum.svg?branch=master)](https://travis-ci.org/poymanov/forum)

Учебное приложение на основе уроков [https://laracasts.com/series/lets-build-a-forum-with-laravel](https://laracasts.com/series/lets-build-a-forum-with-laravel)

## Описание

Приложение реализует функционал форума.

Пользователи могут:

* Регистрироваться и авторизовываться
* Создавать сообщения
* Оставлять комментарии к сообщениям других пользователей
* Добавлять сообщения и комментарии в избранное
* Осущеставлять поиск по форуму


## Установка

Удобнее всего запустить проект с помощью [Laravel Homestead](https://github.com/poymanov/laravel-homestead-how-to)

В случае самостоятельной настройки понадобятся:

- PHP >= 7.1.3
- nginx/Apache
- MySQL/PostgreSQL/MariaDB
- NodeJS & npm
- Redis
- Composer

## Настройка

Параметры приложения задаются в файле `.env`. Его необходимо создать из файла с тестовой конфигурацией:

```
cp .env.example .env.
```
---

### Основные

Название приложения:
```
APP_NAME=Laravel
```

Адрес приложения:

```
APP_URL=http://localhost
```

Окружение в котором будет запущено приложение (local/production):

```
APP_ENV=local
```

---

### БД

По-умолчанию указаны переменные для настройки работы с mysql:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

---

### Redis

```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

### Google ReCaptcha

Получить данные для работы с ReCaptcha - https://www.google.com/recaptcha/intro/android.html

```
RECAPTCHA_KEY=
RECAPTCHA_SECRET=
```

Можно использовать тестовые данные:

```
RECAPTCHA_KEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
RECAPTCHA_SECRET=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
```

---

### Algolia

Algolia - сервис для полнотекстового поиска на основе поисковых индексов.
Получить данные для работы - https://www.algolia.com/

```
ALGOLIA_APP_ID=
ALGOLIA_SECRET=
ALGOLIA_KEY=
```


После заполнения параметров в директории проекта необходимо выполнить команды:

```
composer install
npm run dev
```

Проект готов к запуску.
