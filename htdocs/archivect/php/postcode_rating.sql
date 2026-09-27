SELECT
ID,
Rating,
postStart,
postEnd,
ROUND(
		SQRT(
			power(ABS(coordStart.EASTING - coordEnd.Easting),2)+
			power(ABS(coordStart.Northing - coordEnd.Northing),2)
		)
	,2)/1000 AS totalDistance

FROM
    (
        Distance
        LEFT JOIN Postcode_Coords_EN AS coordStart ON Distance.postStart = coordStart.Postcode_district
    )
    LEFT JOIN Postcode_Coords_EN AS coordEnd ON Distance.postEnd = coordEnd.Postcode_district;