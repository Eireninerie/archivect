SELECT
    Round(
        IIf(Distance_Rating IS NULL, 0, Distance_Rating)
    ) AS totalRating
FROM
    
        ".$tableName."
        LEFT JOIN ".$postCompanyRating." ON  ".$tableName.".ID = postCompanyRating.CompanyID

ORDER BY
    totalRating