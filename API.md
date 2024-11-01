# Тех. Документация к API

## Описание методов

## Адрес домена

```
http://localhost
(api.site.com)
```

## Структуры данных

* Успешный ответ

```
CorrectAnswer = {
    message : 'message'
}

```

* Ошибка

```
WrongAnswer = {
    error : 'error'
}

```

## Метод book

### Описание метода

* Метод осуществляет бронирование заказа.

### Адрес

```/book```

### Параметры запроса

| параметр               | тип     | комментарий                                         |
|------------------------|---------|-----------------------------------------------------|
| event_id               | int     | ID события                                          |
| event_date             | varchar | Дата и время на которое были куплены билеты         |
| ticket_adult_price     | int     | Цена взрослого билета на момент покупки             |
| ticket_adult_quantity, | int     | Количество купленных взрослых билетов в этом заказе |
| ticket_kid_price       | int     | Цена детского билета на момент покупки              |
| ticket_kid_quantity    | int     | Количество купленных детских билетов в этом заказе  |

## Верный ответ

```
CorrectAnswer => 'order successfully booked'
```

### Ошибки

```
WrongAnswer('barcode already exists')
```

## Метод approve

### Описание метода

* Подтверждает заказ по barcode.

### Адрес

```/approve```

### Параметры запроса

| параметр | тип     | комментарий                            |
|----------|---------|----------------------------------------|
| barcode  | varchar | Уникальный barcode билета. 13 символов |

## Верный ответ

```
CorrectAnswer => 'order successfully aproved'
```
В случае успеха заказ сохраняется в базу данных

### Ошибки

```
WrongAnswer('event cancelled')
WrongAnswer('no tickets')
WrongAnswer('no seats')
WrongAnswer('fan removed')
```