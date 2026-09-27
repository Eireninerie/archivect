<?php

function xList($type,$table){
	global $conn;
	$QuerySQL = "SELECT ID, Name FROM ".$table." ORDER BY Name ASC";
//	echo $QuerySQL;
	$Query = $conn->query($QuerySQL);
	while($row = $Query->fetch_assoc()){

	echo "<tr><td><label for=".$type.$row["ID"].">".$row["Name"]."</label></td><td>";
	rating($type,$type.$row["ID"]);
	echo "</td></tr>";}
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
<form ><table id='SectorList'>";
echo xList("Sector",$sectorListTable);
echo "</table>";

echo '
    <table id="DistanceTable">
        <tr>
          <th></th>  
          <th>Starting Postcode</th>
            <th>Furthest Radius Postcode</th>
            <th>Distance</th>
            <th>Rating</th>
            
        </tr>
      <tr>
        <td><button id="addPosts" type="button">+</button></td>
      	<td><input type="text" id="postStartInput" maxLength="4" placeholder="eg. B77" required></td>
        <td><input type="text" id="postEndInput" maxLength="4" placeholder="eg. EN6" required></td>

    </table>


    ';


echo "<table id='EthosList'>";
echo xList("EthosList",$ethosListTable);
echo "</table>";

echo "<table id='SizesList'>";
function Bands($y,$z){
	echo "<tr><td>".$y."</td><td>";
	rating("Sizes",$z);
	echo "</td></tr>";
}

Bands("One Office","UK1");
Bands("2-4 Offices: UK Primarily","UK2");
Bands("5+ Offices: UK Primarily","UK3");
Bands("2-4 Offices: International Primarily","IN2");
Bands("5+ Offices: International Primarily","IN3");

echo "</table>";
?>
<button id="testButton" type="button">test</button>
<div id="testCont">test container</div>
<button id="submitButton" type="button">Submit Search</button>
</form>
