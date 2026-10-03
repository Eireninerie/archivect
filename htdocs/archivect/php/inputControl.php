<?php
include('../php/public_functions.php');
echo "<script class ='javarefresh' src='../js/inputs.js'></script>";
$whereclause = ' WHERE ID= "'.$_POST['ID'].'"';
 Companydeets($whereclause,'');
echo "<script class ='javarefresh'>
$(document).ready(function(){
$('.javarefresh').remove();});</script>";

?>