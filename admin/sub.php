<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<?php
require_once 'log.php';
//页面接值 类别ID
$cid = $_GET['cid'];
//添加子类
if (isset($_GET['add'])) {
    $arr['nam'] = $_GET['add'];
    $arr['pid'] = $_GET['cid'];
    $conn->saveArrayReturnPID('sub', $arr);
}
//删除子类
if (isset($_GET['sid4d'])) {
    deleteByPId('sub', $_GET['sid4d']);
}
//修改子类
if (isset($_GET['sid4s'])) {
    $arr['id'] = $_GET['sid4s'];
    $arr['nam'] = $_GET['nam'];
    updateArrayInnerPK('sub', $arr);
}
?>
<div class="panel admin-panel">
    <div class="panel-head" id="add">
        <strong>
            <span class="icon-pencil-square-o"></span>
            <?php $cat = $conn->queryByPID('hw_product_class', $cid) ?>
            <span>正在添加【<?= $cat[0]['class_name'] ?>】子类别</span>
        </strong>
    </div>
    <div class="body-content">
        <!--查询显示子类-->
        <table class="table table-hover text-center">
            <tr>
                <td>ID</td>
                <td>子类</td>
                <td>操作</td>
            </tr>
            <?php
            //获取子类集
            $sub_s = $conn->queryByWhere('sub', 'pid=' . $cid);
            //遍历显示子类信息
            foreach ($sub_s as $sub) {
                printf('<tr><td>ID</td><td>');
                if (isset($_GET['sid4u']) && $_GET['sid4u'] == $sub['id']) {
                    printf('<input type="text" class="sname2s" name="nam" value="%s" form="form4s">', $sub['nam']);
                    echo '<span></span>';
                } else {
                    echo $sub['nam'];
                }
                printf('</td><td>');
                if (isset($_GET['sid4u']) && $_GET['sid4u'] == $sub['id']) {
                    printf('<form action="" method="get" id="form4s">');
                    printf('<input type="hidden" name="cid" value="%d">', $cid);
                    printf('<input type="hidden" name="sid4s" value="%d">', $sub['id']);
                    printf('<a class="button border-red" href="?cid=%d">', $cid);
                    printf('<span class="icon-trash-o"></span>');
                    printf('<span>取消</span>');
                    printf('</a>');
                    printf('<button class="sb2s button bg-main icon-check-square-o" type="submit">保存</button>');
                    printf('</form>');
                } else {
                    printf('<a class="button border-red" href="?cid=%d&sid4d=%d">', $cid, $sub['id']);
                    printf('<span class="icon-trash-o"></span>');
                    printf('<span>删除</span>');
                    printf('</a>');
                    printf('<a class="button border-red" href="?cid=%d&sid4u=%d">', $cid, $sub['id']);
                    printf('<span class="icon-trash-o"></span>');
                    printf('<span>修改</span>');
                    printf('</a>');
                }
                printf('</td></tr>');
            }
            ?>
        </table>
        <!--添加子类表单-->
        <form action="" method="get" class="form-x" id="form4a">
            <input type="hidden" name="cid" value="<?= $cid ?>">
            <div class="form-group">
                <div class="label"><label>子类名称：</label></div>
                <div class="field">
                    <label for="sname2a"></label>
                    <input type="text" id="sname2a" name="add" class="input w50" autofocus/>
                    <span class="mtip"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label></label></div>
                <div class="field">
                    <button type="button" onclick="location.href='productClass_manager.php'"
                            class="button bg-main icon-check-square-o">返回
                    </button>
                    <button type="submit" id="sb2a" class="button bg-main icon-check-square-o">添加
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //验证子类名(添加)
    var $sname2a = $('#sname2a');
    var $sb2a = $('#sb2a');
    $sname2a.on('input', function () {
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            cache: false,
            async: false,
            data: {sname: $sname2a.val()},
            dataType: 'text',
            success: function (t) {
                if (eval(t)) {
                    $sname2a.next().html('');
                    $sb2a.removeAttr('disabled');
                } else {
                    $sname2a.next().html('已存在');
                    $sb2a.prop('disabled', true);
                }
            }
        });
    });
    //验证子类名(修改)
    var $sname2s = $('.sname2s');//注意 选择的是 样式名 原因是 在循环里 不能定义id 因为id不能重复
    var $sb2s = $('.sb2s');
    var ov = $sname2s.val();
    $sname2s.on('input', function () {
        if (ov == $sname2s.val()) {
            $sname2s.next().html('');
            $sb2s.removeAttr('disabled');
        } else {
            $.ajax({
                type: 'post',
                url: 'ajax.php',
                cache: false,
                async: false,
                data: {sname: $sname2s.val()},
                dataType: 'text',
                success: function (t) {
                    if (eval(t)) {
                        $sname2s.next().html('');
                        $sb2s.removeAttr('disabled');
                    } else {
                        $sname2s.next().html('已存在');
                        $sb2s.prop('disabled', true);
                    }
                }
            });
        }
    });
</script>
</body>
</html>