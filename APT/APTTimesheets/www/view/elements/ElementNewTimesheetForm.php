<div class="main-timesheet-container">
    <form class="pure-form pure-form-stacked" action="../../action/ActionNewTimesheet.php" method="post">

        <?php
        $formValues = $_GET;
        //$_GET['name'] = '';

        //print_r($_SESSION['singleTimesheet'][0]['Contract']);
        $singleTimesheet = $_SESSION['singleTimesheet'];
        print_r($singleTimesheet);

        ?>

        <legend class="">New timesheet</legend>
        <br>
        <h5>Status : <?php echo $singleTimesheet[0]['Status']; ?></h5>
        <fieldset>
            <div class="date-timefrom-timeto-container">
                <div class="date">
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
                            echo 'found at index: ' . $i;
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
            <?php
                require_once "../../class/Timesheet.php";

                // Get planned synthetic data
                $timesheet = new \Phppot\Timesheet();
                $plannedSynthetics = $timesheet->getPlannedSynthetics($singleTimesheet, 'planned');
                $unplannedSynthetics = $timesheet->getPlannedSynthetics($singleTimesheet, 'unplanned');
                print_r($plannedSynthetics[0]);
                print_r($unplannedSynthetics[0]);

                // Now loop over planned and unplanned synthetics, creating html dynamically.



            ?>
            Synthetic <input type="text" name="plannedsynthetic[1]['plannedsynthetic']" value="<?php echo $plannedSynthetics[0][0]; ?>">
            Quantity <input type="text" name="plannedsynthetic[1]['quantity']" value="<?php echo $plannedSynthetics[0][1]; ?>"><br>
            <button type="button" class="pure-button" id="btn-add-new-planned-synthetic">Add</button>




            <br><br><br><br>





            <b>DfE's / Unplanned work</b><br><br>

            Synthetic <input type="text" name="unplannedsynthetic[1]['unplannedsynthetic']" value="<?php echo $unplannedSynthetics[0][0]; ?>">
            Quantity <input type="text" name="unplannedsynthetic[1]['quantity']" value="<?php echo $unplannedSynthetics[0][1]; ?>">
            <textarea id="textarea-unplanned-work-comments-box" name="unplannedsynthetic[1]['comments']" placeholder="Comments"><?php echo $unplannedSynthetics[0][2]; ?></textarea>
            <br>
            <button type="button" class="pure-button" id="btn-add-new-planned-synthetic">Add</button>


            <br><br><br><br>
            <textarea id="textarea-timesheet-comments-box" name="timesheetcomments" placeholder="Timesheet comments" ><?php echo $singleTimesheet[0]['Comments']; ?></textarea>
            <br>


            <br><br>

            <?php
                // Render buttons based on timesheet status
                // If no session for timesheet status exists, render 'new' and 'change' buttons
                // If 'pending' status, render, 'new' and 'change buttons
                // If 'rejected status, render, 'amend' button

                echo $timesheetStatus = $singleTimesheet[0]['Status'];

                switch ($timesheetStatus) {
                    case 'pending':
                        echo
                            '<button type="submit" class="pure-button pure-button-primary">Submit new timesheet</button>
                            <br><br>';
                        break;
                    case 'rejected':
                        echo '<button type="button" class="pure-button pure-button-primary">Amend timesheet</button>';
                        break;
                    default:
                        echo 'default state';
                        '<button type="submit" class="pure-button pure-button-primary">Submit new timesheet</button>
                            <br><br>';
                }
            ?>

        </fieldset>
    </form>
</div>