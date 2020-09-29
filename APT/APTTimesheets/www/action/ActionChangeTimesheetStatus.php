<?php

/*
 * Called when admin clicks to change status of timesheet within row.
 * Each row is a form.
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../class/Timesheet.php";

$rowTimesheetId = $_POST['timesheetId'];
$rowNewTimesheetStatus = lcfirst($_POST['newTimesheetStatus']);

//echo 'Timesheet ID:' . $rowTimesheetId;
//echo 'New status:' . $rowNewTimesheetStatus;

// Change a timesheets status
$timesheet = new \Phppot\Timesheet();
$timesheet->changeTimesheetStatus($rowTimesheetId, $rowNewTimesheetStatus);

Header('Location: ../view/views/ViewTimesheetsSummary.php');


