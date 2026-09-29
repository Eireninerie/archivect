<?php	
// echo "WOAH";
include('./public_functions.php');

$SectorListRatings = $_POST['SectorList'];
$EthosListRatings = $_POST['EthosList'];
$DistanceListRatings= $_POST['DistanceList'];
$SizesListRatings= $_POST['SizesList'];

include('../SQLtests/SQLs.php'); 



//  temp table construction for distance ratings

function cardDetails($tableName,$columnName,$row,$sub){

	echo "	<ul class='c_".$columnName."s'>	";
	global $conn;
	if ($sub == 1){
		$joinclause = "LEFT JOIN ".$columnName."List ON ".$columnName."List.ID = ".$columnName."";
		$rowvalue= "Name";}
	else {
		$joinclause = null; 
		$rowvalue=$columnName;}
	$whereclause = "WHERE ". $row ." = ".$tableName.".CompanyID";

	$SQL = "SELECT CompanyID, ".$rowvalue." FROM ".$tableName." ".$joinclause." ".$whereclause." ";
		$result = $conn->query($SQL);
			if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
			echo "
			<li>".$row["".$rowvalue.""]."</li>
			";}} else {echo "x";}
	echo "
	</ul>
	";
}

function cardResults(){
	global $conn, $addressTable, $ratingSortSQL, $sectorTable,$sizeTypeSQL;
	$ratingSort = $conn->query($ratingSortSQL);
	if ($ratingSort->num_rows > 0){
		while($row = $ratingSort->fetch_assoc()){
			echo "
				<div class='card'>		
				<img class='logo' src='".$row["logo"]."'><p> <a href='https://".$row["website"]."' alt='". $row["Company"]." website link' title='https://".$row["website"]."'>". $row["Company"]. "</a><br>
				<p>".$row["totalRating"]."</p>
				";
			cardDetails($sectorTable,"sectors",$row["ID"],1);
			cardDetails($addressTable,"town",$row["ID"],0);

			echo "</p></div>
			";
		}
	} else {
		echo "x";
	}

	$conn->close();
}

cardResults();
	?>
