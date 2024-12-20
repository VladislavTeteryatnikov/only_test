# only_test
___

### Тестовое задание: 
Данный проект - тестовое задание от digital-агенства Only
___
### Реализация:

Выполнил задание с использованием шаблона MVC на чистом php. Для стилей использовал фреймворк bootstrap.
___
### Развернуть проект:
1. Клонировать проект
```gitexclude
git clone https://github.com/VladislavTeteryatnikov/only_test.git
```
2. Импортировать базу данных из файла *assets/database/only_test.sql*
3. Настроить доступ к БД в файле *configs/db.php*
4. В файле *configs/constants.php* указать SITE_ROOT

Например:
```php
define("SITE_ROOT", "/only_test/");
```
___
### Нюансы:
Не делал валидацию данных, поступающих от пользователя из формы
___