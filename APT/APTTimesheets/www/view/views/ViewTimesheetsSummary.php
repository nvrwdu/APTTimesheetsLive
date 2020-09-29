<?php
namespace Phppot;

require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/TimesheetSummaryRenderView.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Timesheet.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(empty($_SESSION["userId"])) {
    echo "session userid empty";
    //Header('Location: ./loginFormView.php');
} else {
    //echo 'userid: ' . $_SESSION["userId"];
}


use http\Header;
use \Phppot\Member;


//echo "Timesheet summary page !"; ?>

<!DOCTYPE html>
<html>
<head>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/view/elements/ElementHeadTagElements.php'; ?>
<head/>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/view/elements/ElementMainMenu.php'; ?>
</body>


<script src="../js/timesheetApp.js"></script>

<?php
    // Get timesheet data for user
    $timesheetData = new Timesheet();


    switch ($_SESSION['userType']) {
        case 'submitter' :
            $timesheetData = $timesheetData->getTimesheetsByUserId($_SESSION['userId']);

            //Pass timesheet data to renderer
            $timesheetSummaryRenderView = new TimesheetSummaryRenderView($timesheetData);
            $timesheetSummaryRenderView->render();
            break;
        case 'admin' :
            $timesheetData = $timesheetData->getAssociatedUsersTimesheets($_SESSION['userId']);

            // Pass timesheet data to renderer
            $timesheetSummaryRenderView = new TimesheetSummaryRenderView($timesheetData);
            $timesheetSummaryRenderView->render();
            break;
        default :
            echo 'user is neither a submitter, nor admin.' . __FILE__;

    }


?>

</html>