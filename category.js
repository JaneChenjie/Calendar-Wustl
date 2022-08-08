

$('#tagselector').change(function() {
    if($(this).val()=="all"){
        $('.category').show();
    }else{
        $('.category').hide();
        $('.' + $(this).val()).show();   
    } 
});