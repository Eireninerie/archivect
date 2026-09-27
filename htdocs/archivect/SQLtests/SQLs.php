<?php


// Turn Distance ratings into table
$tempTable = "
    CREATE TEMPORARY TABLE temp_table_1 (
      `Id` int AUTO_INCREMENT PRIMARY KEY,
      `postStart` varchar(4),
      `postEnd` varchar(4),
      `Rating` int(1)
    )
  ";
  
$conn->query($tempTable);
$inserted = $DistanceListRatings;
$insertTempTable = 'INSERT INTO temp_table_1 (postStart, postEnd, Rating)
VALUES
'.$inserted;

$conn->query($insertTempTable);

$tempTableQuerySQL = 'SELECT ID, postStart, postEnd, Rating FROM temp_table_1';

// print query
//	$tempTableQuery = $conn->query($tempTableQuerySQL);
//	while($row = $tempTableQuery->fetch_assoc()){
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["postStart"]."</td><td>".$row["postEnd"]."</td><td>".$row["Rating"]."</td></tr></table>";}
	
//Attaching coordinates to the company ID postcodes

$postCompanyENSQL = "SELECT    CompanyID,  postcode,    EASTING,    NORTHING

			FROM    ".$addressTable."

			LEFT JOIN ".$postcodeRefTable." ON substring(postcode,1,length(postcode)-3) = TRIM(postcode_district)";
	// print query
//	$postCompanyEN = $conn->query($postCompanyENSQL);
//	while($row = $postCompanyEN->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["postcode"]."</td></tr></table>";}



//Attaching coordinates to the rating postcodes
$distanceInputTable = "temp_table_1";
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
	// print query
//	$postVarRating = $conn->query($postVarRatingSQL);
//	while($row = $postVarRating->fetch_assoc()){
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["Rating"]."</td><td>".$row["postStart"]."</td><td>".$row["postEnd"]."</td><td>".$row["coordSE"]."</td><td>".$row["totalDistance"]."</td></tr></table>";}

// Attaching Rating to Company ID by comparing the company coordinates to the rating coordinates

$postCompanyRatingSQL = "
SELECT
    CompanyID, MAX(weighting.Rating) AS MaxRating
FROM
    (".$postCompanyENSQL.") AS postCompanyEN
    LEFT JOIN (".$postVarRatingSQL.") AS postVarRating
	ON totalDistance > (
        ROUND(
		SQRT(
			power(ABS(coordSE - postCompanyEN.Easting),2)+
			power(ABS(coordSN - postCompanyEN.Northing),2)
		)/1000
	,2))
	LEFT JOIN weighting on postVarRating.Rating = weighting.ID
GROUP BY
    CompanyID
ORDER BY
    MaxRating DESC";
    


	// print query
//	$postCompanyRating = $conn->query($postCompanyRatingSQL);
//	while($row = $postCompanyRating->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["MaxRating"]."</td></tr></table>";}

//Determine Company size
$sizeTypeSQL = 'SELECT 

CompanyID, IF(COUNT(*)=1,1,IF (COUNT(*)<5,2,3)) AS Size,
    IF (COUNT(CASE WHEN addresses.Postcode != "Overseas" THEN 1 END) > COUNT(*)*0.4, 
        "DO", "IN") As Location


FROM '.$addressTable.' 
GROUP BY CompanyID';

	// print query
//	$sizeType = $conn->query($sizeTypeSQL);
//	while($row = $sizeType->fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["Location"].$row["Size"]."</td></tr></table>";}

$sizeRatingSET='
	SELECT ID, SUBSTRING('.$SizesListRatings.',ROW_NUMBER() OVER( ORDER BY ID),1) AS Rating 
	FROM sizesList
	';
	// print query
//	$sizeRatingSETq = $conn->query($sizeRatingSET);
//	while($row = $sizeRatingSETq->fetch_assoc()){
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["Rating"]."</td></tr></table>";}

$sizeRatingsQuerySQL='
	SELECT t.CompanyID, weighting.Rating
		FROM ('.$sizeRatingSET.') AS s
		LEFT JOIN weighting ON weighting.ID = s.Rating
		RIGHT JOIN ('.$sizeTypeSQL.') AS t ON CONCAT(t.Size,t.Location) = s.ID
	';
	// print query
//	$sizeRatingsQuery = $conn->query($sizeRatingsQuerySQL);
//	while($row = $sizeRatingsQuery>fetch_assoc()){
//	echo "<table><tr><td>".$row["CompanyID"]."</td><td>".$row["Rating"]."</td></tr></table>";}

//Get sector ratings
$SectorRatingsQuerySQL = "
	SELECT ID, Name, SUBSTRING('.$SectorListRatings.',ROW_NUMBER() OVER( ORDER BY Name) +1,1) AS Rating 
	FROM ".$sectorListTable."
	ORDER BY Name ASC ";

// print query
//	$SectorRatings = $conn->query($SectorRatingsQuerySQL);
//	while($row = $SectorRatings->fetch_assoc()){
//	echo "<table><tr><td>".$row["ID"]."</td><td>".$row["Name"]."</td><td>".$row["Rating"]."</td><td>".$row["Rating"]."</td></tr></table>";}

// weight and average sector ratings
 $SectorCompanyRatingsSQL = " SELECT avg(weighting.rating) AS SRating, CompanyID
 	FROM ".$sectorTable."
		LEFT JOIN (".$SectorRatingsQuerySQL.") AS v ON v.ID = ".$sectorTable.".Sectors
		LEFT JOIN weighting on v.Rating = weighting.ID
	GROUP BY CompanyID
";
// print query
//	$SectorCompanyRatings = $conn->query($SectorCompanyRatingsSQL);
//	while($row = $SectorCompanyRatings->fetch_assoc()){
//	echo "<table><tr><td>".$row["v.ID"]."</td><td>".$row["CompanyID"]."</td><td>".$row["SRating"]."</td><td>".$row["Rating"]."</td></tr></table>";}

//Attach combined ratings to Company details
$ratingSortSQL = "SELECT ID, Company, logo, website, sizeType.Size, Location,
	Round(
        	If(postCompanyRating.MaxRating IS NULL, 0, MaxRating)
	,2) AS totalRating
FROM
       ".$primaryTable."
        LEFT JOIN (".$postCompanyRatingSQL.") AS postCompanyRating ON  ".$primaryTable.".ID = postCompanyRating.CompanyID 
        LEFT JOIN (".$sizeTypeSQL.") AS sizeType ON ".$primaryTable.".ID = sizeType.CompanyID
ORDER BY
    totalRating DESC
LIMIT 50";

?>
