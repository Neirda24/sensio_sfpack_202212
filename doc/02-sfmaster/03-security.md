Exercise 03 - Create an import command
======================================
Create a new command to perform a data import for OMDB API into our database.

1. Filter users so that only administrators can access `^/admin` URLs.
2. Ensure a customer cannot order a movie if he doesn’t meet age requirements.

# Steps

```shell
$ symfony console make:user
$ symfony console make:auth
$ symfony console doctrine:migration:diff
$ symfony console doctrine:migration:migrate
$ symfony console make:voter
$ symfony composer require clock
```
