<?php
require_once 'log.php';
require_once '../inc/d.php';
//添加主类别
if (isset($_POST['name'])) {
    $d['class_sort'] = (int)$_POST['sort'];
    $d['class_name'] = $_POST['name'];
    saveArray('hw_product_class', $d);
}
//删除主类别
if (isset($_GET['did'])) {
    deleteByWhere('sub', 'pid=' . $_GET['did']);//先删除主类下的所有子类
    deleteByPId('hw_product_class', $_GET['did']);//先删子类 后删主类
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head">
        <strong class="icon-reorder">管理产品类别</strong>
    </div>
    <div class="padding border-bottom">
        <ul class="search" style="padding-left:10px;">
            <form method="post" class="form-x" action="">
                <li>排序：</li>
                <li><input type="text" name="sort" class="input w150" placeholder="类别排序"/></li>
                <li>类别：</li>
                <li><input type="text" id="ajac" name="name" class="input w150" placeholder="添加类别"/></li>
                <li><span id="ajactip" class="mtip"></span></li>
                <li>
                    <button type="submit" id="ajacsb" class="button bg-main icon-check-square-o">添加</button>
                </li>
            </form>
            <script>

            </script>
            <li>搜索：</li>
            <form action="" method="get">
                <li><input type="text" id="kw" name="kw" class="input" placeholder="请输入搜索关键字" autofocus/></li>
                <li>
                    <button type="submit" class="button border-main icon-search">搜索</button>
                </li>
            </form>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>排序</th>
            <th>主类</th>
            <th>子类</th>
            <th>操作</th>
        </tr>
        <?php
        //搜索
        if (isset($_GET['kw']) && !empty(trim($_GET['kw']))) {
            $class_p = page('hw_product_class', 6, '*', "class_name like '%" . $_GET['kw'] . "%' or nam like '%" . $_GET['kw'] . "%'", 'order by class_sort desc', 'left join sub on class_id=pid', '&kw=' . $_GET['kw']);
            ?>
            <script>
                $("#kw").val("<?=$_GET['kw']?>");
                $("table tr:first-child").after("<tr><td colspan='3' style='color:red;'>共搜索到 [ <?php echo $class_p['recordcount']?> ] 条 关于 [ <?php echo $_GET['kw']?> ] 的【主类】或者【子类】</td><td colspan='1'><a href='productClass_manager.php' class='button border-red'><span class='icon-dashboard'></span><span>关闭搜索结果</span></a></td></tr>")
            </script>
            <?php
            //默认查询显示全部
        } else {
            $class_p = page('hw_product_class', 6, '*', '1=1', 'order by class_sort desc');
        }
        foreach ($class_p['rows'] as $class) {
            ?>
            <tr>
                <td>
                    <?= $class['class_sort'] ?>
                </td>
                <td>
                    <?= $class['class_name'] ?>
                </td>
                <td>
                    <?php
                    $sub_s = query('sub', 'pid=' . $class['class_id']);
                    foreach ($sub_s as $sub) {
                        echo $sub['nam'] . '&nbsp;&nbsp;';
                    }
                    ?>
                </td>
                <td>
                    <div class="button-group">
                        <a href="?did=<?= $class['class_id'] ?>&p=<?= $_GET['p'] ?>" class="button border-red">
                            <span class="icon-trash-o"></span><span>删除</span>
                        </a>
                        <a href="productClass_update.php?uid=<?= $class['class_id'] ?>" class="button border-red">
                            <span class="icon-edit"></span><span>修改</span>
                        </a>
                        <a href="sub.php?cid=<?= $class['class_id'] ?>" class="button border-red">
                            <span class="icon-edit"></span><span>修改子类</span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $class_p['info'] ?>
</div>
<script>
    //主类名
    var ajact;
    $('#ajac').on('input', function () {
        clearTimeout(ajact);
        var ajac = $(this);
        ajact = setTimeout(function () {
            $.ajax({
                url: 'ajax.php',
                type: 'post',
                cache: false,
                async: false,
                data: {
                    cname: $('#ajac').val()
                },
                dataType: 'text',
                success: function (t) {
                    if (eval(t)) {
                        $('#ajacsb').removeAttr('disabled');
                        ajac.next().html('');
                    } else {
                        $('#ajacsb').prop('disabled', true);
                        ajac.next().html('已存在');
                    }
                }
            })
        }, 1000);
    });
</script>
</body>
</html>