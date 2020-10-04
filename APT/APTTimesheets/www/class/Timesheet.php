<?php
namespace Phppot;


error_reporting(E_ALL);
ini_set("display_errors", 1);


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//use \Phppot\DataSource;


// Integrate PHPMailer functionality into Timesheet class

// Namespace for PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo __DIR__ . '/FileServer.php';

require_once __DIR__ . '/FileServer.php';



class Timesheet
{
    public $timesheetProperties = array();
    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    public function getTimesheetById($timesheetId)
    {
        // get sql info by $id.
        // create and return new Timesheet object
        //$query = "select TimesheetID FROM Timesheets WHERE TimesheetID = ?";
        $query = "SELECT
            Timesheets.TimesheetID,
            Timesheets.Date,
            Timesheets.TimeFrom,
            Timesheets.TimeTo,
            Timesheets.Contract,
            Timesheets.JobNumber,
            Timesheets.Estimate,
            Timesheets.Exchange,
            Timesheets.UserId,
            Timesheets.Status,
            Timesheets.Comments,
            Synthetics.SyntheticID,
            Synthetics.TimesheetID,
            Synthetics.Name,
            Synthetics.Quantity,
            Synthetics.syntheticType,
            Synthetics.Comments as syntheticComments
            FROM Timesheets
            LEFT JOIN Synthetics
            ON Timesheets.TimesheetID=Synthetics.TimesheetID
            WHERE Timesheets.TimesheetId=?";
//        $query = "SELECT
//            Timesheets.TimesheetID,
//            Synthetics.SyntheticID
//
//            FROM Timesheets
//            LEFT JOIN Synthetics
//            ON Timesheets.TimesheetID=Synthetics.TimesheetID
//            WHERE Timesheets.TimesheetId=?";


        //$query = "SELECT * FROM Timesheets LEFT JOIN Synthetics ON Timesheets.TimesheetID=Synthetics.TimesheetID WHERE Timesheets.TimesheetId=?";

//        SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
//FROM Orders
//INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;
        $paramType = "i";
        $paramArray = array($timesheetId);
        $timesheetResult = $this->ds->select($query, $paramType, $paramArray);

        //var_dump($timesheetResult[1]['syntheticType']);

//        foreach ($timesheetResult as $timesheetResult) {
//            print_r($timesheetResult);
//        }
        return $timesheetResult;
    }

    public function getTimesheetsByUserId($userId) {
        // return timesheets by user id.

        $query = "SELECT * FROM Timesheets WHERE UserId = ?";
        $paramType = "i";
        $paramArray = Array($userId);

        $timesheetsResult = $this->ds->select($query, $paramType, $paramArray);

        return $timesheetsResult;

    }

    public function getAssociatedUsersTimesheets($adminUserId) {
        // return timesheets by user id.

        //$query = "SELECT * FROM Timesheets WHERE supervisorId = ?";

        //$query = "SELECT * FROM Timesheets WHERE";
        $query = "SELECT * FROM Timesheets LEFT JOIN registered_users ON Timesheets.UserId = registered_users.id WHERE registered_users.supervisorId=?";
        $paramType = "i";
        $paramArray = Array($adminUserId);

        $timesheetsResult = $this->ds->select($query, $paramType, $paramArray);

        return $timesheetsResult;
    }

    public function getPlannedSynthetics($timesheetResult, $syntheticType) {

        $synthetics = array();

        foreach ($timesheetResult as $timesheetData) {
            foreach ($timesheetData as $key => $value) {
                if ($key == 'syntheticType' && $value == $syntheticType) {

                    switch ($syntheticType) {
                        case 'planned':
                            $synthetics[] = array($timesheetData['Name'], $timesheetData['Quantity']);
                            break;
                        case 'unplanned':
                            //$synthetics[] = array($timesheetData['Name'], $timesheetData['Quantity'], 'comment for unplanned');
                            $synthetics[] = array($timesheetData['Name'], $timesheetData['Quantity'], $timesheetData['syntheticComments']);
                            break;
                    }

                }
            }
        }
        return $synthetics;
    }



