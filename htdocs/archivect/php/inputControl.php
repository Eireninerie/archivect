<?php
include('../php/public_functions.php');
print_r($GLOBALS);

function sanitisesubs($string){
    return preg_replace("/[^\d\,\(\)]/u","",$string);
}
function sanitiseaddress($string){
    return preg_replace('/[a-zA-Z]+[\s\d]*/', '"$0"', preg_replace('/[^a-zA-Z\d\(\)\,\s]/',"", $string));
}

$ID = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
$mainupdate = explode(",",$_POST['main']);
$sectorskeep = sanitisesubs($_POST['sectorskeep']);
$sectorsdel = sanitisesubs($_POST['sectorsdel']);
$ethoskeep = sanitisesubs($_POST['ethoskeep']);
$ethosdel = sanitisesubs($_POST['ethosdel']);
$addressnew = sanitiseaddress($_POST['addressnew']);
$addressdel = sanitisesubs($_POST['addressdel']);
$addressupdate = sanitiseaddress($_POST['addressupdate']);


$addresstest = $addressupdate;
echo '<p> oop '.sanitiseaddress($addresstest).'</p>';

echo '<p>'.$ethoskeep.'</p>';


$mainupdateSQL = "UPDATE ".$primaryTable." SET
Company = '".$mainupdate[1]."',
CompanySimple = '".$mainupdate[2]."',
website = '".filter_var($mainupdate[3], FILTER_SANITIZE_URL)."',
Logo = '".filter_var($mainupdate[4], FILTER_SANITIZE_URL)."'
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
    $addressdelSQL = "DELETE FROM $addressTable WHERE ID IN $addressdel";
//    echo '<p>'.$addressdelSQL;
    $conn->query($addressdelSQL);
    };


$whereclause = ' WHERE ID= "'.$ID.'"';
 Companydeets($whereclause,'');


?>