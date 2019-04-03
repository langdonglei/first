<?php
require_once 'log.php';
require_once '../inc/d.php';
//修改
if (isset($_POST['uuid'])) {
    $d['class_id'] = $_POST['uuid'];
    $d['class_sort'] = $_POST['sort'];
    $d['class_name'] = $_POST['name'];
    updateArrayInnerPK('hw_product_class', $d);
    header('location:productClass_manager.php');
}
//查询显示
$class = queryByPID('hw_product_class', $_GET['uid']);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head" id="add">
        <strong>
            <span class="icon-pencil-square-o"></span>
            <span>修改产品类别</span>
        </strong>
    </div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <input type="hidden" name="uuid" value="<?= $class['class_id'] ?>">
            <div class="form-group">
                <div class="label">
                    <label>排序：</label>
                </div>
                <div class="field">
                    <input type="text" name="sort" value="<?= $class['class_sort'] ?>" class="input w50" autofocus/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>类别：</label>
                </div>
                <div class="field">
                    <input type="text" id="ajuc" name="name" value="<?= $class['class_name'] ?>" class="input w50"/>
                    <div class="mtip"></div>
                </div>
                <script>
                    //验证修改主类名
                    var ajuct;
                    var ajucov = $('#ajuc').val()
                    $('#ajuc').on('input', function () {
                        clearTimeout(ajuct);
                        var ajuc = $(this);
                        if (ajuc.val() == ajucov) {
                            $('#ajucsb').removeAttr('disabled');
                            ajuc.next().html('');
                        } else {
                            ajuct = setTimeout(function () {
                                $.ajax({
                                    url: 'ajax.php',
                                    type: 'post',
                                    cache: false,
                                    async: false,
                                    data: {
                                        cname: $('#ajuc').val()
                                    },
                                    dataTye: 'text',
                                    success: function (t) {
                                        if (eval(t)) {
                                            $('#ajucsb').removeAttr('disabled');
                                            ajuc.next().html('');
                                        } else {
                                            $('#ajucsb').prop('disabled', true);
                                            ajuc.next().html('已存在');
                                        }
                                    }
                                });
                            }, 1000);
                        }
                    });
                </script>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button type="button" onclick="location.href='productClass_manager.php'"
                            class="button bg-main icon-check-square-o">返回
                    </button>
                    <button type="submit" id="ajucsb" class="button bg-main icon-check-square-o">修改</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>