    public function setTimesheetValuesByAssocArray($tsVals)
    {
        /* Assign form values to this objects values. */


        if (
            //array_key_exists('name', $tsVals) &&
            array_key_exists('datetime', $tsVals) &&
            array_key_exists('contract', $tsVals) &&
            array_key_exists('jobnumber', $tsVals) &&
            array_key_exists('estimate', $tsVals) &&
            array_key_exists('exchange', $tsVals)
            //array_key_exists('plannedsynthetic', $tsVals)
            //array_key_exists('unplannedsynthetic', $tsVals)
        ) {
            //echo "All required keys exist.";

            //$this->timesheetProperties['name'] = $tsVals['name'];

            $this->timesheetProperties['date'] = $tsVals['datetime'][0]["'date'"];
            $this->timesheetProperties['timefrom'] = $tsVals['datetime'][0]["'timefrom'"];
            $this->timesheetProperties['timeto'] = $tsVals['datetime'][0]["'timeto'"];

            $this->timesheetProperties['contract'] = $tsVals['contract'];
            $this->timesheetProperties['jobnumber'] = $tsVals['jobnumber'];
            $this->timesheetProperties['estimate'] = $tsVals['estimate'];
            $this->timesheetProperties['exchange'] = $tsVals['exchange'];

            $this->timesheetProperties['plannedsynthetic'] = $tsVals['plannedsynthetic'];
            $this->timesheetProperties['unplannedsynthetic'] = $tsVals['unplannedsynthetic'];

            $this->timesheetProperties['comments'] = $tsVals['timesheetcomments'];

            //print $this->timesheetProperties['timeto'];
            //$this->printTimesheetProperties();

        } else {
            echo "Required keys missing";

        }
    }

    /*
     * Print out timesheet properties in a friendly format.
     */
    public function printTimesheetProperties() {
            foreach ($this->timesheetProperties as $property => $value) {
                echo "<br><b>Property : </b>" . $property . " ";
                echo "<b>Value : </b>" . $value;
            }
    }

    public function saveTimesheet()
    {
        /* Save timesheet data */
        $query = "INSERT INTO Timesheets (Date, TimeFrom, TimeTo, Contract, JobNumber, Estimate, Exchange, UserId, Status, Comments)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //$query = "select * FROM registered_users WHERE id = ?";
        $paramType = "sssssssiss";
        $paramArray = array(
            $this->timesheetProperties['date'],
            $this->timesheetProperties['timefrom'],
            $this->timesheetProperties['timeto'],
            $this->timesheetProperties['contract'],
            $this->timesheetProperties['jobnumber'],
            $this->timesheetProperties['estimate'],
            $this->timesheetProperties['exchange'],
            $_SESSION["userId"],
            'pending',
            $this->timesheetProperties['comments']
        );
        $currentTimesheetID = $this->ds->insert($query, $paramType, $paramArray);
        //echo "timesheet ID : " . $currentTimesheetID;

        /* Save synthetic details */

        /*
         * Save planned synthetic
         */
//        $syntheticName = $this->timesheetProperties['plannedsynthetic'][1]["'plannedsynthetic'"];
//        $syntheticQuantity = $this->timesheetProperties['plannedsynthetic'][1]["'quantity'"];
//
//        $query = "INSERT INTO Synthetics (TimesheetID, Name, Quantity, syntheticType)
//          VALUES (?, ?, ?, ?)";
//        $paramType = "isis";
//        $paramArray = array($currentTimesheetID, $syntheticName, $syntheticQuantity, 'planned');
//        $memberResult = $this->ds->insert($query, $paramType, $paramArray);
        $this->savePlannedSynthetics($currentTimesheetID);

        /*
         * Save unplanned synthetic
         *
         */
//        $syntheticName = $this->timesheetProperties['unplannedsynthetic'][1]["'unplannedsynthetic'"];
//        $syntheticQuantity = $this->timesheetProperties['unplannedsynthetic'][1]["'quantity'"];
//
//        $query = "INSERT INTO Synthetics (TimesheetID, Name, Quantity, syntheticType)
//          VALUES (?, ?, ?, ?)";
//        $paramType = "isis";
//        $paramArray = array($currentTimesheetID, $syntheticName, $syntheticQuantity, 'unplanned');
//        $memberResult = $this->ds->insert($query, $paramType, $paramArray);
        $this->saveUnplannedSynthetics($currentTimesheetID);




        //$syntheticQuantity = $this->timesheetProperties['plannedsynthetic'][1];

        $adminEmail = 'nvrwdu@hotmail.com';

        //dispatch email to submitter
        $this->sendMailTo($_SESSION["userEmail"],
            'APT',
            'You\'ve submitted a new timesheet',
            'Once reviewed, you\'ll receive a email update'
        );


        //dispatch email to submitters admin
        $this->sendMailTo($adminEmail,
            'APT',
            'New timesheet submitted',
            'Please check account to check timesheet'
        );

        return $currentTimesheetID;
    }

