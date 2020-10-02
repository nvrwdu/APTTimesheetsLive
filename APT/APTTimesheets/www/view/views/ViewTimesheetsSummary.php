<?php
namespace Phppot;

echo 'working';
echo getcwd();
//if(include_once($_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/TimesheetSummaryRenderView.php')) {
//    echo 'required file imported';
//} else {
//    echo 'required file error';
//}
echo '<br>';
echo $_SERVER['DOCUMENT_ROOT'];

require_once '../../class/TimesheetSummaryRenderView.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/TimesheetSummaryRenderView.php';