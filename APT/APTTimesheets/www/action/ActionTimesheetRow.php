<?php
namespace Phppot;

use http\Header;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../class/TimesheetSummaryRenderView.php";
require_once "../class/Timesheet.php";

//echo 'this page receives the timesheets row values. From it, renders a single timesheet summary';
//echo 'timesheetID: ' . $_GET['timesheetId'];



//Get timesheet to render
$timesheet = new Timesheet();
$singleTimesheet = $timesheet->getTimesheetById($_GET['timesheetId']);

//print_r($singleTimesheet);


// Getting planned synthetics from timesheet
    //$plannedSynthetics = $timesheet->getPlannedSynthetics($singleTimesheet);
    //print_r($plannedSynthetics);

    //print_r($singleTimesheet[0]['Name']);
    //echo '<br>';
    //print_r($singleTimesheet[0]['Quantity']);
    //echo '<br>';
    //print_r($singleTimesheet[0]['syntheticType']);
    //echo '<br>';
    //print_r($singleTimesheet[1]['Name']);
    //echo '<br>';
    //print_r($singleTimesheet[1]['Quantity']);
    //echo '<br>';
    //print_r($singleTimesheet[1]['syntheticType']);
    //echo '<br>';
//


$_SESSION['singleTimesheet'] = $singleTimesheet;

Header('Location: ../view/views/ViewTimesheetNew.php');





?>