    private function savePlannedSynthetics($currentTimesheetID) {
        //echo 'printing values:';
        //print_r($this->timesheetProperties['plannedsynthetic'][2]);

//        $syntheticName = $this->timesheetProperties['plannedsynthetic'][1]["'plannedsynthetic'"];
//        $syntheticQuantity = $this->timesheetProperties['plannedsynthetic'][1]["'quantity'"];

        foreach ($this->timesheetProperties['plannedsynthetic'] as $plannedSynthetic) {
            $syntheticName = $plannedSynthetic["'plannedsynthetic'"];
            $syntheticQuantity = $plannedSynthetic["'quantity'"];

            $query = "INSERT INTO Synthetics (TimesheetID, Name, Quantity, syntheticType)
          VALUES (?, ?, ?, ?)";
            $paramType = "isis";
            $paramArray = array($currentTimesheetID, $syntheticName, $syntheticQuantity, 'planned');
            $memberResult = $this->ds->insert($query, $paramType, $paramArray);
        }
    }

    private function saveUnplannedSynthetics($currentTimesheetID) {
        //print_r($ts->timesheetProperties['unplannedsynthetic']);

//        foreach ($ts->timesheetProperties['unplannedsynthetic'] as $unplannedSynthetic) {
//            print_r($unplannedSynthetic["'unplannedsynthetic'"]);
//            print_r($unplannedSynthetic["'quantity'"]);
//            print_r($unplannedSynthetic["'comments'"]);
//
//        }

        foreach ($this->timesheetProperties['unplannedsynthetic'] as $unplannedSynthetic) {
            $syntheticName = $unplannedSynthetic["'unplannedsynthetic'"];
            $syntheticQuantity = $unplannedSynthetic["'quantity'"];
            $syntheticComments = $unplannedSynthetic["'comments'"];


            $query = "INSERT INTO Synthetics (TimesheetID, Name, Quantity, syntheticType, Comments)
          VALUES (?, ?, ?, ?, ?)";
            $paramType = "isiss";
            $paramArray = array($currentTimesheetID, $syntheticName, $syntheticQuantity, 'unplanned', $syntheticComments);
            $memberResult = $this->ds->insert($query, $paramType, $paramArray);
        }
    }


    public function changeTimesheetStatus(int $timesheetId, string $newStatus) {

        /*
         * Send message to timesheet submitter, their timesheet has been rejected
         *
         * Check if current user is admin
         * Change timesheet status to rejected
         * Send email to timesheets submitter, with reason for rejection
         */

        if ($_SESSION["userType"] == 'submitter' or $_SESSION["userType"] == 'admin' or $_SESSION["userType"] == 'superadmin') {

            // Update timesheet status
            $query = "UPDATE Timesheets SET Status = '{$newStatus}' 
            WHERE TimesheetID = ?";
            $paramType = "i";
            $paramArray = array($timesheetId);
            echo $timesheetStatusResult = $this->ds->insert($query, $paramType, $paramArray);

            // Get timesheet submitter email address
            $query = "SELECT Timesheets.TimesheetID, registered_users.email
                        FROM Timesheets
                        INNER JOIN registered_users ON Timesheets.userId = registered_users.id
                        WHERE Timesheets.TimesheetID = ?";
            $paramType = "i";
            $paramArray = array($timesheetId);
            $timesheetEmailResult = $this->ds->select($query, $paramType, $paramArray);
            $emailOfSubmitter = $timesheetEmailResult[0]['email']; // Holds email of timesheet submitter

            // Send email to the timesheets submitter
            // Get message, depending on timesheet status
            $mailSubject = '';
            $mailBody = '';
            switch (lcfirst($newStatus)) {
                case 'approve' :
                    $mailSubject = "New timesheet $timesheetId accepted.";
                    $mailBody = "Timesheet : $timesheetId accepted. Thank you.";
                    break;
                case 'reject' :
                    $mailSubject = "New timesheet $timesheetId rejected.";
                    $mailBody = "Timesheet : $timesheetId rejected. Please login and amend.";
                    break;
                default:
                    $mailSubject = "Err: Nor accept nor reject";
                    $mailBody = "Err: Nor accept nor reject";


            }

            $this->sendMailTo($emailOfSubmitter,
                'APT Gang Member',
                $mailSubject,
                $mailBody
            );


        } else {
            echo "Wrong user type. Cannot perform rejection amendment";
        }

    }







