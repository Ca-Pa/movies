<?php

require_once 'Movie.php';

$movie = new Movie();
$method = $_REQUEST['_METHOD'];

switch ($method) {
    case 'POST':
        $movie->createMovie($_REQUEST);
        break;

    case 'PUT':
        $movie->updateMovie($_REQUEST);
        break;

    case 'DELETE':
        $movie->deleteMovie($_REQUEST);
        break;
}

