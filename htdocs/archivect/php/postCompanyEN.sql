SELECT    CompanyID,    postcode,    EASTING,    NORTHING
			FROM    ".$tableName."
			LEFT JOIN Postcode_Coords_EN ON postcode LIKE CONCAT(postcode_coords_en.postcode_district,'%')