$(function(){
    function mScroll(id){
        $("html,body").stop(true);$("html,body").animate({scrollTop: $("#"+id).offset().top}, 1000);
    }  
    var index = $(".tcnav li").length;
    $(".tcnav li").each(function(index, element) {
        $(this).click(function(){
            mScroll("tcnav_"+index);
            $(this).addClass('fuwurtxt').siblings('li').removeClass('fuwurtxt');
        })
    });
    var tch_0 = $("#tcnav_0").offset().top-10;
    var tch_1 = $("#tcnav_1").offset().top-10;
    var tch_2 = $("#tcnav_2").offset().top-10;
    var tch_3 = $("#tcnav_3").offset().top-10;
    var tch_4 = $("#tcnav_4").offset().top-10;
    $(window).scroll(function(event) {
        if($(window).scrollTop()<=tch_1){
        $(".tcnav li:eq(0)").addClass("fuwurtxt").siblings('li').removeClass('fuwurtxt');
        }
        else if($(window).scrollTop()<=tch_2){
            $(".tcnav li:eq(1)").addClass("fuwurtxt").siblings('li').removeClass('fuwurtxt');
        }
        else if($(window).scrollTop()<=tch_3){
            $(".tcnav li:eq(2)").addClass("fuwurtxt").siblings('li').removeClass('fuwurtxt');
        }
        else if($(window).scrollTop()<=tch_4){
            $(".tcnav li:eq(3)").addClass("fuwurtxt").siblings('li').removeClass('fuwurtxt');
        }else{
            $(".tcnav li:eq(4)").addClass("fuwurtxt").siblings('li').removeClass('fuwurtxt');
        }
    });
})