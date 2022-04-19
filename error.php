<?php
if (isset($_GET['status'])) {

    if($_GET['status'] != 1 && isset($_GET['message'])){

        $message = 'ERROR!<br><br>' . $_GET['message'];
    }

    echo "
        <div class='message'>
            <h4>{$message}</h4>
            <i class='close-message fas fa-window-close'>Close</i>
        </div>";
}