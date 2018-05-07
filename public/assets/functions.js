$(function(){

    //just for demo propose only
    $('.hide_item').on('click', function(){
        let parent = $(this).parent().closest('div');
        $(parent).hide();
    });

});