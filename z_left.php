<div class="sidebar">
    <div class="fenlei">
        <div class="fenlei_title">产品分类</div>
        <div class="fenlei_content">
            <ul>
                <?php
                $class_s = query('hw_product_class');
                foreach ($class_s as $class) {
                    ?>
                    <li>
                        <a href="product.php?cid=<?= $class['class_id'] ?>"><?= $class['class_name'] ?></a>
                        <?php
                        $sub_s = query('sub', 'pid=' . $class['class_id']);
                        if (!empty($sub_s)) {
                            printf('<ul>');
                            foreach ($sub_s as $sub) {
                                $ls_pn = query('hw_image_product', 'sub=' . $sub['id'], 'count(*)');
                                printf("<li><a href='product.php?cid=%d'>%s</a></li>", $sub['id'], $sub['nam']);
                            }
                            printf('</ul>');
                        }
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="solution">
        <div class="solution_title">解决方案</div>
        <div class="solution_content">
            <div class="picScroll-top">
                <div class="bd2">
                    <ul class="picList">
                        <?php
                        $solution_s = query('hw_article', 'article_class=25');
                        foreach ($solution_s as $solution) { ?>
                            <li>
                                <div class="pic">
                                    <a href="solution.php">
                                        <img src="upload/article/titleImage/<?= $solution['article_img'] ?>"/>
                                    </a>
                                </div>
                                <div class="sw">
                                    <a href="solution.php">
                                        <?= $solution['article_name'] ?>
                                    </a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //sidebar
    //TODO 为什么包在ready里就不行了
    $('.fenlei_content >ul>li').find('ul').hide();
    $('.fenlei_content >ul>li').hover(function () {
        $(this).find('ul').stop().slideDown(1000);
    }, (function () {
        $(this).find('ul').stop().slideUp(1000);
    }))
</script>