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
//for web, not working in xampp vvv
function tablevalues() { 
    return $('#DistanceTable .inputs')
    .get().map(function(row) { 
        let vals = $(row).find('input:checked, input[readonly]')
            .map(function(i, el) { 
                return $(el).val(); 
            }).get(); 
        return { Start: vals[1], End: vals[2], Rating: vals[0] }; 
    }); 
}
//for web, not working in xampp ^^^

//not in use!! vvv thank you John Rumpel! turning distance table into json
function html2json() {
   $json = '{ "Distances": [';
   $otArr = [];
   $tbl2 = $('#DistanceTable tr.inputs').each(function(i) {        
      x = $(this).find("input:checked,input[readonly]");
      $itArr = [];
      x.each(function() {
         $itArr.push('"' + $(this).attr('class') + '":"'+ $(this).val() + '"');
      });
      $otArr.push('{"ID":' + i + ',' + $itArr.join(',') + '}');
   })
   $json += $otArr.join(",") + ']}'

   if(!$json){}else{return $json;}
}
//not in use!! ^^^

//for local xampp  only vvv
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
   if(!$insert){return '("2","D45","D45")';}else{return $insert;}
   
}
//for local xampp only ^^^

$(document).ready(function(){

$('#addPosts').click(        function() {
   // Get input values
   $postStart = $("#postStartInput").val();
   $postEnd = $("#postEndInput").val();
   $newRow = "./php/DRows.php?postStart="+$postStart+"&postEnd="+$postEnd;
   $(this).parent().parent().after($('<tr class="inputs">').load($newRow));
   $("#postEndInput").val("");
   $("#postStartInput").val("");
   $("#errormsg").parent().remove();
});

// not in use, to be removed vvv
$('#testButton').click(function(){
    $results2 = '{'+joinvalues("#SectorList")+'}'
        ;
//    $UK0val = $('input[name="SizesUK0"]:checked').val();
    $('#testCont').html(
    '&'+html2insert()
    );
});
// not in use, to be removed ^^^

$('#submitButton').click(function(){
   $searchheight = $('#Search').height();
   if (window.matchMedia("(min-width: 63rem)").matches) {
      $('#Search').height($searchheight);
   }else{
      $('#Search').scrollTop( 0 ).addClass('collapse');
      $('#pull').removeClass('hiddenClass');
      $('#pull').click(function(){
         $('#Search').scrollTop( 0 );
         $('#Search').toggleClass('collapse');
      });
   }
   $("#errormsg").parent().remove();
   $results = $( "form" ).serialize(); //reduntant
   let SectorList = joinvalues("#SectorList");
   let EthosList = joinvalues("#EthosList");
   let SizesList = joinvalues("#SizesList");
   let DistanceList = html2insert();
   let DistanceListarray = tablevalues();
   $("#results").html("<div class='content'>...loading </div>").load('./php/search_results.php', {SectorList,EthosList,SizesList,DistanceList,DistanceListarray},
      function(){
         $.fn.cdShow = function(){
            $('#Search').removeClass('collapse');
            $('#Search').find('.cardDetails ').remove();
            $content = $(this).find('.cardDetails').clone(); 
            $('#Search').wrapInner('<div class="wrapped">').find('.wrapped').addClass('hiddenClass');
            $('#Search').prepend($content);
            $('#Search').find('.cardDetails').removeClass('hiddenClass');
            $('.exitcard').click(function(){
               $('#Search').removeClass('collapse');
               $('#Search').find('.cardDetails ').remove();
               $('#Search').find('.wrapped').children().unwrap();
         });}
         $('.card').click(function(){
            $(this).cdShow();
            $('#Search').find('.cardDetails').animate({"max-height": "100%"},600);
         });
         } //end after-load functions
   ); //end load
}); // end submit button
// end submit button
});
