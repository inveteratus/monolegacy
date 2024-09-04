# Monolegacy

* Forked from [davemacaulay/mccodesv2](https://github.com/davemacaulay/mccodesv2).
* Reset to v2.0.5b to remove both Dave Macaulay's and Magictallguy's alterations. (Sorry guys!)

## Requirements

* Docker

## Setup

```shell
docker compose up -d
docker compose exec -T db mysql -umonolegacy -psecret monolegacy < schema.sql
```

## Crons

Will be replaced in due course, for now, add this to your crontab, updating the
`/path/to/app` appropriately:

```
*    *    *    *    *    cd /path/to/app && docker compose exec -T php php crons/1m.php
*/5  *    *    *    *    cd /path/to/app && docker compose exec -T php php crons/5m.php
*/15 *    *    *    *    cd /path/to/app && docker compose exec -T php php crons/15m.php
0    *    *    *    *    cd /path/to/app && docker compose exec -T php php crons/1h.php
0    0    *    *    *    cd /path/to/app && docker compose exec -T php php crons/1d.php
```

## Changes from v2.0.5b

* Static analysis used at level 0 to catch the most obvious bugs.
* Docker setup with nginx, php-fpm and mysql
* Added support for PDO_mysql database driver

## Todo

In no particular order:

* Remove all crons
* Change verified to make it per-user rather than global
* Change all code to use PDO
* Work up to static analysis at level 5
* Convert pages to use templates (Twig)
* Create a base set of crimes, cities, items and courses
* Move non-page php files out to an includes folder
