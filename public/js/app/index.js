$(document).ready(function () {
    $('.app-card').hover(function(){
        $(this).addClass('shadow-lg');
    },function(){
        $(this).removeClass('shadow-lg');
    });
});
