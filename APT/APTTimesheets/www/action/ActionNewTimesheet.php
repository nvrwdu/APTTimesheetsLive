<?php
namespace Phppot;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
 * Called when user submits a new timesheet.
 */

require_once "../class/Timesheet.php";

print_r($_POST);

$ts = new Timesheet();
$ts->setTimesheetValuesByAssocArray($_POST);
$currentTimesheetId = $ts->saveTimesheet(); // Use to save supporting files to FileServer


//print_r($_FILES['filesToUpload']);

// Save timesheet files to server.
$pathsToImages = $_FILES['filesToUpload']['tmp_name'];


//echo "current tsid: " . $currentTimesheetId;
//echo "paths to images: " . $pathsToImages;

if (!empty($pathsToImages[0])) {
    $ts->saveTimesheetImagesData($currentTimesheetId, $pathsToImages);
}









//echo 'printing values:';

//print_r($ts->timesheetProperties['unplannedsynthetic']);
//
//foreach ($ts->timesheetProperties['unplannedsynthetic'] as $unplannedSynthetic) {
//    print_r($unplannedSynthetic["'unplannedsynthetic'"]);
//    print_r($unplannedSynthetic["'quantity'"]);
//    print_r($unplannedSynthetic["'comments'"]);
//}



//
Header('Location: ../view/views/ViewTimesheetsSummary.php');
?> 
