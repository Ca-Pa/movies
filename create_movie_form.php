<?php
require_once 'Movie.php';
require_once 'error.php';

const ACTIONS = 'handle_movie_crud.php';

$realMethod = 'POST';

if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'update') {

    $realMethod = 'PUT';

    if (isset($_REQUEST['movie_id'])) {
        $movie = new Movie();
        $movie =  $movie->getMovie($_REQUEST['movie_id']);
    }
} 

if (isset($movie['id'])) {
    
    $idInput =  "<input type='hidden' name='id' value='{$movie['id']}'>";
}

$content =
    "<section>
        <form action='" . ACTIONS . "' method='POST'>"    
        
            .($idInput ?? '') ."
            <input type='hidden' name='_METHOD' value='$realMethod'>

            <label>Movie Name</label>
            <input type='text' name='name' value='" . ($movie['name'] ?? '') . "'>

            <label>Year</label>
            <input type='text' name='year'  value='" . ($movie['year'] ?? '') . "'>

            <label>Genre</label>
            <input type='text' name='genre' value='" . ($movie['genre'] ?? '') . "'>

            <label>Author</label>
            <input type='text' name='author' value='" . ($movie['author'] ?? '') . "'>

            <label>Image(URL)</label>
            <input type='text' name='img' value='" . ($movie['img'] ?? '') . "'>

            <input type='submit'>
        </form>
</section>";

require_once 'index.php';





