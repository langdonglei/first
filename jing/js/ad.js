/**
 * Created by webrx on 2017/1/13.
 */
$(function(){
    $(".focusBox").hover(function () {
        $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.2)
    }, function () {
        $(this).find(".prev,.next").fadeOut()
    });

    $(".focusBox").slide({
        mainCell: ".pic",
        effect: "leftLoop",
        titCell: '.hd',
        autoPage: true,
        autoPlay: true,
        delayTime: 600,
        trigger: "click"
    });
})