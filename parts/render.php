<div id="render">

<?php

    if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/projects/Movies/') {
        
        require_once 'movie_list.php';;
        }

    echo $content ?? '';

?>

</div>