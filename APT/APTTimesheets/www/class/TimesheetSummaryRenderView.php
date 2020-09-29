<?php
namespace Phppot;

require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Member.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APT/APTTimesheets/www/class/Timesheet.php';




class TimesheetSummaryRenderView {

    public $timesheets; // Holds all timesheet data

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
                //echo "Timesheet summary page for submitters";
                $this->renderSubmitterTimesheetTableSummary($this->timesheets);
                break;

            case 'admin' :
                //echo "Timesheet summary page for admins";
                $this->renderAdminTimesheetTableSummary($this->timesheets);
                break;

            case 'superadmin' :
                echo 'page for super admin';
                // Add view to viewToRender for admin
                //$this->viewToRender .= "This is the view for user type superadmin";

            default:
                echo 'neither submitter, nor admin, nor superadmin';
        }
    }

    /*
     * Takes $timesheets which holds timesheets data.
     * Returns an HTML rendered table with the timesheets data.
     */
    private function renderAdminTimesheetTableSummary($timesheets) {

        $timesheetAttributesUsed = array_keys($timesheets[0]);
        //print_r($timesheetAttributesUsed);

        // Display table headers
        echo '<table style="width:100%" class="class=table table-hover table-striped">
                <thead>
          <tr>';
            foreach ($timesheetAttributesUsed as $timesheetAttribute) {
                echo '<th scope="col">' . $timesheetAttribute . '</th>';
            }
            echo '<th scope="col">Extra</th>';

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
            echo '<td>
                    <form action="../../action/ActionChangeTimesheetStatus.php" method="post" id="frmChangeTimesheetStatus">                        
                        <select name="newTimesheetStatus">
                            <option>Approve</option>
                            <option>Reject</option>
                        </select>
                        <input type="submit" name="btnChangeTimesheetStatus" value="Change">
                        <input type="hidden" name="timesheetId" value="' . $timesheetId . '"/>
                    </form>
                  </td>';

            echo '</tr>'; // End table row
        }

        echo '</tbody></table>';
    }

    /*
     * Includes options to amend associated timesheets status (reject, accept)
     */
    private function renderSubmitterTimesheetTableSummary($timesheets) {

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
            echo '<tr>'; // Table row begins here. Add option to change timesheet status here.
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

}




