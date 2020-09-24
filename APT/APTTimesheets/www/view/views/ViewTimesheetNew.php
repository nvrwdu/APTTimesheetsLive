<?php

/* From dashboard.php */
namespace Phppot;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(empty($_SESSION["userId"])) {
    echo "session userid empty";
    Header('Location: ./ViewLoginForm.php');
} else {
    //echo 'userid: ' . $_SESSION["userId"];
}




use http\Header;
use \Phppot\Member;

// Get member displayName
//if (! empty($_SESSION["userId"])) {
//    require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Member.php';
//    $member = new Member();
//    $memberResult = $member->getMemberById($_SESSION["userId"]);
//    if(!empty($memberResult[0]["display_name"])) {
//        $displayName = ucwords($memberResult[0]["display_name"]);
//    } else {
//        $displayName = $memberResult[0]["user_name"];
//    }
//}


// Store display name in the global array



echo "Email: " . $_SESSION["userEmail"];

echo "action" . $_GET['action'];
if ($_GET['action'] == 'newtimesheet') {
    $_SESSION['singleTimesheet'] = '';
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/view/elements/ElementHeadTagElements.php'; ?>
<head/>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/view/elements/ElementMainMenu.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/view/elements/ElementNewTimesheetForm.php'; ?>
</body>

</html>

<script src="../js/timesheetApp.js"></script>