    /*
     * Send mail to submitter
     */
    public function sendMailTo($email, $name, $subject = '', $body = '')
    {
        /* Dispatch email with timesheet data */

        //PHPMailer Object
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions


        //smtp config
        $mail->isSMTP();

        // GMail SMTP Settings
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nvrwdu@gmail.com';
        $mail->Password =  '((Pi3141))';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->From = "nvrwdu@hotmail.com";
        $mail->FromName = "Mohammed Amir";

        $mail->AddAddress("$email", "$name");


        $mail->isHTML(true);

        $mail->Subject = $subject;
        //$mail->addEmbeddedImage('path/to/image_file.jpg', 'image_cid');

        // Mail template. Different if user is admin
//        if($isAdmin) {
//            $mailTemplate = "<b>Admin, a new timesheet has been submitted. Please check inbox</b>";
//        } else {
//            $mailTemplate = "<b>Thank you for submitting your timesheet. You will be notified of any status updates.";
//        }

                //<b><br><br><br><br>
//        $name<br>
//        $contract<br>
//        $jobnumber<br>
//        $estimate<br>
//        $exchange<br>
//        $email<br>

        // $mail->Body = '<b>Mail body in HTML. Message sent successfully<b>';
        $mail->Body = $body;
        $mail->AltBody = 'This is the plain text version of the email content';

        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }

        $mail->smtpClose();
    }

    /*
     * Returns  array of image data dictionaries.
     */
    public function getTimesheetImagesData($timesheetId)
    {

        $imagesData = array();

        $query = "SELECT TimesheetImageData FROM TimesheetImageData WHERE TimesheetId = ?";
        $paramType = "i";
        $paramArray = array($timesheetId);
        $timesheetImagesResult = $this->ds->select($query, $paramType, $paramArray);

//        foreach ($timesheetImagesResult as $timesheetImageResult) {
//            array_push($imagesData, json_decode($timesheetImageResult, true));
//        }

        for ($i=0 ; $i<count($timesheetImagesResult) ; $i++) {
            array_push($imagesData, json_decode($timesheetImagesResult[$i]['TimesheetImageData'], true));
            //echo gettype($timesheetImagesResult[$i]['TimesheetImageData']);
        }



        return $imagesData;
    }


    /*
     * imagesData : Array of image data dictionaries. (From Cloudinary return values)
     */
    public function saveTimesheetImagesData($timesheetId, $timesheetPaths = array()) {

        $imagesData = array(); // Holds image data from Cloudinary

        // Upload each file from dir, to host on FileServer
        for ($i=0 ; $i<count($timesheetPaths) ; $i++) {
            array_push($imagesData, FileServer::upload($timesheetPaths[$i])) ;
        }

        foreach ($imagesData as $imageData) {
            $encodedImageData = json_encode($imageData);
            //            echo "image data: " . $encodedImageData;
            //            echo "image data : " . $imageData;

            $query = 'INSERT INTO TimesheetImageData (TimesheetId, TimesheetImageData) VALUES (?, ?)';
            $paramType = "is";
            $paramArray = array($timesheetId, $encodedImageData);
            $insertQueryResult = $this->ds->insert($query, $paramType, $paramArray);
        }

        return $insertQueryResult;
    }





}

