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
//thank you John Rumpel! turning distance table into json

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
$('#testButton').click(function(){
    $results2 = '{'+joinvalues("#SectorList")+'}'
        ;
//    $UK0val = $('input[name="SizesUK0"]:checked').val();
    $('#testCont').html(
    '&'+html2insert()
    );
});

$('#submitButton').click(function(){
   $searchheight = $('#Search').height();
   if (window.matchMedia("(min-width: 1010px)").matches) {
      $('#Search').height($searchheight);
   }else{
      $('#pull').removeClass('hiddenClass');
   }
   $("#errormsg").parent().remove();
   $results = $( "form" ).serialize();
   let SectorList = joinvalues("#SectorList");
   let EthosList = joinvalues("#EthosList");
   let SizesList = joinvalues("#SizesList");
   let DistanceList = html2insert();
   let DistanceListarray = tablevalues();
   $("#results").html("<div class='content'>...loading </div>").load('./php/search_results.php', {SectorList,EthosList,SizesList,DistanceList,DistanceListarray},
      function(){
      $('#Search').addClass('collapse');
//      $('.card').wrapInner('<div>').children('div').addcorners();
      if (window.matchMedia("(max-width: 1010px), (min-resolution: 2x)").matches) {
         $('#pull').click(function(){
         $('#Search').toggleClass('collapse');
         });
         $('.card').click(function(){
            $('#Search').removeClass('collapse');
            $('#Search').find('.cardDetails ').remove();
            $content = $(this).find('.cardDetails').clone(); 
            $('#Search').wrapInner('<div class="wrapped">').find('.wrapped').addClass('hiddenClass');
            $('#Search').prepend($content);
            $('#Search').find('.cardDetails').removeClass('hiddenClass');
            $('.exitcard').click(function(){
               $('#Search').find('.cardDetails ').remove();
               $('#Search').find('.wrapped').children().unwrap();
               $('#Search').removeClass('collapse');
            });
         });
      }else{
         $('.card').hover(function(){
            $('#Search').find('.cardDetails ').remove();
            $content = $(this).find('.cardDetails').clone(); 
            $('#Search').wrapInner('<div class="wrapped">').find('.wrapped').addClass('hiddenClass');
            $('#Search').prepend($content);
            $('#Search').find('.cardDetails').removeClass('hiddenClass');
            $('#Search').find('.cardDetails').animate({"max-height": "100%"},600);
            $('.exitcard').click(function(){
               $('#Search').find('.cardDetails ').remove();
               $('#Search').find('.wrapped').children().unwrap();

            });
         },function(){
          
         }); 
      }
      }
   );
});

});
