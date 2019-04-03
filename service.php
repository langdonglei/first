<div class="yb_conct">
    <div class="yb_bar">
        <ul>
            <li class="yb_top">返回顶部</li>
            <li class="yb_phone">4008-123-456</li>
            <li class="yb_QQ">
                <a target="_blank"
                   href="http://wpa.qq.com/msgrd?v=3&amp;uin=954502368&amp;site=qq&amp;menu=yes&amp;from=message&amp;isappinstalled=0"
                   title="即刻发送您的需求">在线咨询</a>
            </li>
            <li class="yb_ercode" style="height:53px;">微信二维码 <br>
                <img class="hd_qr" src="img/weixin.png" width="125" alt="关注你附近"></li>
        </ul>
    </div>
</div>
<script>
    // 悬浮窗口
    $(".yb_conct").hover(function () {
        $(".yb_conct").css("right", "5px");
        $(".yb_bar .yb_ercode").css('height', '200px');
    }, function () {
        $(".yb_conct").css("right", "-127px");
        $(".yb_bar .yb_ercode").css('height', '53px');
    });
    // 返回顶部
    $(".yb_top").click(function () {
        $("html,body").animate({
            'scrollTop': '0px'
        }, 300)
    });
</script>
</body>