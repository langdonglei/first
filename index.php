<?php
require_once 'inc/d.php';
$product_s = query('hw_image_product', 'product_img is not null and spi="y"', '*', '', 'limit 9');
?>
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
            <div class="shouye_top">
                <div class="chanpintuijian">
                    <div class="chanpintuijian_title">产品推荐<a href="#"><img src="img/more.jpg"></a></div>
                    <div class="chanpintuijian_content">
                        <?php
                        foreach ($product_s as $product) {
                            ?>
                            <div class="my_product_box">
                                <a href="detail_product.php?id=<?= $product['product_id'] ?>">
                                    <img src="upload/product/box/<?= $product['product_img'] ?>">
                                    <span><?= $product['product_name'] ?></span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="qiyejianjie">
                    <div class="qiyejianjie_title">公司简介<a href="#"><img src="img/more.jpg"></a></div>
                    <div class="qiyejianjie_content">
                        <p>
                            公司本着诚信、务实的经营原则，以强大的技术为基础，以服务为根本，以市场为导向，为广大用户提供先进技术、具有高性价比的视音频整体解决方案。地址：郑州市金水区经三路北95号格林融熙国际大厦。</p>
                        <img src="img/intro.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="shouye_middle">
                <div class="gongsidongtai">
                    <div class="gongsidongtai_title">公司动态<a href="#"><img src="img/more.jpg" alt=""/></a></div>
                    <div class="gongsidongtai_content">
                        <ul>
                            <?php
                            $news_s = query('hw_article', 'article_class=19', '*', 'limit 10');
                            foreach ($news_s as $news) {
                                ?>
                                <li>
                                    <span><?= date('Y-m-d', $news['article_time']) ?></span>
                                    <a href="detail_article.php?id=<?= $news['article_id'] ?>"><?= $news['article_name'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="lianxiwomen">
                    <div class="lianxiwomen_title">联系我们<a href="about.php"><img src="img/more.jpg"></a></div>
                    <div class="lianxiwomen_content">
                        <img width="150" src="img/er2.png" alt="">
                        <p>扫描二维码</p>
                        <p>关注我们</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
<?php include 'service.php' ?>
</body>
</html>