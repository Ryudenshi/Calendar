## Calendar: "Tusk keeper"

Браузерний календар з нагадуваннями, призначений для розміщення на ньому нагадувань та подій у певні періоди часу для полегшення роботи.

## Інструкції для розвертання проекту

1. Склонуйте репозиторій: `git clone https://github.com/Ryudenshi/Calendar.git`.
2. Установіть залежності: `composer install`. 
3. Скопіюйте .env.example в .env та налаштуйте підключення до бази даних.
4. Запустіть міграції: `php artisan migrate`.
5. Запустіть локальний сервер: `php artisan serve`, або використайте сторонній локальний сервер. Я використовував Apache у XAMPP.
6. Запустіть інструмент складання `npm run dev`.

## Структура проекту

- `app/`: Код додатку;
- `config/`: Конфігураційні файли;
- `database/`: Міграції та фабрики;
- `resources/`: Шаблони та ресурси (css, js, views);
- `routes/`: Файли маршрутів.

## Не виконані пункти тестового завдання:

- панель користувача для зміни імені, ел. пошти та паролю;
- відправка повідомлень на елю пошту користувача через черги;
- не створені Factory для наповнення користувачів та подійдля них;
- не реальзована можливість підписки на телеграм бота та відправка ним повідомлень користувачеві.

## Виконані пункти тестового завдання:

- реєстрація та логінізація користувача з допомогою ел. пошти та пароля;
- календар з навігацією по місяцях з прив'язкою до реальної дати;
- можливість додавати, редагувати та видаляти події та нагадування;
- події та нагадування можна позначити як "виконані" надиснувши на них.