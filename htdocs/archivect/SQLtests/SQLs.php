<?php
global $local;

if ($local == 1){

// Turn Distance ratings into table.
$tempTable = "
    CREATE TEMPORARY TABLE temp_table_1 (
      `Id` int AUTO_INCREMENT PRIMARY KEY,
      `postStart` varchar(4),
      `postEnd` varchar(4),
      `Rating` int(1)
    )
  ";
  
 $conn->query($tempTable);

$insertTempTable = 'INSERT INTO temp_table_1 (postStart, postEnd, Rating)
	VALUES'.$DistanceListRatings;

 $conn->query($insertTempTable);

 $tempTableQuerySQL = 'SELECT postStart, postEnd, Rating FROM temp_table_1';

// print query
//	$tempTableQuery = $conn->query($tempTableQuerySQL);
//	while($row = $tempTableQuery->fetch_assoc()){
//	echo "<table><tr><td>".$row["postStart"]."</td><td>".$row["postEnd"]."</td><td>".$row["Rating"]."</td></tr></table>";}
	

//Attaching coordinates to the company ID postcodes

$postCompanyENSQL = "SELECT    CompanyID,  postcode,    EASTING,    NORTHING

			FROM    ".$addressTable."

			LEFT JOIN ".$postcodeRefTable." ON substring(postcode,1,length(postcode)-3) = TRIM(postcode_district)";
	// print query
//	$postCompanyEN = $conn->query($postCompanyENSQL);
//	while($row = $postCompanyEN->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["postcode"]."</td></tr></table>";}


$distanceInputTable = "temp_table_1";
$postVarRatingSQL = "SELECT Rating, postStart, postEnd,
coordStart.EASTING AS coordSE,
coordStart.Northing AS coordSN,

			power(ABS(coordStart.EASTING - coordEnd.Easting),2)+
			power(ABS(coordStart.Northing - coordEnd.Northing),2)
		 AS totalDistance

FROM 
	".$postcodeRefTable." AS coordStart 
	RIGHT JOIN ".$distanceInputTable." ON postStart = coordStart.Postcode_district
	LEFT JOIN ".$postcodeRefTable." AS coordEnd ON postEnd = coordEnd.Postcode_district";
//print_r($postVarRatingSQL);
	// print query
//	$postVarRating = $conn->query($postVarRatingSQL);
//	while($row = $postVarRating->fetch_assoc()){
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["Rating"]."</td><td>".$row["postStart"]."</td><td>".$row["postEnd"]."</td><td>".$row["coordSE"]."</td><td>".$row["totalDistance"]."</td></tr></table>";}

// Attaching Rating to Company ID by comparing the company coordinates to the rating coordinates
$postCompanyRatingSQL = "SELECT
    CompanyID, MAX(weighting.Rating) AS MaxRating
FROM (".$postCompanyENSQL.") AS postCompanyEN
LEFT JOIN (".$postVarRatingSQL.") AS postVarRating
	ON totalDistance > (
        
			power(ABS(coordSE - postCompanyEN.Easting),2)+
			power(ABS(coordSN - postCompanyEN.Northing),2)
		)
	LEFT JOIN weighting on postVarRating.Rating = weighting.ID
GROUP BY
    CompanyID
ORDER BY
    MaxRating DESC";
  

}else{
	
$DistanceListarray = json_encode($_POST['DistanceListarray']);
// jurn json to queryable table

//print_r($DistanceListarray);
$jsonTempTableSET = "SET @json='$DistanceListarray'"
;
//print_r($DistanceListarray);
//print_r($jsonTempTableSET);
$jsonsettempTableQuery = $conn->query($jsonTempTableSET);

$jsonTempTableSQL=" SELECT postStart,postEnd,Rating FROM json_table(@json, '$[*]' 
  COLUMNS(
   postStart  VARCHAR(4) path '$.Start', 
   postEnd VARCHAR(4) path '$.End',
   Rating INT(1) path '$.Rating' ) 
) AS temp_table_1
";

// print query
//echo '<br><br>toot';
//print_r($jsonTempTableSQL);

	$jsontempTableQuery = $conn->query($jsonTempTableSQL);
//	while($row = $jsontempTableQuery->fetch_assoc()){
//	echo "<table><tr><td>".$row["postStart"]."</td><td>".$row["postEnd"]."</td><td>".$row["Rating"]."</td></tr></table>";}

