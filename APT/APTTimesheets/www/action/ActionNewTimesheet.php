<?php
namespace Phppot;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
 * Called when user submits a new timesheet.
 */

require_once "../class/Timesheet.php";

//print_r($_POST);

$ts = new Timesheet();
$ts->setTimesheetValuesByAssocArray($_POST);

//print_r($ts->timesheetProperties['comments']);

//echo 'printing values:';

//print_r($ts->timesheetProperties['unplannedsynthetic']);
//
//foreach ($ts->timesheetProperties['unplannedsynthetic'] as $unplannedSynthetic) {
//    print_r($unplannedSynthetic["'unplannedsynthetic'"]);
//    print_r($unplannedSynthetic["'quantity'"]);
//    print_r($unplannedSynthetic["'comments'"]);
//}

$ts->saveTimesheet();
//
Header('Location: ../view/views/ViewTimesheetsSummary.php');
?> 