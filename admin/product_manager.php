<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<script>
    console.log(<?=json_encode($_GET)?>);
</script>
<?php require_once 'log.php';
$_GET['cid'] = isset($_GET['cid']) ? $_GET['cid'] : 0;
$_GET['sid'] = isset($_GET['sid']) ? $_GET['sid'] : 0;
$_GET['p'] = isset($_GET['p']) ? $_GET['p'] : 1;
$_GET['kw'] = isset($_GET['kw']) ? $_GET['kw'] : '';
$_GET['toggle'] = isset($_GET['toggle']) ? $_GET['toggle'] : 1;
//删除
if (isset($_GET['pid2d'])) {
    $conn->deleteByPID('hw_image_product', $_GET['pid2d']);
    header('location:product_manager.php?p=' . $_GET['p']);
}
//删除选中的产品
if (isset($_GET['pids2d'])) {
    foreach ($_GET['pids2d'] as $pid) {
        $img2d_s = query('hw_image', 'image_pid=' . $pid);
        foreach ($img2d_s as $img2d) {
            $imgName = $img2d['image_img'];
            @unlink("../upload/product/big/$imgName");
            @unlink("../upload/product/mid/$imgName");
            @unlink("../upload/product/box/$imgName");
            @unlink("../upload/product/small/$imgName");
        }
        $conn->deleteByPID('hw_image_product', $pid);
    }
}
//修改产品是否首页显示
if (isset($_GET['y'])) {
    $pn = query('hw_image_product', 'spi="y"', 'count(*)');
    if ($pn[0]['count(*)'] >= 9) {
        $tool->alertArt('首页最多显示9件产品');
    } else {
        $arr['product_id'] = $_GET['pid_index'];
        $arr['spi'] = $_GET['y'];
        updateArrayInnerPK('hw_image_product', $arr);
    }
}
if (isset($_GET['n'])) {
    $arr['product_id'] = $_GET['pid_index'];
    $arr['spi'] = $_GET['n'];
    updateArrayInnerPK('hw_image_product', $arr);
}
?>
<form action="" method="get" id="form2ds"></form>
<div class="panel admin-panel">
    <div class="padding border-bottom">
        <ul class="search" style="padding-left:10px;">
            <li>
                <button id="bt2ds" class="button border-red icon-trash-o">删除已选</button>
            </li>
            <li>
                <form action="" method="get" id="form2kw">
                    <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                    <input type="hidden" name="sid" value="<?= $_GET['sid'] ?>">
                    <input type="text" name="kw" id="kw" placeholder="请输入搜索关键字" autofocus class="input"
                           style="width:250px;display:inline-block"/>
                    <button type="sb2kw" class="button border-main icon-search">搜索</button>
                </form>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th><label><input type="checkbox" name="" id="sa">全选</label></th>
            <th>ID</th>
            <th>图片</th>
            <th>名称</th>
            <th>型号</th>
            <th>
                <button type="button" id="qip">首页显示</button>
            </th>
            <!--主类-->
            <th>
                <label for="cat"></label>
                <select id="cat">
                    <?php
                    $cat_s = $conn->queryByWhere('hw_product_class');
                    printf('<option value="0">主类</option>');
                    foreach ($cat_s as $cat) {
                        if ($cat['class_id'] == $_GET['cid']) {
                            printf('<option selected value="%d">%s</option>', $cat['class_id'], $cat['class_name']);
                            continue;
                        }
                        printf('<option value="%d">%s</option>', $cat['class_id'], $cat['class_name']);
                    }
                    ?>
                </select>
            </th>
            <!--子类-->
            <th>
                <label for="sub"></label>
                <select id="sub">
                    <?php
                    printf('<option value="0">子类</option>');
                    $sub_s = $conn->queryByWhere('sub', 'pid=' . $_GET['cid']);
                    foreach ($sub_s as $sub) {
                        if ($sub['id'] == $_GET['sid']) {
                            printf('<option selected value="%d">%s</option>', $sub['id'], $sub['nam']);
                            continue;
                        }
                        printf('<option value="%d">%s</option>', $sub['id'], $sub['nam']);
                    }
                    ?>
                </select>
            </th>
            <th>操作</th>
        </tr>
        <?php
        //////////////////////////////////////////////////////////开始搜索
        //1、按类别搜索
        if (isset($_GET['kw']) && !empty(trim($_GET['kw']))) {
            //1.1、1=1 and like kw
            if ($_GET['cid'] == 0) {
//                echo '1.1';
                $product_p = page('hw_image_product', 6, '*', "product_name like '%" . $_GET['kw'] . "%'", 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id', '&kw=' . $_GET['kw']);
                ?>
                <script>
                    $("#kw").val("<?=$_GET['kw']?>");
                    $("table tr:first-child").after("<tr><td colspan='5' style='color:red;'>在 [全部类别] 中 共搜索到 [ <?php echo $product_p['recordcount']?> ] 条 关于 [ <?php echo $_GET['kw']?> ] 的产品</td><td colspan='1'><a href='product_manager.php?pid=<?=$_GET['pid']?>' class='button border-red'><span class='icon-dashboard'></span><span>关闭搜索结果</span></a></td></tr>")
                </script>
            <?php
            //1.2、class=cid and like kw
            } else if ($_GET['pid'] != 0) {
            //            echo '1.2';
            $product_p = page('hw_image_product', 6, '*', 'product_class=' . $_GET['pid'] . " and product_name like '%" . $_GET['kw'] . "%'", 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id', '&pid=' . $_GET['pid'] . '&kw=' . $_GET['kw']);//and前面必须加空格
            $c = queryByPID('hw_product_class', $_GET['pid']);
            ?>
                <script>
                    $("#kw").val("<?=$_GET['kw']?>");
                    $("table tr:first-child").after("<tr><td colspan='5' style='color:red;'>在 [<?php echo $c['class_name']?>] 类别中 共搜索到 <?php echo $product_p['recordcount']?> 条 关于 [ <?php echo $_GET['kw']?> ] 的产品</td><td colspan='1'><a href='product_manager.php?pid=<?=$_GET['pid']?>' class='button border-red'><span class='icon-dashboard'></span><span>关闭搜索结果</span></a></td></tr>")
                </script>
            <?php
            //1.3  sub=sid and like kw
            }else if ($_GET['sid'] != 0){
            //            echo '1.3';
            $product_p = page('hw_image_product', 6, '*', 'sub=' . $_GET['sid'] . " and product_name like '%" . $_GET['kw'] . "%'", 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id', '&sid=' . $_GET['sid'] . '&kw=' . $_GET['kw']);//and前面必须加空格
            $c = queryByPID('hw_product_class', $_GET['cid']);
            $s = queryByPID('sub', $_GET['sid']);
            ?>
                <script>
                    $("#kw").val("<?=$_GET['kw']?>");
                    $("table tr:first-child").after("<tr><td colspan='5' style='color:red;'>在 [<?php echo $c['class_name']?>][<?php echo $s['nam']?>] 类别中 共搜索到 <?php echo $product_p['recordcount']?> 条 关于 [ <?php echo $_GET['kw']?> ] 的产品</td><td colspan='1'><a href='product_manager.php?cid=<?=$_GET['cid']?>' class='button border-red'><span class='icon-dashboard'></span><span>关闭搜索结果</span></a></td></tr>")
                </script>
                <?php
            }
            //2、class=cid
        } else
            if ($_GET['cid'] != 0 && $_GET['sid'] == 0) {
//                echo '2';
                $product_p = page('hw_image_product', 6, '*', 'product_class=' . $_GET['cid'], 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id', '&cid=' . $_GET['cid']);
                //3、sub=sid
            } else if ($_GET['sid'] != 0) {
//                echo '3';
                $product_p = page('hw_image_product', 6, '*', 'sub=' . $_GET['sid'], 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id', '&cid=' . $_GET['cid'] . '&sid=' . $_GET['sid']);
                //4、1=1 cid=0 sid=0
            } else {
//                echo '4';
                $product_p = page('hw_image_product', 6, '*', '1=1', 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id');
            }
        if (isset($_GET['qip']) && $_GET['qip'] == 1) {
            $product_p = page('hw_image_product', 6, '*', "spi='y'", 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id', '&qip=' . $_GET['qip']);
        } else if ((isset($_GET['qip']) && $_GET['qip'] == 0)) {
            $product_p = page('hw_image_product', 6, '*', '1=1', 'order by product_id desc', 'left join hw_product_class on product_class=class_id left join sub on sub=id');
        }
        //////////////////////////////////////////////////////////搜索结束
        foreach ($product_p['rows'] as $product) { ?>
            <tr>
                <td>
                    <label for="pids2d"></label>
                    <input type="checkbox" form="form2ds" id="pids2d" name="pids2d[]"
                           value="<?= $product['product_id'] ?>">
                </td>
                <td><?= $product['product_id'] ?></td>
                <td>
                    <?php
                    $img_s = query('hw_image', 'image_pid=' . $product['product_id']);
                    //foreach ($img_s as $img) {
                    printf('<img width="50" height="50" src="../upload/product/small/%s"/>', $img_s[0]['image_img']);
                    //}
                    ?>
                </td>
                <td>
                    <?= $product['product_name'] ?>
                </td>
                <td>
                    <?= $product['product_model'] ?>
                </td>
                <!--首页显示-->
                <td>
                    <label>
                        <?php
                        if ($product['spi'] == 'y') {
                            printf('<input type="checkbox" checked onchange="location.href=\'product_manager.php?pid_index=%d&n=n&p=%d&pid=%s&sid=%s&kw=%s\'">显示', $product['product_id'], $_GET['p'], $_GET['cid'], $_GET['sid'], $_GET['kw']);
                        } else if ($product['spi'] == 'n') {
                            printf('<input type="checkbox" onchange="location.href=\'product_manager.php?pid_index=%d&y=y&p=%d&pid=%s&sid=%s&kw=%s\'">显示', $product['product_id'], $_GET['p'], $_GET['cid'], $_GET['sid'], $_GET['kw']);
                        }
                        ?>
                    </label>
                </td>
                <td>
                    <?= $product['class_name'] ?>
                </td>
                <td>
                    <?= $product['nam']; ?>
                </td>
                <td>
                    <div class="button-group">
                        <a href="product_update.php?uid=<?= $product['product_id'] ?>&p=<?= $product_p['p'] ?>"
                           class="button border-red">
                            <span class="icon-edit"></span><span>修改</span>
                        </a>
                        <a href="javascript:pid2d(<?=$product['product_id']?>)"
                           class="button border-red">
                            <span class="icon-trash-o"></span><span>删除</span>
                        </a>
                        <input type="hidden" value="<?= $product['product_id'] ?>" id="3">
                        <a href="../detail_product.php?id=<?= $product['product_id'] ?>"
                           class="button border-red">
                            <span class="icon-trash-o"></span><span>前台查看</span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $product_p['info']; ?>
</div>
<script>
    $('#cat').change(function () {
        location.href = '?cid=' + this.value;
    });
    $('#sub').change(function () {
        location.href = '?sid=' + this.value + '&cid=<?= $_GET['cid'] ?>';
    });
    function pid2d(id) {
        art.dialog.confirm('确认要删除吗？', function () {
            location.href = '?pid2d='+id+'&p=<?= $product_p['p'] ?>';
        })
    }
    //查看首页显示的所有产品
    $('#qip').click(function () {
        if (<?=$_GET['toggle']?>==1
        )
        {
            location.href = 'product_manager.php?qip=1&toggle=0';
        }
        else
        if (<?=$_GET['toggle']?>==0
        )
        {
            location.href = 'product_manager.php?qip=0&toggle=1';
        }
    });
    //全选
    $("#sa").click(function () {
        if (this.checked) {
            $("input[name='dsp[]']").each(function () {
                this.checked = true;
            });
        } else {
            $("input[name='dsp[]']").each(function () {
                this.checked = false;
            });
        }
    });
    //批量删除
    $('#bt2ds').click(function () {
        var hasCheck = false;
        $("input[name='dsp[]']").each(function () {
            if (this.checked == true) {
                hasCheck = true;
            }
        });
        if (hasCheck) {
            art.dialog.confirm("您确认要删除选中的内容吗？", function () {
                $("#form2ds").submit();
            });
        }
        else {
            art.dialog.tips("请选择您要删除的内容!");
            return false;
        }
    })
</script>
</body>
</html>

