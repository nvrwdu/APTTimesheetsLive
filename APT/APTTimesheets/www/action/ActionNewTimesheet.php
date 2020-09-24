<?php
namespace Phppot;

/*
 * Called when user submits a new timesheet.
 */

require_once "../class/Timesheet.php";

//print_r($_POST);

$ts = new Timesheet();
$ts->setTimesheetValuesByAssocArray($_POST);

echo 'printing values:';
//print_r($ts->timesheetProperties);
$ts->saveTimesheet();



Header('Location: ../view/views/ViewTimesheetsSummary.php');
?> 