<?php

include('../php/public_functions.php');
echo $primaryTable;

function theInputs($row,$type,$inputtype){
    echo "
    <div style='display: inline; white-space: nowrap;><label for='".$type."'>".$type.":</label>
    <input type='$inputtype' name ='".$type."' value='".$row."'></input>
    </div>
    ";
}
function subTable( $subtable){
    global $conn;
    $subtableSQL = "SELECT * FROM ".$subtable."List";
    $tablequery = $conn->query($subtableSQL);
    echo "<table style='display: inline; '><tbody style='height:150px; display:inline-block; overflow-y:scroll'>";
	while($row = $tablequery->fetch_assoc()){
        echo "<tr><td><input type='checkbox' name='".$row["ID"]."'></td><td>".$row["Name"]."</tr></td>";
        }
    echo "</tbody></table>";
}
function addressList($addressTable,$companyID){
    global $conn;
    $addresstblSQL = "SELECT * FROM ".$addressTable." WHERE CompanyID=".$companyID;
    $tablequery = $conn->query($addresstblSQL);
    echo "<table style='display: inline; '><tbody style='height:150px; display:inline-block; overflow-y:auto'>";
    while($row = $tablequery->fetch_assoc()){
        echo "<tr><td><input type='hidden' value='".$row["ID"]."'><input type='text' name='town' value='".$row["Town"]."'></td><td><input type='text' name='postcode' value='".$row["Postcode"]."' style='width:80px'></tr></td>";
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
            subTable( $sectorTable);
            subTable( $ethosTable);
            addressList($addressTable,$row["ID"]);

		}
	} else {
		echo "x";
	}
}

 mainTable();
?>
oop