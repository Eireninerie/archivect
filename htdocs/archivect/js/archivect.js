$.fn.addcorners = function(){
    $prepended = '<div class="gridt"></div>  <div class="gridl"></div><div class="gridr"></div>  <div class="gridb"></div>';
    $(this).addClass('corners').wrapInner('<div class="gridcontent">').prepend($prepended);
    $('#Search').find('.gridcontent').addClass('setheight');
    }
$(document).ready(function(){
    $('h1, #header li, #Search, .card').addcorners();
    
});