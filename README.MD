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

Установить **docker** и **docker-compose**

Выполнить:
```
make init
```

## Запуск

```
make up
```

Приложение доступно по адресу - http://localhost:8080

Просмотр почтовых уведомлений - http://localhost:8081

## Настройка

### Google ReCaptcha

Получить данные для работы с ReCaptcha - https://www.google.com/recaptcha/intro/v3.html

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

## Тестирование

Тесты расположены в директории `tests`

Для запуска, в директории проекта, выполнить команду:

```
make test
```
