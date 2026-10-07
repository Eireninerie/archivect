$(document).ready(function(){
    $.fn.deladdress = function () {
        $classcheck= $(this).closest("tr").attr('class');
        if($classcheck == 'newaddress')
            {$(this).closest("tr").remove()}
        else{
            $(this).closest("tr").toggleClass('delete').toggleClass('existaddr');
            $inner = $(this).text();
            $endash =  '&ndash;';
            if($inner != '+' ){$(this).text('+');
            }else{$(this).html('&ndash;');}
        }
        };
    $.fn.updateinputs = function(){
        var ID = $(this).attr('id');
        $maininputs = $(this).siblings('.theInputs')
        var main = ID+','+$maininputs.find('input').map(function(){return $(this).val();}).get().join();
        $sectortbl = $(this).parent().siblings().find('.sectors');
        var sectorskeep = $sectortbl.find('input.updated:checked').map(function(){return '('+ID+','+$(this).attr('name')+')';}).get().join();
        var sectorsdel = '('+$sectortbl.find('input.updated:not(:checked)').map(function(){return $(this).attr('name');}).get().join()+')';
        $ethostbl = $(this).parent().siblings().find('.ethos');
        var ethoskeep = '('+$ethostbl.find('input.updated:checked').map(function(){return $(this).attr('name');}).get().join()+')';
        var ethosdel = '('+$ethostbl.find('input.updated:not(:checked)').map(function(){return $(this).attr('name');}).get().join()+')';
        $addresstbl = $(this).parent().siblings().find('.addresses');
        var addressnew = '('+$addresstbl.find('.newaddress').map(function(){
            return ID+',,'+$(this).find('input').map(function(){return $(this).val();}).get().join();}).get().join('),(')+')';
        var addressdel = '('+$addresstbl.find('.delete').find('input:hidden').map(function(){ return $(this).val();}).get().join()+')';
        var addressupdate = '(,'+$addresstbl.find('.existaddr').map(function(){
            return $(this).find('input').map(function(){return $(this).val();}).get().join();}).get().join('),(,')+')';

        $(this).closest('.Company').wrap('<div></div>').parent().load(
            '../php/inputControl.php',
            {ID,main,
                sectorskeep,sectorsdel,
                ethoskeep,ethosdel,
                addressnew,addressdel,addressupdate
            }
            ).unwrap();
        };
    
    $('.addposts').click(function() {
        // Get input values
        $row = $(this).closest("tr");
        $Town = $row.find(".TownInput").val();
        $Postcode = $row.find(".PostcodeInput").val();
        if ($Town != "" && $Postcode !=""){
            $newRow = '<td><button type="button" class="deletenewbutton" >&ndash;</button></td><input type="text" class="TownInput" name="Town" value="'+$Town+'"><td><input type="text" class ="PostcodeInput" name="Postcode" value="'+$Postcode+'"></td>';
            $row.after($('<tr class="newaddress">').html($newRow));
            $row.find(".TownInput").val("");
            $row.find(".PostcodeInput").val("");}
        $('.deletenewbutton').click(function(){
            $(this).deladdress();
        });
    });
    $("input").change(function(){
        $(this).toggleClass('updated');
        $('.update').click(function(){$(this).updateinputs();});
    });
    $('.deletebutton').click(function(){
        $(this).deladdress();
        $('.update').click(function(){$(this).updateinputs();});
    });    
});    