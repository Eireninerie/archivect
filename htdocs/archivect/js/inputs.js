$(document).ready(function(){
    $.fn.deladdress = function () {
        $classcheck= $(this).closest("tr").attr('class');
        if($classcheck == 'newaddress')
            {$(this).closest("tr").remove()}
        else{
            $(this).closest("tr").toggleClass('delete');
            $inner = $(this).text();
            $endash =  '&ndash;';
            if($inner != '+' ){$(this).text('+');
            }else{$(this).html('&ndash;');}
        }
        };
    $('.addposts').click(function() {
            // Get input values
            $row = $(this).closest("tr");
            $Town = $row.find(".TownInput").val();
            $Postcode = $row.find(".PostcodeInput").val();
            if ($Town != "" && $Postcode !=""){
            $newRow = '<td><button type="button" class="deletebutton" onclick="$(this).deladdress()">&ndash;</button></td><input type="text" class="TownInput" name="Town" value="'+$Town+'"><td><input type="text" class ="PostcodeInput" name="Postcode" value="'+$Postcode+'"></td>';
            $row.after($('<tr class="newaddress">').html($newRow));
            $row.find("#TownInput").val("");
            $row.find("#PostcodeInput").val("");}
        });
    $('.update').click(function(){
        $CompanyID = $(this).attr('id');
        $(this).after().text($CompanyID);
        $(this).closest('.Company').load('../php/inputControl.php',{ 'ID': $CompanyID });
    });
    $('.deletebutton').click(function(){
        $(this).deladdress();
    });    
});    