$postCompanyRatingSQL="SELECT  
	addresses.CompanyID, MAX(weighting.Rating) AS Rating
	FROM
		json_table(@json, '$[*]' 
  			COLUMNS(
   				postStart  VARCHAR(4) path '$.Start', 
   				postEnd VARCHAR(4) path '$.End',
   				unweighted INT(1) path '$.Rating' ) 
		) AS jt 
		CROSS JOIN $addressTable AS addresses
		LEFT JOIN $postcodeRefTable AS postEndCoords ON jt.postEnd=postEndCoords.postcode_district
		LEFT JOIN $postcodeRefTable AS postStartCoords ON jt.postStart=postStartCoords.postcode_district
		LEFT JOIN $postcodeRefTable AS addressCoords ON TRIM(substring(addresses.postcode,1,length(addresses.postcode)-3)) = addressCoords.postcode_district
		LEFT JOIN weighting ON jt.unweighted = weighting.ID
		WHERE (power(ABS(postStartCoords.EASTING - addressCoords.EASTING),2) + power(ABS(postStartCoords.Northing - addressCoords.Northing),2)) < (power(ABS(postStartCoords.Northing - postEndCoords.Northing),2) + power(ABS(postStartCoords.Easting - postEndCoords.Easting),2))
	GROUP BY CompanyID
";

//	$jsontempTableQuery = $conn->query($postCompanyRatingSQL);
//	while($row = $jsontempTableQuery->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["Rating"]."</td></table>";}

}
//Determine Company size
$sizeTypeSQL = 'SELECT CompanyID, CONCAT(st.Location,st.Size) AS SizeID FROM 
	(SELECT	CompanyID, 
	IF(COUNT(*)=1,"1",IF (COUNT(*)<5,"2","3")) AS Size,
    IF (COUNT(CASE WHEN addresses.Postcode != "Overseas" THEN 1 END) > COUNT(*)*0.4, 
        "DO", "IN") As Location
	FROM '.$addressTable.' 
	GROUP BY CompanyID) AS st';

	// print query
//	$sizeType = $conn->query($sizeTypeSQL);
//	while($row = $sizeType->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["SizeID"]."</td></tr></table>";}

//Set size ratings from input
$sizeRatingSET=' SELECT 
	Name, SUBSTRING('.$SizesListRatings.',ROW_NUMBER() OVER( ORDER BY ID),1) AS Rating 
	FROM sizesList
	';
	// print query
	$sizeRatingSETq = $conn->query($sizeRatingSET);
//	while($row = $sizeRatingSETq->fetch_assoc()){
//	echo $SizesListRatings;
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["Rating"]."</td></tr></table>";}
	
// Connect size ratings to weighting and company categorisation
$sizeRatingsQuerySQL=
	'SELECT s.Rating AS "OG", weighting.Rating, t.CompanyID
		FROM ('.$sizeRatingSET.') AS s
		LEFT JOIN weighting ON weighting.ID = s.Rating
		RIGHT JOIN ('.$sizeTypeSQL.') as t ON t.SizeID = s.Name
	';
	// print query
//	$sizeRatingsQuery = $conn->query($sizeRatingsQuerySQL);
//	while($row = $sizeRatingsQuery->fetch_assoc()){
//	echo "<table><tr><td>OG:".$row["OG"]."</td><td>ID:".$row["ID"]."</td><td>Company:".$row["CompanyID"]."</td><td>Rating:".$row["Rating"]."</td></tr></table>";}

//Get sector ratings
$SectorRatingsQuerySQL = 
	"SELECT ID, Name, SUBSTRING('.$SectorListRatings.',ROW_NUMBER() OVER( ORDER BY Name) +1,1) AS Rating 
	FROM ".$sectorListTable."
	ORDER BY Name ASC ";

// print query
//	$SectorRatings = $conn->query($SectorRatingsQuerySQL);
//	while($row = $SectorRatings->fetch_assoc()){
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["Name"]."</td><td>".$row["Rating"]."</td><td>".$row["Rating"]."</td></tr></table>";}

// weight and average sector ratings
 $SectorCompanyRatingsSQL = " SELECT ROUND(avg(weighting.rating),2) AS SRating, CompanyID
 	FROM $sectorTable
		LEFT JOIN (".$SectorRatingsQuerySQL.") AS v ON v.ID = $sectorTable.Sectors
		LEFT JOIN weighting on v.Rating = weighting.ID
	GROUP BY CompanyID
