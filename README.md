# Monolegacy

* Forked from [davemacaulay/mccodesv2](https://github.com/davemacaulay/mccodesv2).
* Reset to v2.0.5b to remove both Dave Macaulay's and Magictallguy's alterations. (Sorry guys!)
* Started to migrate to the [Slim/Framework](https://www.slimframework.com/).

## Requirements

* Docker

## Setup

```shell
docker compose up -d
docker compose exec -T db mysql -umonolegacy -psecret monolegacy < schema.sql
cp .env.example .env
```

## Crons

Will be replaced in due course, for now, add this to your crontab, updating the
`/path/to/app` appropriately:

```
0  *  *  *  *  cd /path/to/app && docker compose exec -T php php crons/1h.php
0  0  *  *  *  cd /path/to/app && docker compose exec -T php php crons/1d.php
```

## Changes from v2.0.5b

* Static analysis used to catch the most obvious bugs.
* Docker setup with nginx, php-fpm and mysql
* Added support for PDO_mysql database driver
* Better `laston` tracking with daily breakdown
* Extensive starter selection of cities and courses
* Framework (Slim) based
* Conforms to latest PHP standards
* Built-in support for development docker containers
* Repository patterns pushing database queries away from the controllers
* Composer scripts for development helpers

## Todo

Lots of things, in no particular order:

* `[X]` Move non-page php files out to an includes folder
* `[X]` Remove bank interest
* `[X]` Move user stats into users table
* `[X]` Regenerate middleware
* `[X]` Added better `laston` tracking
* `[X]` Work up to static analysis at level 5
* `[ ]` Remove all crons
* `[ ]` Remove verification
* `[ ]` Change all code to use repository classes with PDO rather than mysql(i).
* `[ ]` Convert pages to use templates (Twig) - See below
* `[ ]` Create a base set of crimes, cities, items, houses, shops and courses
* `[ ]` Remove federal jail (or make it a staff only feature)
* `[ ]` Add real position for high scores
* `[ ]` Create better casino games (slots, roulette?)
* `[ ]` Add an auction house
* `[ ]` Remove macro system
* `[ ]` Re-implement CSRF
* `[ ]` Restore referral link to explore 
* `[ ]` Refactor all staff pages
* `[ ]` Remove cyberbank

Refactoring pages:

* `[X]` Login
* `[X]` Register
* `[X]` Explore 
* `[X]` User List (moved to Player List)
* `[X]` Users Online (moved to Player List)
* `[X]` Travel Agent
* `[X]` Bank
* `[X]` Staff List
* `[ ]` Home
* `[ ]` Inventory
* `[ ]` Events
* `[ ]` Mailbox
* `[ ]` Gym
* `[ ]` Crimes
* `[ ]` Job
* `[ ]` School
* `[ ]` Jail
* `[ ]` Hospital
* `[ ]` Forums
* `[ ]` Announcements
* `[ ]` Newspaper
* `[ ]` Search
* `[ ]` Preferences
* `[ ]` Player Report
* `[ ]` Tutorial
* `[ ]` Rules
* `[ ]` Profile
* `[ ]` Friends
* `[ ]` Enemies
* `[ ]` Gang
* `[ ]` Shops
* `[ ]` Shops 
* `[ ]` Item Market
* `[ ]` Crystal Market
* `[ ]` Hall of Fame
* `[ ]` Game Stats
* `[ ]` Realtor
* `[ ]` Crystal Temple
* `[ ]` Battle Tent
* `[ ]` Polling Booth
* `[ ]` Gangs
* `[ ]` Gang Wars
* `[ ]` Federal Jail
* `[ ]` Slots Machine
* `[ ]` Roulette
* `[ ]` Lucky Boxes
