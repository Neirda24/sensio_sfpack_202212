Exercise 03 - Create a template
===============================

1. Create a navbar in a specific Twig file, still without links. 
2. Create a "movie_details" page and controller to display a single movie. 
3. In your "movie_details" page:
    1. Create an array in your controller to set fake movie data. 
    2. Use Twig to display the movie title, releasedAt, and genres.


# Steps
```shell
$ symfony console make:controller # HomeController (list movies)
$ symfony composer require twig/intl-extra # In order to use the `|format_date('full')` twig filter
$ symfony console make:controller # MovieController (see movie details)
```
