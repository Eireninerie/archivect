<?php
include('./public_functions.php');

$postStart = $_GET['postStart'];
$postEnd = $_GET['postEnd'];
if (empty($postStart) or empty($postEnd)) {
}
else {


// get input coordinates as km

function coord($postCode,$EN){
	global $conn, $postcodeRefTable;
	$distanceQuerySQL = "SELECT ".$EN." FROM ".$postcodeRefTable." WHERE postcode_district = '".$postCode."'";
//	echo $distanceQuerySQL;
	return $conn->query($distanceQuerySQL)->fetch_object()->$EN / 1000;
	}
		
// get distance between coordinates

function distanceKm($postStart,$postEnd){ 
	$psE = coord($postStart,'EASTING');
	$peE = coord($postEnd,'EASTING');
	$psN = coord($postStart,'NORTHING');
	$peN = coord($postEnd,'NORTHING');
	return round(sqrt(pow(abs( $psE - $peE ),2) + POW(ABS( $psN - $peN ),2)));}
	
echo "
	<td><button onclick='deleteData(this)'>-</button></td>
	<td><input type='text' class='postStart' name='postStart' value=".$postStart." readonly></td>
	<td><input type='text' class='postEnd' name='postEnd' value=".$postEnd." readonly></td>
	<td>".distanceKM($postStart,$postEnd)."km</td>
	<td>";
rating('Rating',$postEnd.$postStart);
echo "</td>";
}
?>
