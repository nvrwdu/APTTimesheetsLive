<?php
//namespace Phppot;

echo "in action login page";
use \Phppot\Member;

if (! empty($_POST["login"])) {
    session_start();
    $username = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Member.php');

    $member = new Member();
    $isLoggedIn = $member->processLogin($username, $password);

    if (! $isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    }

    echo "action login cwd : " . getcwd();

    header("Location: ../index.php");
    exit();
}

?>