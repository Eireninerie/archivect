<?php

function xList($type,$table){
	global $conn;
	$QuerySQL = "SELECT ID, Name FROM ".$table." ORDER BY Name ASC";
//	echo $QuerySQL;
	$Query = $conn->query($QuerySQL);
	while($row = $Query->fetch_assoc()){

	echo "<label for=".$type.$row["ID"].">".$row["Name"]."</label>";
	rating($type,$type.$row["ID"]);
	echo "</br>";}
}
function distanceSQL(){
	return 'SELECT';
	}

$postVarRatingSQL = "
SELECT ID, Rating, postStart, postEnd,
coordStart.EASTING AS coordSE,
coordStart.Northing AS coordSN,
ROUND(
		SQRT(
			power(ABS(coordStart.EASTING - coordEnd.Easting),2)+
			power(ABS(coordStart.Northing - coordEnd.Northing),2)
		)/1000
	,2) AS totalDistance

FROM 
	".$postcodeRefTable." AS coordStart 
	RIGHT JOIN ".$distanceInputTable." ON postStart = coordStart.Postcode_district
	LEFT JOIN ".$postcodeRefTable." AS coordEnd ON postEnd = coordEnd.Postcode_district";

global $sectorListTable;

echo "
<script src='./js/searchbar.js'></script>
<form id='Search'><h3>Sectors</h3><div id='SectorList'>";
echo xList("Sector",$sectorListTable);
echo '</div>';
echo '
    <table id="DistanceTable"><h3>Search Radius</h3>
        <tr>
          <th></th>  
          <th>Centre</th>
            <th>Radius</th>
            <th>Distance</th>
            <th>Rating</th>
            
        </tr>
      <tr>
        <td><button id="addPosts" type="button">+</button></td>
      	<td><input type="text" id="postStartInput" maxLength="4" placeholder="eg. B77" required></td>
        <td><input type="text" id="postEndInput" maxLength="4" placeholder="eg. EN6" required></td>

    </table>


    ';


echo "<h3>Ethos</h3><div id='EthosList'>";
echo xList("EthosList",$ethosListTable);
echo "</div>";

echo "<h3>Size</h3><div id='SizesList'>";
function Bands($y,$z){
	echo '<label>'.$y.'</label>';
	rating("Sizes",$z);
	echo "</br>";
}

Bands("One Office","UK1");
Bands("2-4 Offices: UK","UK2");
Bands("5+ Offices: UK","UK3");
Bands("2-4 Offices: International","IN2");
Bands("5+ Offices: International","IN3");

echo "</div>";
?>
<button id="testButton" type="button">test</button>
<div id="testCont">test container</div>
<button id="submitButton" type="button">Submit Search</button>
</form>
