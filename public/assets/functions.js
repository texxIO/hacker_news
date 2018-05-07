$(function(){

    //just for demo propose only
    $('.hide_item').on('click', function(){
        let parent = $(this).parent().closest('.col-md-12');
        $(parent).hide();
    });

});