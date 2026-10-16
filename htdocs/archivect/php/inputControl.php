<?php
include('../php/public_functions.php');
print_r($GLOBALS);

function sanitisesubs($string){
    //take out anything that isnt (0,0)
    return preg_replace("/[^\d\,\(\)]/","",$string);
}
function sanitiseaddress($string){
    //place valid postcodes and locations into quotes
    return preg_replace('/[A-Z][A-Za-z\-]+[a-z][\,\s]*[A-Za-z\-]*[a-z]|[a-zA-Z]+[\s\d]+[a-zA-Z]+/', '"$0"', 
        //remove invalid characters
        preg_replace('/[^a-zA-Z\d\(\)\,\s\-]/',"", $string)
    );
}

$mainupdate = explode(",",$_POST['main']);
$ID = filter_var($mainupdate[0], FILTER_SANITIZE_NUMBER_INT);
$mainupdate[1] = preg_replace('/[^\dA-Za-z\&\+\/\x{00C0}-\x{024F}]+/',"",$mainupdate[1]);
$mainupdate[2] = preg_replace('/[^A-Za-z\+]+/',"",$mainupdate[2]);
$mainupdate[3] = filter_var($mainupdate[3], FILTER_SANITIZE_URL);
$mainupdate[4] = filter_var($mainupdate[4], FILTER_SANITIZE_URL);
$sectorskeep = sanitisesubs($_POST['sectorskeep']);
$sectorsdel = sanitisesubs($_POST['sectorsdel']);
$ethoskeep = sanitisesubs($_POST['ethoskeep']);
$ethosdel = sanitisesubs($_POST['ethosdel']);
$addressdel = sanitisesubs($_POST['addressdel']);
$addressupdate = sanitiseaddress($_POST['addressupdate']);


$addresstest = $_POST['addressnew'];
echo '<p>'.$addresstest.' oop '.sanitiseaddress( $addresstest).'</p>';

echo '<p>'.$ethoskeep.'</p>';


$mainupdateSQL = "UPDATE ".$primaryTable." SET
Company = '".$mainupdate[1]."',
CompanySimple = '".$mainupdate[2]."',
website = '".$mainupdate[3]."',
Logo = '".$mainupdate[4]."'
WHERE ID=".$ID;
$conn->query($mainupdateSQL);


if ($sectorskeep <> NULL){
    $sectorskeepSQL = "INSERT INTO ".$sectorTable." 
        (CompanyID, Sectors) 
        VALUES ".$sectorskeep;
//    echo "<p>". $sectorskeepSQL;
    $conn->query($sectorskeepSQL);
    };
if ($sectorsdel <> '()'){
    $sectorsdelSQL = "DELETE FROM ".$sectorTable." WHERE Sectors IN ".$sectorsdel." AND CompanyID =".$ID ;
//    echo "<p>".$sectorsdelSQL;
    $conn->query($sectorsdelSQL);
    };
if ($ethoskeep <> NULL){
    $ethoskeepSQL = "INSERT INTO ".$ethosTable." 
        (CompanyID, Ethos) 
        VALUES ".$ethoskeep;
//    echo "<p>". $ethoskeepSQL;
    $conn->query($ethoskeepSQL);
    };
if ($ethosdel <> '()'){
    $ethosdelSQL = "DELETE FROM ".$ethosTable." WHERE Ethos IN ".$ethosdel." AND CompanyID =".$ID ;
//    echo "<p>".$ethosdelSQL;
    $conn->query($ethosdelSQL);
    };

if ($addressdel <> '()'){
    $addressdelSQL = "DELETE FROM ".$addressTable." WHERE ID IN ".$addressdel;
//    echo '<p>'.$addressdelSQL;
    $conn->query($addressdelSQL);
    };
if ($addressupdate <> NULL){
    $addressupdate = "INSERT INTO `addresses`( `CompanyID`,`ID`, `Town`, `Postcode`)
VALUES(".$addressupdate.")
ON DUPLICATE KEY
UPDATE `Town`=VALUES(`Town`), `Postcode` = VALUES(`Postcode`), `CompanyID` = VALUES(`CompanyID`);
";
    echo "</p>".$addressupdate."<p>". $addressupdateSQL;
//    $conn->query($ethoskeepSQL);
    };

$whereclause = ' WHERE ID= "'.$ID.'"';
 Companydeets($whereclause,'');


?>