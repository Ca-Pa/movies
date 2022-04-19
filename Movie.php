<?php
require_once 'connection.php';

class Movie extends Connection
{

    const SUCCESS = 1;
    const FAIL = 0;

    public function getAllMovies()
    {
        return $this->get('movies');
    }

    public function getMovie($id)
    {
        return $this->get('movies', $id);
    }

    public function createMovie($request)
    {
        $validate = $this->validateInputs($request);
        $location = 'create_movie_form.php';
        $movie = $request;

        if ($validate['status'] === self::SUCCESS) {
            $this->create('movies', $movie);
            $location = '/projects/Movies';
        }
 
        return  header("Location: $location?status={$validate['status']}&message={$validate['message']}&data={$validate['orderData']}");
    }

    public function updateMovie($request)
    {
        $validate = $this->validateInputs($request);
        $movie = $request;

        $location = "create_movie_form.php?action=update&movie_id={$movie['id']}&status={$validate['status']}&message={$validate['message']}&data={$validate['orderData']}";

        if ($validate['status'] === self::SUCCESS) {

            $this->update('movies', $movie);
            $location = '/projects/Movies';
        }

        return header("Location: $location");
    }

    public function deleteMovie($request)
    {
        if (isset($request['movie_id'])) {
            $this->delete('movies', $request['movie_id']);
            $location = '/projects/Movies';
            
        }

        return header("Location: $location");
    }

    public function getListHtml()
    {
        $movieHtml = '';

        foreach ($this->getAllMovies() as $movie) {
            if (isset($_GET['search'])) {
                $search = $_GET['search'];

                if (stripos($movie['name'], $search) === false) {
                    if (stripos($movie['year'], $search) === false) {
                        if (stripos($movie['genre'], $search) === false) {
                            if (stripos($movie['author'], $search) === false) {
                                continue;
                            }
                        }
                    }
                }
            }

            $singleHtml = "
                <div class='movieContainer'>
                    <div><img src='{$movie['img']}' alt='Paveikslelis {$movie['name']}' style='width: 280px;height:300px;'></div>
                    <h2>{$movie['name']}</h2>
                    <h3>Metai: {$movie['year']}</h3>
                    <h3>Žanras: {$movie['genre']}</h3>
                    <h3>Autorius: {$movie['author']}</h3>
                    <br>
                    <a href='create_movie_form.php?action=update&movie_id={$movie['id']}'>Keisti</a>
                    <span> / </span>
                    <a href='handle_movie_crud.php?_METHOD=DELETE&movie_id={$movie['id']}'>Pašalinti</a>
                </div>";

            $movieHtml .= $singleHtml;

            if (isset($_GET['movie_id']) && ($_GET['movie_id'] == $movie['id'])) {
                $movieHtml = $singleHtml;
                break;
            }
        }

        return $movieHtml;
    }

    private function validateInputs($inputs)
    {
        $msg = '';
        $status = self::SUCCESS;
        $orderData = json_encode($inputs);

        foreach ($inputs  as $key => $value) {
            if (!$value) {
                $status = self::FAIL;
                $msg .= "Please fill in field $key<br>";
            }
        }

        return ['status' => $status, 'message' => $msg, "orderData" => $orderData];
    }
}
