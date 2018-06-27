# Решение тестового задания для Clickadu

## Требования перед использованием
Я использовал для разработки, тестирования и запуска Docker, но вы можете использовать и локальный сервер с php 7.1 и MySQL 5.7.

В случае использования Docker следует выполнить
```
docker-compose build
docker-compose up -d
```
Перед началом использования следует проимпортировать в MySQL файл setup.sql и запустить установку проекта композером

## Выполнение команды

Точкой входа в проект является файл run.php. Для запуска необходимо указать 4 параметра: каталог с файлами (можно указывать как относительный, так и абсолютный путь), хост базы данных (по умолчанию будет использован localhost), имя базы, имя пользователя и пароль для подключения к базе.
Пример команды для запуска
```
php run.php -dir=files -h=db -n=clickadu -u=user -p=password
``` 

После запуска будут произведены следующие действия:
- Скрипт найдёт все файлы в указанной директории и её сабдиректориях, которые подходят под заданные параметры;
- Прочитает эти файлы построчно, записав корректные строки в промежуточный файл tmp.csv;
- Загрузит tmp.csv в таблицу data в указанной базе данных;
- Агрегирует данные из таблицы data в таблицу aggregation; 
- Выгрузит данные из таблицы по 10000 строк и запишет в файл result.csv в корне проекта (на данный момент будет наблюдаться максимальная нагрузка по памяти на систему, она составит порядка 10мб, в остальных случаях нагруза не превышает мегабайта).

Скрипт написан так, что в любой момент можно добавить использование любых других типов файлов с другой логикой агрегации.

## Тесты

Тесты лежат в директории tests и могут быть запущены phpunit'ом