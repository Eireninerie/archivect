<?php
include('../php/public_functions.php');
$whereclause = ' WHERE ID= "'.$_POST['ID'].'"';
//echo $whereclause;
 Companydeets($whereclause,'');

?>