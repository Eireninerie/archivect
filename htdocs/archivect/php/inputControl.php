<?php
include('../php/public_functions.php');
print_r($GLOBALS);
$ID = htmlspecialchars($_POST['ID']);
$mainupdate = explode(",",htmlspecialchars($_POST['main']));
$sectorskeep = htmlspecialchars($_POST['sectorskeep']);
$sectorsdel = htmlspecialchars($_POST['sectorsdel']);
$ethoskeep = htmlspecialchars($_POST['ethoskeep']);
$ethosdel = htmlspecialchars($_POST['ethosdel']);
$addressnew = htmlspecialchars($_POST['addressnew']);
$addressdel = htmlspecialchars($_POST['addressdel']);
$addressupdate = htmlspecialchars($_POST['addressupdate']);

echo '<br>'.$sectorskeep;

$mainupdateSQL = "UPDATE ".$primaryTable." SET
Company = '".$mainupdate[1]."',
CompanySimple = '".$mainupdate[2]."',
website = '".$mainupdate[3]."',
Logo = '".$mainupdate[4]."'
WHERE ID=".$mainupdate[0];
$conn->query($mainupdateSQL);


if ($sectorskeep <> NULL){
    $sectorskeepSQL = "INSERT INTO ".$sectorTable." (CompanyID, Sectors) VALUES ".$sectorskeep;
    $conn->query($sectorskeepSQL);};
$sectorsdelSQL = "DELETE FROM $sectorTable WHERE ID IN $sectorsdelSQL";
$ethoskeepSQL = "INSERT INTO $ethosTable (CompanyID, Sector) VALUES $sectorskeep;";
$ethosdelSQL = "DELETE FROM $ethosTable WHERE ID IN $sectorsdelSQL";
$addressdelSQL = "DELETE FROM $addressTable WHERE ID IN $addressdel";

//$conn->query($sectorskeepSQL);

echo "<script class ='javarefresh' src='../js/inputs.js'></script>";
$whereclause = ' WHERE ID= "'.$ID.'"';
 Companydeets($whereclause,'');
echo "<script class ='javarefresh'>
$(document).ready(function(){
$('.javarefresh').remove();});</script>";

?>