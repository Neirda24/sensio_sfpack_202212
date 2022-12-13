Exercise 01 - Create an import command
======================================
Create a new command to perform a data import for OMDB API into our database.

1. The command will ask for either a OMBD id or a movie title
2. The command will display the steps processed, and the movie information once imported, such as:
   * ids (the one from the API and ours from the database)
   * title
   * MPAA restriction (Movie::rated)

# Steps

1. Update your Movie entity to have a "rated" field (for the MPAA restriction)
2. Create the command `app:movies:import:omdb` with `symfony console make:command`
    * The command will accept an array
    * The argument can be either the ID or a title.
