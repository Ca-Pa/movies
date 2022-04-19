<?php
require_once 'Movie.php';

$movie = new Movie();
$content =
    "
    <form>
            <label>Paieška</label>
            <input type='text' name='search'>
            <input type='submit'>
    </form>
    <div>
        {$movie->getListHtml()}
    </div>
    ";

