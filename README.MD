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

В директории проекта необходимо выполнить команды:

```
composer install
npm run dev
```

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

---
