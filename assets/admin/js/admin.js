$(window).resize(function(){
    if($(window).width()<=768){
        $('#sidebar-left').hide();
        $('.sidebar-content').hide();   
    }
    if($(window).width()>768){
        $('#sidebar-left').show();
        $('.sidebar-content').show();
    }
})

$(document).ready(function(){
    if($(window).width()<=768){
        $('#sidebar-left').hide();
        $('.sidebar-content').hide();   
    }
    if($(window).width()>768){
        $('#sidebar-left').show();
        $('.sidebar-content').show();
    }
})

$('.navbar-minimize-mobile').on('click',function(){
    $('#sidebar-left').toggle();
});
        /*.on('click',function(){
    $('#sidebar-left').css({"left":"0px", "top":"50px"});
})*/

