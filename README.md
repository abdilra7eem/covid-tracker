# COVID Tracker

A web based application for tracking COVID-19 cases at schools. It has authentication, strict validation, input sanitization, built in vertical (based on access level) and horizontal (based on school & directory) seperation, read and write access control, case history tracking. It also covers full and partial closures, and the different types of closures based on class, school & directorate.

This is a minimum viable product in an almost production-ready state. It's in Arabic, though, and needs i18n (See `What's Missing?` section below).

برنامج لتتبع حالات كورونا (كوفيد 19) في المدارس. يتضمن البرنامج استيثاق المستخدمين، وتحققًا من المدخلات، وتطهير المدخلات، وفصلًا هرميًّا للبيانات والصلاحيات (عمودياً حسب مستوى الوصول وأفقيًا حسب المدرسة والمديرية) وتحكمًا في الوصول (للقراءة والكتابة) وتتبعًا لتاريخ سجلات الحالة. كما ويشمل البرنامج تتبع الإغلاقات الجزئيًا والكلياً، والأنواع المختلفة من الإغلاقات (شعبة صفية أو مدرسة أو مديرية).

هذا البرنامج يحقق الحد الأدنى من المتطلبات اللازمة، وتلزمه لمسات بسيطة ليكون جازًا للاستخدام على أرض الواقع.

## Technology Stack

This application uses the following technologies:

- PHP 7
- Laravel 7
- JavaScript (ES6)
- Bootstrap 4
- SASS
- MySQL / MariaDB

It also needs a web server for use in production.
It was tested on Linux, Nginx, PHP 7, FireFox & Chrome.

## Security

- Authentication
- Strict access control
- Input validation
- Input sanitization
- SQL injection mitigation
- Minimum external dependencies
- throttling (to avoid abuse & DoS).

## What's missing ?

Suggested improvements:
- Cache (e.g.: using Redis).
- API for external integrations & for Vue.
- Vue for client side rendering (less server load & better performance for heavy use).
- Internationalization (i18n) & Localisation (l10n).
- Make better/easier setup experience.

## How to deploy

1. `git clone` this repo
1. Install dependencies:
    - `composer install`
    - `npm install`
1. Set environment configurations (copy/rename .env.example to .env, and edit it).
1. Run migrations: `php artisan migrate`
1. Create an admin manually (Check the seeders for hints), or populate with random data using the seeders (`php artisan db:seed`).

You may need to configure you web server (if any) and enable rewrites. You may also need to create a new App_key and relink storage. For more information on deploying a Laravel application, please refer to [Laravel Documentation](https://laravel.com/docs/7.x/).

## Learning Laravel

- [documentation](https://laravel.com/docs).
- [Laracasts](https://laracasts.com).

## License

COVID Tracker and all of its files and designs (unless stated otherwise) are open-sourced software licensed under the GNU Affero GPL, including all commits & history of this repository.

هذا البرنامج بما في ذلك كل الملفات التابعة له والتصاميم المتعلقة به (ما لم يذكر غير ذلك صراحة) هي برمجيات مفتوحة المصدر وفقًا لترخيص `GNU Affero GPL`)، بما في ذلك جمع ال `commits` وتاريخ هذا `repository`.

    ```
    Copyright (C) <2020> <Abdalrahim Fakhouri>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
    ```

## Contact

Please feel free to open a ticket in the issues section on Github, or contact me directly by email. My email is the same as my name here on Github, and it's on Gmail.
