1. За основу взят проект "jwt_laravel_vue_back"

2. Создана заготовка роутов и методов

3. Установка пакета сваггер: `composer require "darkaonline/l5-swagger"`

- выполняем `php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"`
- генерируем документацию: `php artisan l5-swagger:generate`

- По дефолту сваггер не заработал:
- пришлось генерить и читать файл api-docs.json из директории "storage/app/public"
- в l5-swagger.php прописал: 'docs' => storage_path('app/public'),
- в index.blade.php прописал: url: "http://127.0.0.1:8000/storage/api-docs.json"

- Плюс скопировал ассеты из вендора в /public/docs/asset

- сделано описание для одного роута GET

4. Написана аннотация для метода POST.
