Exercise 06 - Configure Doctrine
================================

1. Configure Doctrine to access the database. Let’s assume we will use a SQLite storage, located in `./var/main.db`
2. Create the database with the console

# Steps
```shell
$ symfony composer require doctrine
$ symfony console doctrine:database:create
$ symfony console make:entity # Create the Movie entity
```

Exercise 07 - New entities
==========================

1. Create new entities:
    * Movie
        * slug: string(255)
        * title: string(255)
        * poster: string(255)
        * releasedAt: datetimetz_immutable
    * Genre
        * name: string(255)
2. Generate a new migration.
3. Store both tables in your database.

# Steps

```shell
$ symfony console make:entity # Create the Movie entity
$ symfony console make:entity # Create the Genre entity
$ symfony console doctrine:migration:diff
$ symfony console doctrine:migration:migrate
```

See the movie entity creation :
[![asciicast](https://asciinema.org/a/IghXb5Fh3iKbKgsZMrVqLXYBF.svg)](https://asciinema.org/a/IghXb5Fh3iKbKgsZMrVqLXYBF)

Exercise 08 - Fetch from the database
=====================================

1. Create fixtures for your database.
2. Update your navbar to retrieve movies from your database.
3. Update your "movie_details" page to retrieve movies from your database.

# Steps

```shell
$ symfony composer require orm-fixtures --dev
$ symfony console doctrine:fixtures:load
```

Exercise 09 - Create entities relationships
===========================================

1. Create a ManyToMany relationship between movie and genre entities.
2. Generate and run a new migration


# Steps

```shell
$ symfony console make:entity # On movie to generate the Genres relationship
$ symfony console doctrine:migration:diff
$ symfony console doctrine:migration:migrate
$ symfony console doctrine:fixtures:load
```

See the relation creation :
[![asciicast](https://asciinema.org/a/D060sfhxHStQ14xZ7J3OP8bBn.svg)](https://asciinema.org/a/D060sfhxHStQ14xZ7J3OP8bBn)
