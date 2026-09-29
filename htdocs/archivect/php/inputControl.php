<?php

include('../php/public_functions.php');
echo $primaryTable;

function txtInputs($row,$type){
    echo "
    <label for='".$type."'>".$type.":</label>
    <input type='text' name ='".$type."' value='".$row."'></input>
    ";
}

function mainTable(){
	global $conn, $primaryTable, $addressTable, $sectorTable, $ethosTable;
    $tableSQL = "SELECT * FROM ".$primaryTable;
	$tablequery = $conn->query($tableSQL);
	if ($tablequery->num_rows > 0){
		while($row = $tablequery->fetch_assoc()){
			echo "
				<form class='CompanyInput'>
                <button type='button'>update</button>
                <label for='Company'>Company Name:</label>
                <input type='text' name ='Company' value='".$row["Company"]."'></input>
                </form>
				";
            txtInputs($row["website"],"website");

		}
	} else {
		echo "x";
	}
}

 mainTable();
?>
oop