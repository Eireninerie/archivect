SELECT
    CompanyID,
    MAX Rating
FROM
    ".$postCompanyEN."
    LEFT JOIN ".$postVarRating."
	ON totalDistance > (
        ROUND(
		SQRT(
			power(ABS(coordStart.EASTING - coordEnd.Easting),2)+
			power(ABS(coordStart.Northing - coordEnd.Northing),2)
		)
	,2)/1000
GROUP BY
    CompanyID
ORDER BY
    CompanyID;