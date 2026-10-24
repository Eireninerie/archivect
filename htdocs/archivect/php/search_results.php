<?php	
// echo "WOAH";
include('./public_functions.php');

$SectorListRatings = filter_var($_POST['SectorList'], FILTER_SANITIZE_NUMBER_INT);
$EthosListRatings = filter_var($_POST['EthosList'], FILTER_SANITIZE_NUMBER_INT);
$DistanceListRatings= preg_replace('/[A-Za-z]*[\d]+/', '"$0"', preg_replace('/[^a-zA-Z\d\(\)\,]/',"",$_POST['DistanceList']));
$SizesListRatings= filter_var($_POST['SizesList'], FILTER_SANITIZE_NUMBER_INT);

include('../SQLtests/SQLs.php'); 


//  temp table construction for distance ratings

function cardDetails($tableName,$columnName,$row,$sub){

	echo "	<ul class='c_".$columnName."'>	";
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
			";}} else {echo "not yet listed/unknown";}
	echo "
	</ul>
	";
}

function cardResults(){
	global $conn, $addressTable, $ratingSortSQL, $sectorTable,$sizeTypeSQL,$ethosTable;
	$ratingSort = $conn->query($ratingSortSQL);
	if ($ratingSort->num_rows > 0){
		while($row = $ratingSort->fetch_assoc()){
			echo "
				<div class='card' id='".$row["ID"]."'>		
				<h3> <a href='https://".$row["website"]."' alt='". $row["Company"]." website link' title='https://".$row["website"]."'>". $row["Company"]. "</a></h3>
				<img class='logo' src='".$row["logo"]."'>
				<div class='cardDetails hiddenClass' id='".$row["ID"]."'>
				
				<h3><b><button type='button' class='exitcard'>x</button> ". $row["Company"]. "</b></h3>
				<img class='logo' src='".$row["logo"]."'>
				<h3>Sectors</h3>
				<div>";
			cardDetails($sectorTable,"sectors",$row["ID"],1);
			echo "</div><h3>Ethos</h3><div>";
			cardDetails($ethosTable,"ethos",$row["ID"],1);
			echo "</div><h3>Locations</h3><div>";
			cardDetails($addressTable,"town",$row["ID"],0);
			echo "</div></div></div>
			";
		}
	} else {
		echo "x";
	}

	$conn->close();
}

cardResults();
	?>
