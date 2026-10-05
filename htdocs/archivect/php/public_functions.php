<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = "test";

//database tables
$postcodeRefTable = "postcodeCoordsEN";

$primaryTable = "firms";
$addressTable = "addresses";
$sectorTable = "sectors";
$ethosTable = "ethos";

$sectorListTable = "sectorsList";
$ethosListTable = "ethosList";
$socialsListTable = "socialsList";

$conn = new mysqli($host,$username,$password,$dbname);
if (!$conn) {
	die('Connection failed: '.mysqli_connect_error());
	}
//echo 'Connected successfully';
	
function rB($x,$y,$z,$w,$v)
              {echo '<input type="radio" class="'.$x.'" name="'.$y.'" value="'.$z.'" title="'.$w.'" '.$v.'>';}
             
           
function rating($ID,$Name){
	rB($ID,$Name,"1","avoid","").	
	rB($ID,$Name,"2","ambivalent","checked='checked'").
	rB($ID,$Name,"3","fine","").
	rB($ID,$Name,"4","like","").
	rB($ID,$Name,"5","best","");
}

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
    echo "<div class='table'><h3>$subtable</h3><table class=$subtable><tbody>";
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


function Companydeets($whereclause,$limits){
    global $conn,$primaryTable,$sectorTable,$ethosTable,$addressTable;
    $tableSQL = "SELECT * FROM $primaryTable $whereclause ORDER BY Company ASC $limits";
    $tablequery = $conn->query($tableSQL);
    if ($tablequery->num_rows > 0){
	    while($row = $tablequery->fetch_assoc()){
		    echo "
                <div class='Company'><form class='CompanyInput'>
                <button type='button' id='".$row["ID"]."' class='update'>update</button>                
	    		";
            theInputs($row["Company"],"Company","text");
            echo "<br>";
            theInputs($row["CompanySimple"],"aka","text");
            theInputs($row["website"],"website","url");
            theInputs($row["logo"],"logo","url");
            echo "</form>";
            subTable( $sectorTable,$row["ID"]);
            subTable( $ethosTable,$row["ID"]);
            addressList($addressTable,$row["ID"]);
            echo "</div>";
	    }
    } else {
	    echo "x";
    }
}

?>
