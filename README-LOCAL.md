# Запуск проекта локально (Windows / PowerShell)

Документ описывает минимальные шаги для запуска этого Laravel-проекта на чистой Windows-машине (PowerShell). Я описал два варианта подключения БД: PostgreSQL (рекомендуемый) и SQLite (быстрый тест без установки СУБД).

---
Требования
- PHP 8.2+ (рекомендуется 8.3 совместимо). Убедитесь, что php в PATH.
- Composer
- Node.js + npm (для сборки фронтенда, опционально — можно пропустить и использовать только сервер)
- PostgreSQL (рекомендуется) — либо используйте SQLite для локального теста
- Git (для клонирования репозитория)

Если у вас нет прав админа, вы всё ещё можете устанавливать в пользовательскую папку — просто настройте пути соответствующе.

---
1) Клонирование репозитория
Откройте PowerShell и выполните (пример):

```powershell
# перейти в папку, где хотите хранить проект
cd C:\Projects
# клонировать
git clone <репозиторий.git> seg-project
cd seg-project
```

Замените `<репозиторий.git>` на URL вашего репозитория (или просто скопируйте папки проекта вручную).

2) Установка PHP-зависимостей

```powershell
# установить зависимости PHP
composer install
```

Если composer не установлен, скачайте с https://getcomposer.org/ и поставьте в PATH.

3) Скопировать .env

```powershell
# если .env отсутствует
copy .env.example .env
# открыть .env в блокноте/VSCode для редактирования
code .env   # или notepad .env
```

Настройки .env, важные для локальной работы:
- APP_URL=http://127.0.0.1:8000
- SESSION_DOMAIN=        # оставить пустым
- DB_CONNECTION=pgsql    # или sqlite
- DB_HOST=127.0.0.1
- DB_PORT=5432
- DB_DATABASE=seg_db
- DB_USERNAME=your_pg_user
- DB_PASSWORD=your_pg_password

> Примечание: если используете встроенный PHP-сервер (php artisan serve) — поставьте APP_URL на http://127.0.0.1:8000 и оставьте SESSION_DOMAIN пустым, чтобы избежать 419 CSRF ошибок.

4) Подготовка базы данных — PostgreSQL (рекомендуемый)

- Установите PostgreSQL (https://www.postgresql.org/download/windows/).
- Запустите pgAdmin или psql и создайте базу и пользователя:

```powershell
# откройте psql или в pgAdmin создайте базу 'seg_db' и пользователя
# пример psql команды (в PowerShell, если psql в PATH):
psql -U postgres -c "CREATE DATABASE seg_db;"
psql -U postgres -c "CREATE USER seg_user WITH ENCRYPTED PASSWORD 'secret';"
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE seg_db TO seg_user;"
```

После этого в .env укажите DB_USERNAME=seg_user и DB_PASSWORD=secret

5) (Альтернатива) Быстрый запуск с SQLite (если не хотите ставить PostgreSQL)

```powershell
# создайте файл БД
New-Item -Path database\database.sqlite -ItemType File
# в .env установите
DB_CONNECTION=sqlite
DB_DATABASE=${PWD}\database\database.sqlite
# (приведите путь в Windows-формате, если нужно)
```

6) Генерация ключа и миграции

```powershell
# сгенерировать APP_KEY
php artisan key:generate
# запустить миграции
php artisan migrate
# (если требуются сиды, запустите их явно)
php artisan db:seed --class=RoleSeeder
# или одна команда (будьте осторожны с --force в prod)
# php artisan migrate --seed
```

Если миграции падают с ошибками про отсутствующие расширения, убедитесь, что в php.ini активированы расширения для БД (pdo_pgsql для PostgreSQL).

7) Установка JS-зависимостей и сборка (опционально для фронтенда)

```powershell
npm install
# Для разработки (горячая перезагрузка, vite/laravel mix и т.п.)
npm run dev
# Для production-статических сборок
npm run build
```

Если не планируете менять фронтенд сейчас, можно пропустить сборку — страницы всё равно будут работать, но стили/сборки зависят от наличия скомпилированных ассетов.

8) Права и link для storage

На Windows обычно не нужно изменять права, но желательно создать symlink для storage:

```powershell
php artisan storage:link
```

9) Запуск сервера

```powershell
# Запуск встроенного сервера Laravel
php artisan serve --host=127.0.0.1 --port=8000
# Или, если предпочитаете php -S
php -S 127.0.0.1:8000 -t public
```

Откройте в браузере: http://127.0.0.1:8000

10) Полезные команды для отладки

```powershell
# Очистить кэши (после изменения .env или конфигурации)
php artisan config:clear; php artisan route:clear; php artisan view:clear; php artisan cache:clear
# Просмотр логов
Get-Content -Path storage\logs\laravel.log -Tail 200 -Wait
```

11) Частые проблемы и решения
- 419 Page Expired (CSRF) при отправке форм:
  - Проверьте, что APP_URL установлен в `http://127.0.0.1:8000` и `SESSION_DOMAIN` пуст.
  - Очистите кэш конфигурации и сессии (описано выше).
  - Убедитесь, что браузер принимает cookies для localhost/127.0.0.1.

- Ошибка подключения к БД:
  - Проверьте настройки `DB_` в `.env`.
  - Убедитесь, что расширения PDO и драйвер (pdo_pgsql) включены в php.ini и что PostgreSQL запущен.

- Миграции падают с ошибкой absent column:
  - Возможно, проект ожидает дополнительные миграции; запустите `composer install` и `php artisan migrate` снова.
  - Если миграции зависят от seeders, выполните `php artisan db:seed`.

- Старые стили/JS не применяются:
  - Очистите кеш браузера и перезапустите сборку фронтенда (npm run build или npm run dev).

12) Опции для продвинутых/альтернативных сценариев
- Использовать Docker: если не хотите устанавливать окружение локально, можно поднять контейнеры (Postgres, PHP) через Docker Compose. В проекте может не быть docker-compose.yml — если нужно, я могу подготовить простой файл для быстрого разворачивания.

- Если хотите минимальный быстрый тест без установки БД: переключитесь на SQLite (см. пункт 5) и выполните миграции — это самый быстрый путь проверить интерфейс и большинство функций.

---
Если хочешь, я могу:
- подготовить `docker-compose.yml` для быстрого запуска (PHP+Postgres) — сделаю за тебя и приложу инструкции;
- или подготовить PowerShell-скрипт `setup.ps1`, который автоматизирует `composer install`, копирование `.env`, генерацию ключа, миграции и запуск сервера.

Какой вариант предпочитаешь: Docker + compose, или автоматизированный PowerShell-скрипт? 
