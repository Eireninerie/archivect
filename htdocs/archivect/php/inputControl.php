<?php
include('../php/public_functions.php');
// print_r($GLOBALS);

function validatesubs($string){
    $invalid = preg_match("/[^\d\x{002c}\x{0028}\x{0029}]/u",htmlspecialchars($string));
    if ($invalid == 0){return $string;};
}

$ID = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);
$mainupdate = explode(",",htmlspecialchars($_POST['main']));
$sectorskeep = validatesubs($_POST['sectorskeep']);
$sectorsdel = validatesubs($_POST['sectorsdel']);
$ethoskeep = validatesubs($_POST['ethoskeep']);
$ethosdel = validatesubs($_POST['ethosdel']);
$addressnew = htmlspecialchars($_POST['addressnew']);
$addressdel = validatesubs($_POST['addressdel']);
$addressupdate = htmlspecialchars($_POST['addressupdate']);

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