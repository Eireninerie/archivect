<?php
include('../php/public_functions.php');
print_r($GLOBALS);
$ID = $_POST['ID'];
echo '<br>'.$ID;
echo "<script class ='javarefresh' src='../js/inputs.js'></script>";
$whereclause = ' WHERE ID= "'.$_POST['ID'].'"';
 Companydeets($whereclause,'');
echo "<script class ='javarefresh'>
$(document).ready(function(){
$('.javarefresh').remove();});</script>";

?>