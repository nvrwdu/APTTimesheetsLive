<?php

require_once './Member.php';

$memberHandler = new \Phppot\Member();

$handle = fopen("gangcontacts2019.csv", "r");

$newUserArray = array();

$lineNumber = 1;

if ($handle) {

    // Skip first line. Ugly working solution.
    while (($line = fgets($handle)) !== false) {
        if ($lineNumber == 1) {
            $lineNumber = 2;
            continue;
        }

        // process the line read.
        $line = explode(',', $line);

            // Create new user by associated array
            $userName = trim($line[3]); // Email address as username
            $newUserArray['user_name'] = $userName;

            $displayName = explode(' ', $line[1]);
            $firstName = ucfirst(strtolower($displayName[0])) ;
            $newUserArray['display_name'] = $firstName;


            $specialChars = explode(" ", "! @ £ % ( )");
            $randSpecialCharIndex = array_rand($specialChars);
            $newUserArray['password'] = rand(2851, 9999) . $specialChars[$randSpecialCharIndex];

            $newUserArray['email'] = trim($line[3]);

            $newUserArray['user_type'] = 'submitter';
            $newUserArray['supervisorId'] = 1;

        echo '<br> new user array : <br>';
        echo ($newUserArray['user_name']) . ' ';
        echo ($newUserArray['password']) . '<br>';




        $memberHandler->createNewMember($newUserArray);
    }


    //$newMemberDetails =
//[
//    'user_name'=>'smith',
//    'display_name'=>'Mr Smith',
//    'password'=>'password',
//    'email'=>'email@email.com',
//    'user_type'=>'submitter',
//    'supervisorId'=>1
//];

    fclose($handle);
} else {
    // error opening the file.
}



