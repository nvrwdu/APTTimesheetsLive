<?php
namespace Phppot;

require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Member.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Timesheet.php';




class TimesheetSummaryRenderView {

    private $timesheets; // Holds all timesheet data

    public function __construct($timesheets) {
        $this->timesheets = $timesheets; // Hold timesheet data

        // Get user status
//        $user = new Member();
//        //$userStatus = $user->getMemberUserStatus($_SESSION['userId']);
//        $userStatusArray = $user->getMemberUserStatus($_SESSION["userId"]);
//        $userStatus = $userStatusArray[0]['user_type'];
    }

    public function render() {

        switch ($_SESSION["userType"]) {
            case 'submitter':
                // Render for submitter
                // get data for all submitters timesheets ($results)
//                $userTimesheets = new Timesheet();
//                $timesheets = $userTimesheets->getTimesheetsByUserId($_SESSION["userId"]);
//                $this->renderTimesheetTableSummary($timesheets);
                //echo "render for submitter";
                $this->renderSubmitterTimesheetTableSummary($this->timesheets);
                break;
            case 'admin' :
                //$this->viewToRender .= "This is the view for user type admin";
                //echo "this is the page for admin users";
//                $userTimesheets = new Timesheet();
//                $timesheets = $userTimesheets->getTimesheetsByUserId($_SESSION["userId"]);
//                $this->renderTimesheetTableSummary($timesheets);
//                break;
            case 'superadmin' :
                // Add view to viewToRender for admin
                //$this->viewToRender .= "This is the view for user type superadmin";

        }



    }

    /*
     * Takes $timesheets which holds timesheets data.
     * Returns an HTML rendered table with the timesheets data.
     */
    private function renderSubmitterTimesheetTableSummary($timesheets, $rowActionHandler="") {

        $timesheetAttributesUsed = array_keys($timesheets[0]);
        //print_r($timesheetAttributesUsed);

        // Display table headers
        echo '<table style="width:100%" class="class=table table-hover table-striped">
                <thead>
          <tr>';
            foreach ($timesheetAttributesUsed as $timesheetAttribute) {
                echo '<th scope="col">' . $timesheetAttribute . '</th>';
            }

            echo '</tr>
                </thead>
                
                <tbody>';

        //Display table contents
        foreach ($timesheets as $timesheet) {
            echo '<tr>';
            $timesheetId = $timesheet['TimesheetID'];

            foreach ($timesheet as $key => $value) {
                //print_r($value);

                echo '<td><a href="../../action/ActionTimesheetRow.php?timesheetId=' . $timesheetId . '">' . $value . '</a></td>';
            }
            echo '</tr>';
        }

        echo '</tbody></table>';
    }

    /*
     * Expects single timesheet.
     */
    public function renderSingleTimesheet() {

        // For now, just echo timesheet contents to page.
        echo "Timesheet ID: " . $this->timesheets[0]['TimesheetID'];
        echo " Timesheet Date: " . $this->timesheets[0]['Date'];
        echo " Timesheet TimeFrom: " . $this->timesheets[0]['TimeFrom'];
        echo " Timesheet TimeTo: " . $this->timesheets[0]['TimeTo'];
        echo " Timesheet contract: " . $this->timesheets[0]['Contract'];
    }


    private function renderAdminTimesheetTableSummary($timesheets) {

        $timesheetAttributesUsed = array_keys($timesheets[0]);
        //print_r($timesheetAttributesUsed);

        // Display table headers
        echo '<table style="width:100%" class="table table-striped">
          <tr>';
        foreach ($timesheetAttributesUsed as $timesheetAttribute) {
            echo '<th>' . $timesheetAttribute . '</th>';
        }

        echo '</tr>';

        //Display table contents
        foreach ($timesheets as $timesheet) {
            echo '<tr>';
            foreach ($timesheet as $key => $value) {
                //print_r($value);
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }

        echo '</table>';
    }


}




