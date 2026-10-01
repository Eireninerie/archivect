<?php

include('../php/public_functions.php');
echo "<script src='../js/inputs.js'></script>";
echo $primaryTable;

function theInputs($row,$type,$inputtype){
    echo "
    <div style='display: inline; white-space: nowrap;><label for='".$type."'>".$type.":</label>
    <input type='$inputtype' name ='".$type."' value='".$row."'></input>
    </div>
    ";
}
function subTable( $subtable,$companyID){
    global $conn;
	$check = "checked='checked'";
    $subtableSQL = "SELECT ".$subtable."List.ID, ".$subtable."List.Name, checked
        FROM ".$subtable."List 
        LEFT JOIN 
            (SELECT 'checked' AS checked, ".$subtable." FROM ".$subtable." WHERE CompanyID=".$companyID.") AS st
            ON st.".$subtable." = ".$subtable."List.ID
        ORDER BY checked DESC, Name ASC
        ";
    $tablequery = $conn->query($subtableSQL);
    echo "<table style='display: inline; '><tbody style='height:150px; display:inline-block; overflow-y:scroll'>";
	while($row = $tablequery->fetch_assoc()){
        $check = $row["checked"];
        echo "<tr><td><input type='checkbox' name='".$row["ID"]."' $check></td><td>".$row["Name"]."</td></tr>";
        }
    echo "</tbody></table>";
}
function addressList($addressTable,$companyID){
    global $conn;
    $addresstblSQL = "SELECT * FROM ".$addressTable." WHERE CompanyID=".$companyID;
    $tablequery = $conn->query($addresstblSQL);
    echo "<table style='display: inline; '><tbody style='height:150px; display:inline-block; overflow-y:auto'>";
    echo "<tr><td><button type='button' id='addposts'>+</button></td><td><input type='text' id='TownInput' name='Town'></td><td><input type='text' id='PostcodeInput' name='Postcode' value='' style='width:80px'></tr></td>";
    while($row = $tablequery->fetch_assoc()){
        echo "<tr><td><button type='button' class='deletebutton' onclick='deleteData(this)'>-</button></td><td><input type='hidden' value='".$row["ID"]."'><input type='text' name='Town' value='".$row["Town"]."'></td><td><input type='text' name='Postcode' value='".$row["Postcode"]."' style='width:80px'></td></tr>";
        }
    echo "</tbody></table>";
}
function mainTable(){
	global $conn, $primaryTable, $addressTable, $sectorTable, $ethosTable;
    $tableSQL = "SELECT * FROM ".$primaryTable;
	$tablequery = $conn->query($tableSQL);
	if ($tablequery->num_rows > 0){
		while($row = $tablequery->fetch_assoc()){
			echo "
				<form class='CompanyInput'>
                <button type='button' id='".$row["ID"]."'>update</button>                
				";
            theInputs($row["Company"],"Company","text");
            echo "<br>";
            theInputs($row["CompanySimple"],"aka","text");
            theInputs($row["website"],"website","url");
            theInputs($row["logo"],"logo","url");
            theInputs($row["EST"],"EST","date");
            theInputs($row["Closed"],"Closed","date");
            echo "</form>";
            subTable( $sectorTable,$row["ID"]);
            subTable( $ethosTable,$row["ID"]);
            addressList($addressTable,$row["ID"]);

		}
	} else {
		echo "x";
	}
}

 mainTable();
?>
oop