<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = "test";

//temp inputs
$distanceInputTable = "Inputs_distance";

//database tables
$postcodeRefTable = "postcodeCoordsEN";
$primaryTable = "firms";
$addressTable = "addresses";
$sectorTable = "sectors";

$sectorListTable = "sectorsList";
$ethosListTable = "firm_valuesList";
$socialsListTable = "socialsList";

$conn = new mysqli($host,$username,$password,$dbname);
if (!$conn) {
	die('Connection failed: '.mysqli_connect_error());
	}
//echo 'Connected successfully';
	
function rB($x,$y,$z,$w,$v)
              {echo '<input type="radio" class="'.$x.'" name="'.$y.'" value="'.$z.'" title="'.$w.'" '.$v.'>';}
             
           
function rating($ID,$Name){
	rB($ID,$Name,"1","avoid","").	
	rB($ID,$Name,"2","ambivalent","checked='checked'").
	rB($ID,$Name,"3","fine","").
	rB($ID,$Name,"4","like","").
	rB($ID,$Name,"5","best","");
}



?>
