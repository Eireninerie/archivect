<?php

include('../php/public_functions.php');
echo "<script src='../js/inputs.js'></script>";

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$precs = 64;
$offset = ($pageno-1) * $precs; 

echo $offset;

$pageSQL = "SELECT * FROM ".$primaryTable;
	$pagequery = $conn->query($pageSQL);
	$pagenos = ceil($pagequery->num_rows / $precs);

echo $pagenos;

function theInputs($row,$type,$inputtype){
    echo "
    <div class='theInputs'><label for='".$type."'>".$type.":</label>
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
    echo "<table><tbody>";
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
    echo "<table><tbody>";
    echo "<tr><td><button type='button' class='addposts'>+</button></td><td><input type='text' class='TownInput' name='Town'></td><td><input type='text' class='PostcodeInput' name='Postcode' value=''></tr></td>";
    while($row = $tablequery->fetch_assoc()){
        echo "<tr><td><button type='button' class='deletebutton' >&ndash;</button>
        </td><td><input type='hidden' value='".$row["ID"]."'>
        <input type='text' name='Town' class='TownInput' value='".$row["Town"]."'></td>
        <td><input type='text' name='Postcode' class='PostcodeInput' value='".$row["Postcode"]."'></td></tr>";
        }
    echo "</tbody></table>";
}

$tableSQL = "SELECT * FROM ".$primaryTable." LIMIT ".$offset.",".$precs;
$tablequery = $conn->query($tableSQL);
if ($tablequery->num_rows > 0){
	while($row = $tablequery->fetch_assoc()){
		echo "
            <div class='Company'><form class='CompanyInput'>
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
        echo "</div>";

	}
} else {
	echo "x";
}


?>