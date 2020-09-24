<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//echo "User ID:" . $_SESSION["userId"];
?>

<?php
$xml =
    "<select>
<option>Telent</option>
<option>KNN</option>
<option>Virgin</option>
</select>";



$contractOptions = simplexml_load_string($xml);
//print_r($contractOptions);




//$contractOptions->option[1]->addAttribute('newAttr', 12);


//print_r($contractOptions->option);

$timesheetContract = 'KNN';

$optionValues = $contractOptions->option;


for ($i=0 ; $i < count($optionValues) ; $i++) {
    if ($optionValues[$i] == $timesheetContract) {
        echo 'found at index: ' . $i;
        $contractOptions->option[$i]->addAttribute('selected', '');
    }
}

echo $contractOptions->asXML();

?>

