$.fn.addcorners = function(){
    $prepended = '<div class="gridt"></div>  <div class="gridl"></div><div class="gridr"></div>  <div class="gridb"></div>';
    $(this).addClass('corners').wrapInner('<div class="gridcontent">').prepend($prepended);
    }
$(document).ready(function(){
//    $('h1, #header ul, #Search, .card,.content').addcorners();
    $('#Search').append('<button id="pull" class="hiddenClass">close</button>');
    $('legend').click(function(){
        $name = $(this).attr('for');
        $input = $('input[name="'+$name+'"][checked]');
    
        $inputval = parseInt($input.val())+1;
        $input.removeAttr('checked');
        if ($inputval === 6){
            $input.siblings('[value="1"]').attr('checked','');
        }
        else{$input.siblings('[value="'+$inputval+'"]').attr('checked','');}
        
    });
    $('input[type="radio"]').click(function(){
        $(this).attr('checked','').siblings().removeAttr('checked');
    })
    $('#nav').find('button').click(function(){
        $(this).siblings('ul').toggleClass('menu');
    })
    
});