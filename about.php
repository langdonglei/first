<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'z_head.php' ?>
</head>
<body>
<?php require_once 'z_top.php' ?>
<div class="main">
    <div class="w">
        <?php include 'z_left.php' ?>
        <div class="box">
            <div>
                <div class="title2">联系我们</div>
                <div class="content2">
                    <p>郑州弘旺科贸有限公司</p>
                    <p>电 话： 0371-86017908</p>
                    <p>传 真： 0371-86017908</p>
                    <p>Q Q号： 529832899</p>
                    <p>邮 箱： zzhwkm@163.com</p>
                    <p>网 址： www.zzhwkm.com</p>
                    <p>地 址： 河南省郑州市金水区经三路北95号格林国际大厦</p>
                    <div id="allmap" class="bdmap" style="width:100%;height: 500px;border: 1px solid #c6c9c8;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var point = new BMap.Point(113.69985, 34.81073);
    var marker = new BMap.Marker(point);  // 创建标注
    map.addOverlay(marker);              // 将标注添加到地图中
    map.centerAndZoom(point, 15);
    map.enableScrollWheelZoom(true);
    var opts = {
        width: 200,     // 信息窗口宽度
        height: 100,     // 信息窗口高度
        title: "郑州弘旺科贸有限公司", // 信息窗口标题
        enableMessage: true,//设置允许信息窗发送短息
        message: "郑州弘旺科贸有限公司"
    }
    var infoWindow = new BMap.InfoWindow("地址：河南省郑州市金水区经三路北95号格林国际大厦", opts);  // 创建信息窗口对象
    marker.addEventListener("click", function () {
        map.openInfoWindow(infoWindow, point); //开启信息窗口
    });
</script>
</html>