<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if(empty($_SESSION["userId"])) {
    echo "session userid empty";
    //Header('Location: ./loginFormView.php');
} else {
    //echo 'userid: ' . $_SESSION["userId"];
}


//echo "Timesheet summary page";

?> 