";
// print query
//	$SectorCompanyRatings = $conn->query($SectorCompanyRatingsSQL);
//	while($row = $SectorCompanyRatings->fetch_assoc()){
//	echo "<table><tr><td>".$row["v.ID"]."</td><td>".$row["CompanyID"]."</td><td>".$row["SRating"]."</td><td>".$row["Rating"]."</td></tr></table>";}

$ethosRatings = "SELECT 
	ID, Name,
	SUBSTRING('$EthosListRatings',ROW_NUMBER() OVER( ORDER BY Name),1) AS Rating
	FROM ".$ethosListTable."";

//		$ethosCompanyRatings = $conn->query($ethosRatings);
//	while($row = $ethosCompanyRatings->fetch_assoc()){
//	echo "<table><tr><td>".$row["Name"]."</td><td>".$row["Rating"]."</td></tr></table>";}

$ethosRatingsQuerySQL = "SELECT
	CompanyID, SUM(weighting.Rating)  AS Rating
	FROM (".$ethosRatings.") AS e
	INNER JOIN ".$ethosTable." ON e.ID = ".$ethosTable.".Ethos
	INNER JOIN weighting on weighting.ID = e.Rating
	GROUP BY CompanyID ";

// print query
//	$ethosCompanyRatings = $conn->query($ethosRatingsQuerySQL);
//	while($row = $ethosCompanyRatings->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["Rating"]."</td></tr></table>";}


if ($local == 1){

//Attach combined ratings to Company details
$ratingSortSQL = "SELECT ID, Company, CompanySimple, logo, website,
	If(postRating.MaxRating IS NULL, 0, MaxRating)+
	If(sectorRating.SRating IS NULL, 0, sectorRating.SRating)+
	If(sizeRating.Rating IS NULL, 0, sizeRating.Rating)+
	If(ethosRating.Rating IS NULL, 0, ethosRating.Rating)
	AS totalRating
FROM
       $primaryTable as firms
 	LEFT JOIN ($postCompanyRatingSQL) AS postRating ON  $primaryTable.ID = postRating.CompanyID 
	   
        LEFT JOIN ($SectorCompanyRatingsSQL) AS sectorRating ON firms.ID = sectorRating.CompanyID 
	     LEFT JOIN ($sizeRatingsQuerySQL) AS sizeRating ON firms.ID = sizeRating.CompanyID 
        LEFT JOIN ($ethosRatingsQuerySQL) AS ethosRating ON firms.ID = ethosRating.CompanyID 
        
ORDER BY
    totalRating DESC, Company ASC
LIMIT 50";
// 	LEFT JOIN ($postCompanyRatingSQL) AS postRating ON  $primaryTable.ID = postRating.CompanyID 
}else{
$ratingSortSQL=" SELECT firms.ID, firms.Company, CompanySimple, logo, website,
dis.Rating, sectorRating.SRating, sizeRating.Rating AS szRating,
COALESCE(dis.Rating,0)+ COALESCE(sectorRating.SRating,0)+ COALESCE(sizeRating.Rating,0) + COALESCE(ethosRating.Rating,0) AS totalRating
	FROM $primaryTable AS firms 
	LEFT JOIN ($postCompanyRatingSQL) AS dis ON firms.ID = dis.CompanyID
    LEFT JOIN ($SectorCompanyRatingsSQL) AS sectorRating ON firms.ID = sectorRating.CompanyID 
	LEFT JOIN ($sizeRatingsQuerySQL) AS sizeRating ON firms.ID = sizeRating.CompanyID 
        LEFT JOIN ($ethosRatingsQuerySQL) AS ethosRating ON firms.ID = ethosRating.CompanyID 
	ORDER BY COALESCE(dis.Rating,0)+ COALESCE(sectorRating.SRating,0)+ COALESCE(sizeRating.Rating,0) + COALESCE(ethosRating.Rating,0) DESC
";

// print query
//	$jsontempTableQuery = $conn->query($ratingSortSQL.'LIMIT 30');
//	while($row = $jsontempTableQuery->fetch_assoc()){
//	echo "<table><tr><td>CompanyID:".$row["ID"]."</td><td>".$row["Company"]."</td><td>Distance:".$row["Rating"]."</td><td>Sectors:".$row["SRating"]."</td><td>Size:".$row["szRating"]."</td></tr></table>";}

}
?>