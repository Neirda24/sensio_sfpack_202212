Exercise 01 - Create an OMDB Client
===================================

Create an OmdbApiConsumer service
1. Use a HttpClientInterface $client to retrieve movie information based on title or imdb ID
2. Use $client::request(string $method, string $url, array $options) to perform the request
3. The $options array can contain a query key to pass query parameters

Update the `movie_details` page so it either accept a slug or an OMDB ID.
If you need to find an OMDB ID go here : https://www.omdbapi.com/#examples and search for any movie. You should be prompted with a json like so (searched for "harry potter") :

```json
{"Title":"Harry Potter and the Deathly Hallows: Part 2","Year":"2011","Rated":"PG-13","Released":"15 Jul 2011","Runtime":"130 min","Genre":"Adventure, Family, Fantasy","Director":"David Yates","Writer":"Steve Kloves, J.K. Rowling","Actors":"Daniel Radcliffe, Emma Watson, Rupert Grint","Plot":"Harry, Ron, and Hermione search for Voldemort's remaining Horcruxes in their effort to destroy the Dark Lord as the final battle rages on at Hogwarts.","Language":"English, Latin","Country":"United Kingdom, United States","Awards":"Nominated for 3 Oscars. 46 wins & 94 nominations total","Poster":"https://m.media-amazon.com/images/M/MV5BMGVmMWNiMDktYjQ0Mi00MWIxLTk0N2UtN2ZlYTdkN2IzNDNlXkEyXkFqcGdeQXVyODE5NzE3OTE@._V1_SX300.jpg","Ratings":[{"Source":"Internet Movie Database","Value":"8.1/10"},{"Source":"Rotten Tomatoes","Value":"96%"},{"Source":"Metacritic","Value":"85/100"}],"Metascore":"85","imdbRating":"8.1","imdbVotes":"872,242","imdbID":"tt1201607","Type":"movie","DVD":"11 Nov 2011","BoxOffice":"$381,447,587","Production":"N/A","Website":"N/A","Response":"True"}
```

The ID you need is under the key `imdbID` (in the above example the value is `tt1201607`).


# Steps

1. Create an account here to retrieve an API Key : https://www.omdbapi.com/apikey.aspx
2. Setup the key in a `./.env.local` file like so :
```dotenv
OMDB_KEY=YOUR_KEY
```
