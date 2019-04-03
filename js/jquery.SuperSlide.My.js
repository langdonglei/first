$(function () {
    //banner
    jQuery(".slideBox").slide({
        mainCell: ".bd ul",
        titCell: ".hd ul",
        effect: "leftLoop",
        autoPlay: true,
        autoPage: true
    });
    //solution
    jQuery(".picScroll-top").slide({
        titCell: "",
        mainCell: ".bd2 ul",
        autoPage: true,
        effect: "topLoop",
        autoPlay: true,
        vis: 3,
        trigger: "click"
    });
    //case
    jQuery(".picMarquee-left").slide({
        mainCell: ".bd3 ul",
        autoPlay: true,
        effect: "leftMarquee",
        vis: 10,
        interTime: 50
    });
});