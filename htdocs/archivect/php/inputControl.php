<?php
include('../php/public_functions.php');
print_r($GLOBALS);
$ID = htmlspecialchars($_POST['ID']);
$main = htmlspecialchars($_POST['main']);
$sectorskeep = htmlspecialchars($_POST['sectorskeep']);
$sectorsdel = htmlspecialchars($_POST['sectorsdel']);
$ethoskeep = htmlspecialchars($_POST['ethoskeep']);
$ethosdel = htmlspecialchars($_POST['ethosdel']);
$addressnew = htmlspecialchars($_POST['addressnew']);
$addressdel = htmlspecialchars($_POST['addressdel']);
$addressupdate = htmlspecialchars($_POST['addressupdate']);

echo '<br>'.$addressupdate;

echo "<script class ='javarefresh' src='../js/inputs.js'></script>";
$whereclause = ' WHERE ID= "'.$ID.'"';
 Companydeets($whereclause,'');
echo "<script class ='javarefresh'>
$(document).ready(function(){
$('.javarefresh').remove();});</script>";

?>