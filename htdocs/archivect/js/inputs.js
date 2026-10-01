$(document).ready(function(){
    $('#addPosts').click(function() {
            // Get input values
            $Town = $("#TownInput").val();
            $Postcode = $("#PostcodeInput").val();
            $newRow = '<tr class="newaddress"><td><button type="button" onclick="deleteData(this)" class="deletebutton">-</button></td><input type="text" name="Town" value="'+$Town+'"><td><input type="text" name="Postcode" value="'+$Postcode+'"></tr></td>';
            $(this).parent().parent().after($newRow);
            $("#Town").val("");
            $("#Postcode").val("");
        });
    $('.deletebutton').click(function(){
        $(this).parent().toggleClass('delete');
        $(this).html('+');
    });    
});    