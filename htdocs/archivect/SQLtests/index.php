<?php
include('../php/public_functions.php');
include('../php/header.php');

$addressTable = "testingaddress";
$sectorTable = "testingsectors";
$distanceInputTable = "distanceInputs";
$primaryTable = "testing";

include('../SQLtests/SQLs.php');

//


//total print
	global $ratingSortSQL;
	$ratingSort = $conn->query($ratingSortSQL);
	if ($ratingSort->num_rows > 0){
		while($row = $ratingSort->fetch_assoc()){
			echo "
			<div class='card'>		
			<img class='logo' src='".$row["logo"]."'><p> <a href='https://".$row["website"]."'>". $row["Company"]. "</a><br>
			";
				cardDetails($addressTable,"town",$row["ID"],0);
				cardDetails($sectorTable,"sector",$row["ID"],1);
			echo "</p></div>
			";
		}
	} else {
		echo "x";
	}

	$conn->close();
?>

