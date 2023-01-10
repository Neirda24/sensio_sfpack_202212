Exercise 10 - Create and display a form
=======================================

1. Create a new form to add / edit a movie.
   1. Update the movie controller
   2. Create a new type
   3. Display the form


# Steps
```shell
$ symfony console make:form MovieType Movie
```

Exercise 11 - Add validation to the form
========================================

1. Add constraints to your form data.
2. Check the validation with the Symfony Profiler.
3. Handle the submitted value to persist the new movie in the database.
