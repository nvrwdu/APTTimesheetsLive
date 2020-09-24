<?php
namespace Phppot;



require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/TimesheetSummaryRenderView.php';


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
$timesheet = new Timesheet();
$timesheet = $timesheet->getTimesheetById(55);

print_r($timesheet);
$timesheetSummaryRenderView = new TimesheetSummaryRenderView();
$timesheetSummaryRenderView->renderSingleTimesheet($timesheet);

?>

</html>