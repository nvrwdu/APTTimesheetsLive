<div class="main-timesheet-container">
    <form class="pure-form pure-form-stacked" action="../../action/ActionNewTimesheet.php" enctype="multipart/form-data"  method="post">

        <?php
        $formValues = $_GET;
        //$_GET['name'] = '';

        //print_r($_SESSION['singleTimesheet'][0]['Contract']);
        $singleTimesheet = $_SESSION['singleTimesheet'];
        //print_r($singleTimesheet);

        ?>

        <legend class="">New timesheet</legend>
        <br>
        <h5>Status : <?php echo $singleTimesheet[0]['Status']; ?></h5>
        <fieldset>
            <div class="date-timefrom-timeto-container">
                <div classhttps://apttimesheets.herokuapp.com/APT/APTTimesheets/componenttests/attachments/uploads/nature.jpg="date">
                    <label for="date">Date</label>
                    <input type="date" name="datetime[0]['date']" placeholder="Date" value="<? echo $singleTimesheet[0]['Date']; ?>" />
                </div>
                <div class="time-from">
                    <label for="time-from">Time From</label>
                    <input type="time" name="datetime[0]['timefrom']" placeholder="Time" value="<? echo $singleTimesheet[0]['TimeFrom']; ?>" />
                </div>
                <div class="time-to">
                    <label for="time-from">Time To</label>
                    <input type="time" name="datetime[0]['timeto']" placeholder="Time" value="<? echo $singleTimesheet[0]['TimeTo']; ?>" />
                </div>
            </div>

            <label for="contract">Contract</label>
                <?
                // Keep timesheet contract value as selected
                    $xml =
                        "<select name='contract'>
                            <option>Telent</option>
                            <option>KNN</option>
                            <option>Virgin Media</option>
                        </select>";

                    $timesheetContract = $singleTimesheet[0]['Contract'];

                    $contractOptions = simplexml_load_string($xml);
                    $optionValues = $contractOptions->option;

                    for ($i=0 ; $i < count($optionValues) ; $i++) {
                        if ($optionValues[$i] == $timesheetContract) {
                            //echo 'found at index: ' . $i;
                            $contractOptions->option[$i]->addAttribute('selected', '');
                        }
                    }

                    echo $contractOptions->asXML();
                ?>



            <label for="jobnumber">Job Number</label>
            <input type="text" name="jobnumber" placeholder="Job Number" value="<? echo $singleTimesheet[0]['JobNumber']; ?>" />

            <label for="estimate">Estimate</label>
            <input type="text" name="estimate" placeholder="Estimate" value="<? echo $singleTimesheet[0]['Estimate']; ?>" />

            <label for="exchange">Exchange</label>
            <input type="text" name="exchange" placeholder="Exchange" value="<? echo $singleTimesheet[0]['Exchange']; ?>" />

            <br><br><br>


            <b>Planned work</b><br><br>

            <div id="planned-synthetics-container">

                <?php
                    require_once "../../class/Timesheet.php";

                    // Get planned synthetic data
                    $timesheet = new \Phppot\Timesheet();
                    $plannedSynthetics = $timesheet->getPlannedSynthetics($singleTimesheet, 'planned');
                    $unplannedSynthetics = $timesheet->getPlannedSynthetics($singleTimesheet, 'unplanned');
                    //print_r($plannedSynthetics[0]);
                    //echo count($unplannedSynthetics);
                    // Loop over planned and unplanned synthetics, creating html dynamically.
                    for ($i=0 ; $i<count($plannedSynthetics) ; $i++) {
                        echo '
                            Synthetic <input type="text" name="plannedsynthetic['. $i .']["plannedsynthetic"]" value="' . $plannedSynthetics[$i][0] . '">
                            Quantity <input type="text" name="plannedsynthetic['. $i .']["quantity"]" value="' . $plannedSynthetics[$i][1] . '"><br>
                        ';
                    }


                ?>
            </div>


            <button type="button" class="pure-button" id="btn-add-new-planned-synthetic">Add</button>

            <br><br><br><br>

            <b>DfE's / Unplanned work</b><br><br>


            <div id="unplanned-synthetics-container">

                <?php

                // $unplannedSynthetics initialised when rendering plannedSynthetics.
                for ($i=0 ; $i<count($unplannedSynthetics) ; $i++) {
                    echo '
                            Synthetic <input type="text" name="unplannedsynthetic['. $i .']["plannedsynthetic"]" value="' . $unplannedSynthetics[$i][0] . '">
                            Quantity <input type="text" name="unplannedsynthetic['. $i .']["quantity"]" value="' . $unplannedSynthetics[$i][1] . '"><br>
                            <textarea id="textarea-unplanned-work-comments-box" name="unplannedsynthetic['. $i .']["comments"]" placeholder="Comments">' . $unplannedSynthetics[$i][2] . '</textarea>
                <br>
                        ';
                }

                ?>
            </div>


            <button type="button" class="pure-button" id="btn-add-new-unplanned-synthetic">Add</button>


            <br><br><br><br>
            <textarea id="textarea-timesheet-comments-box" name="timesheetcomments" placeholder="Timesheet comments" ><?php echo $singleTimesheet[0]['Comments']; ?></textarea>
            <br>


            <br><br>

<input type="file" name="filesToUpload[]" multiple="multiple" id="filesToUpload">



            <br><br>

            <?php
                // Render buttons based on timesheet status
                // If no session for timesheet status exists, render 'new' and 'change' buttons
                // If 'pending' status, render, 'new' and 'change buttons
                // If 'rejected status, render, 'amend' button

                // Current timesheet status from $_GET
                $timesheetStatus = $singleTimesheet[0]['Status'];

                switch ($timesheetStatus) {
                    case 'pending':
                        echo
                            '<button type="submit" class="pure-button pure-button-primary">Change timesheet</button>
                            <br><br>';
                        break;
                    case 'rejected':
                        echo '<button type="button" class="pure-button pure-button-primary">Amend timesheet</button>';
                        break;
                    default:
                        //echo 'default state';
                        echo '<button type="submit" class="pure-button pure-button-primary">Submit new timesheet</button>
                            <br><br>';
                }
            ?>

        </fieldset>
    </form>

<?php

/*
 * Display timesheet images
 */
if ($_SESSION['images']) {
    for ($i=0 ; $i<count($_SESSION['images']) ; $i++) {
        echo '<img src="' . $_SESSION['images'][$i]['url'] . '"/>';
    }
}

?>


</div>
