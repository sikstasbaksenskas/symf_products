# Symfony E.shop cart implementation

App is based on [Symfony 5](https://symfony.com/doc/current/index.html). In order to run this
locally, install [Symfony CLI](https://symfony.com/download),
[Composer](https://getcomposer.org/download/) and run the following commands:

```bash
cp .env .env.local # Update the DATABASE_URL in the .env.local
composer install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
symfony server:start --no-tls -d
symfony open:local # Opens the assignment description page
```
