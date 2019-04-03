<div class="header_logo">
    <div class="w">
        <a href="index.php"><img height="98" src="img/logo.gif"></a>
        <span>服务热线: <i>0371-86017908</i></span>
        <span>
            <input type="text" id="kw" title="">
            <a href="javascript:void(0)" onclick="location.href='serch.php?kw='+document.getElementById('kw').value"
               class="s_btn"></a>
        </span>
    </div>
</div>
<div class="header_nav">
    <div class="w">
        <ul>
            <li><a href="index.php">网站首页</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="intro.php">企业简介</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="quali.php">企业资质</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="news.php">新闻资讯</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="solution.php">解决方案</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="product.php">产品中心</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="case.php">成功案例</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="tec.php">技术支持</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="book.php">客户留言</a></li>
            <li><img src="img/nav_split.jpg"></li>
            <li><a href="about.php">联系我们</a></li>
        </ul>
    </div>
</div>
<div class="banner">
    <div class="w">
        <div id="slideBox" class="slideBox">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd">
                <ul>
                    <?php
                    require_once 'inc/d.php';
                    $banner_s = query('hw_banner', "banner_flag='y'");
                    foreach ($banner_s as $banner) { ?>
                        <li><a href="#"><img src="upload/banner/<?= $banner['banner_img'] ?>"/></a></li>
                    <?php } ?>
                </ul>
            </div>
            <a class="prev" href="javascript:void(0)"></a>
            <a class="next" href="javascript:void(0)"></a>
        </div>
    </div>
</div>
<div class="case">
    <div class="w">
        <div class="picMarquee-left">
            <div class="hd3">
                <span>成功案例</span>
                <a class="next"></a>
                <a class="prev"></a>
            </div>
            <div class="bd3">
                <ul class="picList">
                    <?php
                    require_once 'inc/d.php';
                    $case_s = query('hw_article', 'article_class=23');
                    foreach ($case_s as $case) {
                        ?>
                        <li>
                            <div class="pic"><a href="detail_article.php?id=<?= $case['article_id'] ?>"><img
                                            src="upload/article/titleImage/<?= $case['article_img'] ?>"/></a></div>
                            <div class="title"><a
                                        href="detail_article.php?id=<?= $case['article_id'] ?>"><?= $case['article_name'] ?></a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $('#kw').autocomplete({
        source: 'ajax.php'
    })
</script>
