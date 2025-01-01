# Monolegacy

Forked from [davemacaulay/mccodesv2](https://github.com/davemacaulay/mccodesv2/tree/v2.0.5b), Monolegacy is a simple browser game written in PHP where players commit
crimes, trade and fight one-another in an effort to "**be the best**".

Since support for the original game died a long time ago, and there appears to be little or no activity over at
[MakeWebGames](https://makewebgames.io/forum/32-mccodes/), I've created this repo, ignoring the changes made by [Dave Macaulay](https://github.com/davemacaulay) and [Anthony](https://github.com/Magictallguy) as
their contributions will get superseded as I work on this code-base.

The plans are relatively simple - not necessarily in order:

* Add support for a local docker setup for local development
* Get the code base working "as-is"
* Cleanup the code using up-to-date code style
* Correct static analysis issues
* Add some default content so we can play-test the code
* Move to class-based code
* Use a templating system instead of inline HTML
* Write some basic unit and feature tests
* Make a front-end controller using PSR7/PSR15
* Create a modular plugin system for future modules
* Remove the current cron system
* Ensure code is compliant with PHP 8.3

## Setup

```bash
git clone git@github.com:inveteratus/monolegacy.git
cd monolegacy
cp env.example .env
docker compose up -d
sh import.sh
```
You should now able to access the site by opening [http://localhost/](http://localhost/).

There are two users setup by default:default users:

| Name  | Username | Password | Email             | Usage                |
|-------|----------|----------|-------------------|----------------------|
| Admin | admin    | secret   | admin@example.com | A full administrator |
| User  | user     | secret   | user@example.com  | A normal user        |

## Database

You can access the database via an [Adminer](https://www.adminer.org/) script by pointing your browser to
[http://localhost:8080](http://localhost:8080/?server=db&username=monolegacy&db=monolegacy) with the following
credentials:

* **System**: _MySQL_
* **Server**: _db_
* **Username**: _monolegacy_
* **Password**: _secret_
* **Database**: _monolegacy_

There are also two scripts in the root folder

* `import.sh` will import `schema.sql` overwriting all existing data.
* `export.sh` will write the current database schema to `schema.sql`.

You can add extra queries to `extra.sql` which will be imported after `schema.sql` when running `import.sh`. This
allows you to, for example, add a new user or update one of the existing users. Note that the `extra.sql` file is
_NOT_ tracked by git so will not be pushed to your repository.