//echo $_SESSION['userId'];

/* Testing Timesheets.php */


// TEST : Get and output timesheet data

//$timesheet = new Timesheet();
//$result = $timesheet->getTimesheetById(1);
//echo "FROM TIMESHEET.PHP" . print_r($result);
//
//$timesheet->saveTimesheet();


//  Print timesheets for user
//foreach ($timesheets as $timesheet) {
//    foreach ($timesheet as $key => $value) {
//        echo  "<br>" . "key: " . $key . " Value: " . $value;
//    }
//}


//if (! empty($_SESSION["userId"])) {
//    require_once __DIR__ . './../class/Member.php';
//    $member = new Member();
//    $memberResult = $member->getMemberById($_SESSION["userId"]);
//    if(!empty($memberResult[0]["display_name"])) {
//        $displayName = ucwords($memberResult[0]["display_name"]);
//    } else {
//        $displayName = $memberResult[0]["user_name"];
//    }
//}


// Testing timesheet synthetic output from inner join query
//$timesheet = new Timesheet();
//$timesheetResult = $timesheet->getTimesheetById(60);
//print_r($timesheetResult[1]['syntheticType']);
//print_r($timesheetResult[1]);


//foreach ($timesheetResult as $timesheet) {
//    echo $timesheet . '<br>';
//}


//foreach ($timesheetResult as $key => $value) {
//    echo '<br><b>' . $key . '</b>';
//    echo $value . '<br>';
//}

//$timesheet = new Timesheet();
//$timesheet->sendMailTo('nvrwdu@hotmail.com', 'APT', 'New timesheet submitted',
//    'Thank you submitter, for new timesheet');

// Test getting all associated timesheets for the currently logged in user
//$timesheet = new Timesheet();
//$timesheet->timesheetRejected(71);
//print_r($timesheet->getAssociatedUsersTimesheets(1));

// Timesheet comments were not rendering
//$timesheet = new Timesheet();
//$timesheetResult = $timesheet->getTimesheetById(92);
//print_r($timesheetResult);



/**
 * Output an image in HTML along with provided caption and public_id
 *
 * @param        $img
 * @param array  $options
 * @param string $caption
 */
function show_image($img, $options = array(), $caption = '')
{
    $options['format'] = $img['format'];
    $transformation_url = cloudinary_url($img['public_id'], $options);

    echo '<div class="item">';
    echo '<div class="caption">' . $caption . '</div>';
    echo '<a href="' . $img['url'] . '" target="_blank">' . cl_image_tag($img['public_id'], $options) . '</a>';
    echo '<div class="public_id">' . $img['public_id'] . '</div>';

    echo '<div class="link"><a target="_blank" href="' . $transformation_url . '">' . $transformation_url . '</a></div>';
    echo '</div>';
}

/*
 * Usage
 *
 * FileServer::upload('dir/to/file')
 *
 */




// Test Upload Timesheet to server
//$img = FileServer::upload('forest-x.jpg'); // Upload to Cloudinary

//echo getcwd();
//
//$timesheet = new Timesheet();
////$timesheet->saveTimesheetImageData(49, $img);
////$timesheet->saveTimesheetImagesData(49, array($img, $img, $img));
//$timesheet->saveTimesheetImagesData(50, array('forest-x.jpg'));
//$timesheet->saveTimesheetImagesData(50, array('forest-x.jpg'));
//$timesheet->saveTimesheetImagesData(50, array('forest-x.jpg'));
//
//echo '<br>';
//
////print_r($timesheet->getTimesheetImageData(49)[0]['TimesheetImageData']);
//
////$timesheetDataDecoded = json_decode($timesheet->getTimesheetImageData(49)[0]['TimesheetImageData'], true);
//$timesheetImages = $timesheet->getTimesheetImagesData(50);
//
//for ($i=0 ; $i<count($timesheetImages) ; $i++) {
//    echo '<br>' . $timesheetImages[0]['url'] . '<br>';
//}
//echo "END";



//show_image($img);