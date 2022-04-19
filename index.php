<?php

    include_once 'parts/nav.php';
    include_once 'parts/stats.php';
?>

    <main>
        <?php
            include_once 'parts/render.php';
            include_once 'parts/about.php';

            if ($_SERVER['REQUEST_URI'] === '/projects/Movies/index.php') {
                header('Location: /projects/Movies');
            }
        ?>
    </main>

<?php
    include_once 'parts/footer.php';