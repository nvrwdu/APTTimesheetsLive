<?php


if(!session_start()){
    session_start();
}

if(!empty($_SESSION["userId"])) {
    require_once './view/views/ViewHome.php';
} else {
    require_once './view/views/ViewLoginForm.php';
}

exit();

?>