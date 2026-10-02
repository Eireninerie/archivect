<?php

include('../php/public_functions.php');
echo "<script src='../js/inputs.js'></script>";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$precs = 64;
$offset = ($page-1) * $precs; 

echo $offset;

$pageSQL = "SELECT * FROM ".$primaryTable;
	$pagequery = $conn->query($pageSQL);
	$pages = ceil($pagequery->num_rows / $precs);

echo $pages;
?>
<ul class="pagination">
    <li><a href="?page=1">First</a></li>
    <li class="<?php if($page <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a>
    </li>
    <li><?php echo $page; ?> <li>
    <li class="<?php if($page >= $pages){ echo 'disabled'; } ?>">
        <a href="<?php if($page >= $pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
    </li>
    <li><a href="?page=<?php echo $pages; ?>">Last</a></li>
</ul>
<?php
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
    echo "<div class='table'><h3>$subtable</h3><table><tbody>";
	while($row = $tablequery->fetch_assoc()){
        $check = $row["checked"];
        echo "<tr><td><input type='checkbox' name='".$row["ID"]."' $check></td><td>".$row["Name"]."</td></tr>";
        }
    echo "</tbody></table></div>";
}
function addressList($addressTable,$companyID){
    global $conn;
    $addresstblSQL = "SELECT * FROM ".$addressTable." WHERE CompanyID=".$companyID;
    $tablequery = $conn->query($addresstblSQL);
    echo "<div class='table'><h3>Addresses</h3><table><tbody>";
    echo "<tr><td><button type='button' class='addposts'>+</button></td><td><input type='text' class='TownInput' name='Town'></td><td><input type='text' class='PostcodeInput' name='Postcode' value=''></tr></td>";
    while($row = $tablequery->fetch_assoc()){
        echo "<tr><td><button type='button' class='deletebutton' >&ndash;</button>
        </td><td><input type='hidden' value='".$row["ID"]."'>
        <input type='text' name='Town' class='TownInput' value='".$row["Town"]."'></td>
        <td><input type='text' name='Postcode' class='PostcodeInput' value='".$row["Postcode"]."'></td></tr>";
        }
    echo "</tbody></table></div>";
}

$tableSQL = "SELECT * FROM ".$primaryTable." ORDER BY Company ASC LIMIT ".$offset.",".$precs;
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