function deleteData(button) {

            // Get the parent row of the clicked button
            let row = button.parentNode.parentNode;

            // Remove the row from the table
            row.parentNode.removeChild(row);
        }
function joinvalues ($table){
    $values = $($table).find("input:checked");
    $myArray = $.map($values, function(element) {
       return element.value;
    });
    return $myArray.join("");
}
// redundant ): will delete if I give up on understanding why its wrong. Or if I understand it.

function joinvalues2 (){
$joinedagain = $( "#DistanceTable").find("tr" ).each(function( index ) {
        $values = $(this).find("input:checked,input[readonly]");
        $myArray = $.map($values, function(element) {
            return element.value;
            });
        console.log($myArray.join());
        return $myArray.join();
        });
        return $joinedagain.join();
        
}
//thank you John Rumpel! turning distance table into json

function html2json() {
   $json = '[';
   $otArr = [];
   $tbl2 = $('#DistanceTable tr.inputs').each(function(i) {        
      x = $(this).find("input:checked,input[readonly]");
      $itArr = [];
      x.each(function() {
         $itArr.push('"' + $(this).attr('class') + '":"'+ $(this).val() + '"');
      });
      $otArr.push('{"ID":' + i + ',' + $itArr.join(',') + '}');
   })
   $json += $otArr.join(",") + ']'

   return 'DistanceList:'+$json;
}
function html2insert() {
   
   $otArr = [];
   $tbl2 = $('#DistanceTable tr.inputs').each(function(i) {        
      x = $(this).find("input:checked,input[readonly]");
      $itArr = [];
      x.each(function() {
         $itArr.push('"' + $(this).val() + '"');
      });
      $otArr.push('(' + $itArr.join() + ')');
   })
   $insert = $otArr.join()
   if(!$insert){return '("D45","D45","2")';}else{return $insert;}
   
}


$(document).ready(function(){
$('#addPosts').click(        function() {
            // Get input values
            $postStart = $("#postStartInput").val();
            $postEnd = $("#postEndInput").val();
            $newRow = "./php/DRows.php?postStart="+$postStart+"&postEnd="+$postEnd;
            $(this).parent().parent().after($('<tr class="inputs">').load($newRow));
            $("#postEndInput").val("");
            $("#postStartInput").val("");

        });
$('#testButton').click(function(){
    $results2 = '{'+joinvalues("#SectorList")+'}'
        ;
//    $UK0val = $('input[name="SizesUK0"]:checked').val();
    $('#testCont').html(
    '&'+html2insert()
    );
});
    
$('#submitButton').click(function(){
    $results = $( "form" ).serialize();
    $r1 = joinvalues("#SectorList");
    $r2 = joinvalues("#EthosList");
    $r3 = joinvalues("#SizesList");
    $r4 = html2insert();
    $("#results").html("...loading ");
    $("#results").load('./php/search_results.php', {"SectorList":$r1,"EthosList":$r2,"SizesList":$r3,"DistanceList":$r4} );

    });
});
