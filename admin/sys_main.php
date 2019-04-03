<?php
require_once 'log.php';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
    <title>后台管理中心</title>
</head>
<script>
    art.dialog.alert('能弹出么');
</script>
<body>
<div class="header bg-main">
    <div class="logo margin-big-left fadein-top">
        <h1>
            <img src="images/y.jpg" class="radius-circle rotate-hover" height="50" alt=""/>
            后台管理中心
        </h1>
    </div>
    <div class="head-l">
        <a class="button button-little bg-green" href="../index.php" target="new">
            <span class="icon-home"></span>
            前台首页
        </a> &nbsp;&nbsp;
        <a class="button button-little bg-red" href="logout.php">
            <span class="icon-power-off"></span>
            退出登录
        </a>
    </div>
    <a class="head-l float-right margin-right">
        <strong class="button button-little bg-red">
            欢迎【<?= $_SESSION['admin'] ?>
            】&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上次登陆时间【<?= $_SESSION['time'] ?>
            】&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上次登陆IP【<?= $_SESSION['ip'] ?>】
        </strong>
    </a>
</div>
<div class="leftnav">
    <div class="leftnav-title">
        <strong>
            <span class="icon-list"></span>
            菜单列表
        </strong>
    </div>
    <h2><a href="book.php" target="right"><span class="icon-user"></span>客户留言</a></h2>
    <h2><span class="icon-user"></span>系统管理</h2>
    <ul style="display:block">
        <li><a href="admin_add.php" target="right"><span class="icon-caret-right"></span>添加管理员</a></li>
        <li><a href="admin_update.php" target="right"><span class="icon-caret-right"></span>修改管理员密码</a></li>
    </ul>
    <h2><span class="icon-user"></span>广告管理</h2>
    <ul style="display:block">
        <li><a href="banner_add.php" target="right"><span class="icon-caret-right"></span>添加广告</a></li>
        <li><a href="banner_manager.php" target="right"><span class="icon-caret-right"></span>管理广告</a></li>
    </ul>
    <h2><span class="icon-user"></span>资质管理</h2>
    <ul style="display:block">
        <li><a href="quali_add.php" target="right"><span class="icon-caret-right"></span>添加资质</a></li>
        <li><a href="quali_manager.php" target="right"><span class="icon-caret-right"></span>管理资质</a></li>
    </ul>
    <h2><span class="icon-user"></span>栏目管理</h2>
    <ul style="display:block">
        <li><a href="article_add.php" target="right"><span class="icon-caret-right"></span>添加栏目内容</a></li>
        <li><a href="article_manager.php" target="right"><span class="icon-caret-right"></span>管理栏目内容</a></li>
    </ul>
    <h2><span class="icon-user"></span>产品管理</h2>
    <ul style="display:block">
        <li><a href="product_add.php" target="right"><span class="icon-caret-right"></span>添加产品</a></li>
        <li><a href="product_manager.php" target="right"><span class="icon-caret-right"></span>管理产品</a></li>
        <li><a href="productClass_manager.php" target="right"><span class="icon-caret-right"></span>类别管理</a></li>
    </ul>
</div>
<ul class="bread">
    <li><a href="book.php" target="right" class="icon-home">首页</a></li>
    <li><a href="#" id="a_leader_txt">网站信息</a></li>
</ul>
<div class="admin">
    <iframe scrolling="auto" frameborder="0" src="info.php" name="right" width="100%" height="100%"></iframe>
</div>
<script>
    var aa = $('h2:not(:first)');
    aa.removeClass("on").next().hide();
    aa.click(function () {
        $(this).siblings('h2:not(:first)').next().hide();
        $(this).next().toggle();
        //$('h2:not(:first)').removeClass("on").next().slideUp(200);
        //if ($(this).hasClass("on")) {
        //    $(this).next().slideUp(200);
        //    $(this).removeClass("on");
        //} else {
        //    $(this).next().slideDown(200);
        //    $(this).addClass("on");
        //}

    });
    //$('h2:not(:first)').removeClass("on").next().hide();
    //$(".leftnav h2").click(function () {
    //    $('h2:not(:first)').removeClass("on").next().slideUp(200);
    //    if ($(this).hasClass("on")) {
    //        $(this).next().slideUp(200);
    //        $(this).removeClass("on");
    //    } else {
    //        $(this).next().slideDown(200);
    //        $(this).addClass("on");
    //
    //
    //    }
    //});
    $(".leftnav ul li a").click(function () {
        $("#a_leader_txt").text($(this).text());
        $(".leftnav ul li a").removeClass("on");
        $(this).addClass("on");
    });
</script>
</body>
</html>