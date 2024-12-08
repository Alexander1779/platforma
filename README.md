<h1 align="center">Тестовое задание</a>
<p> чтобы установить необходимо выполнить:</p>
<p><code>git clone https://github.com/Alexander1779/platforma.git </code></p>
<p><code>cd platforma</code></p>
<p><code>composer install</code></p>
<p><code>cp .env.example .env</code></p>
<p>отредактировать файл .env</p>
<p><code>DB_CONNECTION=sqlite</code></p>
<p><code># DB_HOST=127.0.0.1</code></p>
<p><code># DB_PORT=3306</code></p>
<p><code>DB_DATABASE=laravel</code></p>
<p><code>DB_USERNAME=admin</code></p>
<p><code>DB_PASSWORD=admin</code></p>
<p><code>DB_ROOT_PASSWORD=root</code></p>
<p>Запускаем docker</p>
<p><code>docker compose -f ./deploy/docker-compose.yml --env-file ./.env up --build</code></p>
<p>Выполняем миграции</p>
<p><code>docker exec -t testapp php artisan migrate</code></p>
<p>Наполняем данными</p>
<p><code>docker exec -t testapp php artisan db:seed</code></p>
