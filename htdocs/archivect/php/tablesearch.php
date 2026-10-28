<?php

function xList($type,$table){
	global $conn;
	$QuerySQL = "SELECT ID, Name, Description FROM ".$table." ORDER BY Name ASC";
//	echo $QuerySQL;
	$Query = $conn->query($QuerySQL);
	while($row = $Query->fetch_assoc()){

	echo '<fieldset><legend for='.$type.$row["ID"].' title="" >'.$row["Name"].'<div class="infobox"><p>'.$row["Description"].'</p></div></legend>
	';
	rating($type,$type.$row["ID"]);
	echo "</fieldset></br>";}
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
?>

<script src='./js/searchbar.js'></script>
<form id='Search' class="boxed">
<h3><b>Search Priorities</b></h3>
<h3>Sectors
<b class="info">i</b><div class='infobox'>
<p>Hover over some sectors for their description. Select rating or click on their name to cycle through options.</p>
<p>Give a rating for each sector: default is 'ambivalent', ie. no feelings. The result each firm receives is on an average of the sectors it has. "avoid" weighs very strongly.
</p><p>For example, if you selected "avoid" for transport and "best" for hospitality, you'd get the following result:
	<ol><li>firms with hospitality and no transport</li><li>firms with neither hospitality nor transport</li><li>firms with hospitality and transport</li><li>firms with transport but no hospitality</li></ol>
</div>
</h3>

<div id='SectorList'>
<?php
echo xList("Sector",$sectorListTable);
echo '</div>';
?>
<table id="DistanceTable">
	<h3>Search Radius
	<b class="info">i</b><div class='infobox'>
	<p>Set your search ranges, with the postcode area of the centre of your search and the postcode area of any place on the circle furthest around that point. The search prioritises firms that have at least one office in each search radius.
</p><p>GIVE A RATING FOR EACH RANGE YOU ADD.
</p><p>For example, if you selected "best" for within a circle centred around NG1 and reaching as far as LE1, and "like" for the same but for B7 and B70, you'd get the following result:
	<ol><li>firms with at least 1 office within 21km of NG1</li><li>firms with no office in that area, but at least 1 office within 9km of B7</li><li>firms with offices in neither</li></ol>
<p >NB: these are calculated from the average coordinates of all postcodes in that area, so will be a touch imprecise. Choose a slightly further away postcode to be certain another is covered. Also, the outer postcode itself will always be included, so you can search a range like NG1 to NG1.</p>
</div>
	</h3>
    <tr>     
	    <th>Centre</th>
        <th>Radius</th>
        <th style="width:70px"></th>
        <th>Rating</th>        
    </tr>
    <tr>
       	<td><input type="text" id="postStartInput" maxLength="4" placeholder="eg. B77"></td>
        <td><input type="text" id="postEndInput" maxLength="4" placeholder="eg. EN6"></td>
		<td><button id="addPosts" type="button">+</button></td>
	</tr>
</table>
<h3>Ethos
<b class="info">i</b><div class='infobox'>
<p>Add bonus points or negative points per ethos you are looking for.
</p><p>For example, if you selected "best" for 4 day work week, but "avoid" for AJ100, you'd get:
	<ol><li>firms with a 4 day work week</li><li>firms with neither value</li><li>firms with both values</li><li>firms with no 4 day ww and on the AJ100</li></ol>
<p>NB: Because this is not calculated as an average, it will likely outweigh sectors and distances.</p>
</div>
</h3><div id='EthosList'>
<?php
echo xList("EthosList",$ethosListTable);
echo "</div>";

echo "<h3>Size</h3><div id='SizesList'>";
function Bands($y,$z){
	echo '<fieldset><legend>'.$y.'</legend>';
	rating("Sizes",$z);
	echo "</fieldset></br>";
}

Bands("One Office","UK1");
Bands("2-4 Offices: UK","UK2");
Bands("5+ Offices: UK","UK3");
Bands("2-4 Offices: International","IN2");
Bands("5+ Offices: International","IN3");

echo "</div>";
?>
<!-- <button id="testButton" type="button">test</button>
<div id="testCont">test container</div>
-->
<button id="submitButton" type="button">SUBMIT</button>
</form>
<button id="pull" class="hiddenClass"></button>
