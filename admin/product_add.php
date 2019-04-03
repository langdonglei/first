<?php
require_once 'log.php';
require_once '../inc/d.php';
require_once '../inc/f.php';
require_once '../inc/i.php';
$class_s = query('hw_product_class');
if (isset($_POST['class'])) {
    $img_s = upload('../upload/product/big');
    $d['product_class'] = $_POST['class'];
    $d['sub'] = isset($_POST['sub']) ? $_POST['sub'] : '';
    $d['product_img'] = $img_s[0];
    $d['product_name'] = $_POST['name'];
    $d['product_model'] = $_POST['model'];
    $d['product_content'] = $_POST['content'];
    $id = saveArrayReturnID('hw_image_product', $d);
    foreach ($img_s as $img) {
        thumbs('../upload/product/big/' . $img, 'mid', 399, 399);
        thumbs('../upload/product/big/' . $img, 'small', 68, 68);
        thumbs('../upload/product/big/' . $img, 'box', 147, 80);
        logo('../upload/product/big/' . $img);
        $dd['image_pid'] = $id;
        $dd['image_img'] = $img;
        saveArray('hw_image', $dd);
    }
    header('location:product_manager.php');
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head" id="add">
        <strong><span class="icon-pencil-square-o"></span><span>添加产品</span></strong>
    </div>
    <div class="body-content">
        <form method="post" id="fm" class="form-x" action="" enctype="multipart/form-data">
            <!--主类-->
            <div class="form-group">
                <div class="label"><label>主类：</label></div>
                <div class="field">
                    <select title="" id="cat" name="class" onchange="location.href='?pid='+this.value">
                        <?php
                        //TODO 如果最后选择主类 其他已填信息会消失
                        printf('<option value="">请选择主类</option>');
                        foreach ($class_s as $class) {
                            if (isset($_GET['pid']) && $_GET['pid'] == $class['class_id']) {
                                printf('<option selected value="%d">%s</option>', $class['class_id'], $class['class_name']);
                                continue;
                            }
                            printf('<option value="%d">%s</option>', $class['class_id'], $class['class_name']);
                        } ?>
                    </select>
                </div>
            </div>
            <!--子类-->
            <div class="form-group">
                <div class="label"><label>子类：</label></div>
                <div class="field">
                    <select title="" name="sub">
                        <?php
                        if (isset($_GET['pid'])) {
                            $sub_s = query('sub', 'pid=' . $_GET['pid']);
                            if (empty($sub_s)) {
                                printf('<option>无子类</option>');
                            }
                            foreach ($sub_s as $sub) {
                                printf('<option value="%d">%s</option>', $sub['id'], $sub['nam']);
                            }
                        } else {
                            printf('<option>无子类</option>');
                        } ?>
                    </select>
                </div>
            </div>
            <!--图片-->
            <div class="form-group">
                <div class="label"><label>图片：</label></div>
                <div class="field">
                    <input type="file" id="file" name="file[]" multiple/>
                    <div class="tips">必须大于400*400,可多选</div>
                </div>
            </div>
            <!--名称-->
            <div class="form-group">
                <div class="label"><label>名称：</label></div>
                <div class="field">
                    <input title="" type="text" id="nam" name="name" class="input w50"
                           data-validate="required:请输入产品名称"/>
                    <span class="mtip"></span>
                </div>
            </div>
            <!--型号-->
            <div class="form-group">
                <div class="label"><label>型号：</label></div>
                <div class="field">
                    <input title="" id="mod" type="text" name="model" class="input w50"
                           data-validate="required:请输入产品型号"/>
                    <div class="tips"></div>
                </div>
            </div>
            <!--内容-->
            <div class="ue">
                <?php require_once 'ue.php' ?>
            </div>
            <!--提交-->
            <div class="form-group">
                <div class="label"><label></label></div>
                <div class="field">
                    <button type="button" onclick="location.href='product_manager.php'"
                            class="button bg-main icon-check-square-o">返回
                    </button>
                    <button type="button" id="sb" class="button bg-main icon-check-square-o mysubmit">
                        提交
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //验证产品名
    var t;
    $('#nam').on('input', function () {
        clearTimeout(t);
        var me = $(this);
        t = setTimeout(function () {
            $.ajax({
                url: 'ajax.php',
                type: 'post',
                cache: false,
                async: false,
                data: {
                    pnam: me.val()
                },
                dataType: 'text',
                success: function (t) {
                    if (eval(t)) {
                        $('#sb').removeAttr('disabled');
                        me.next().html('');
                    } else {
                        $('#sb').prop('disabled', true);
                        me.next().html('已存在');
                    }
                }
            })
        }, 1000)
    });
    //提交
    $('#sb').click(function () {
        if ($('#cat').val() == '' || $('#file').val() == '') {
            //TODO 更详细的提示
            alert('请检查');
        } else {
            $('#fm').submit();
        }
    })

</script>
</body>
</html>