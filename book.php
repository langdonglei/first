<?php
require_once 'admin/class/D.class.php';
$d = new \langdonglei\D();
$u = new \langdonglei\U();
if (isset($_POST['tit'])) {
    $d->saveArrayReturnPID('book', $_POST);
    $u->alert('保存成功');
}
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
            <div class="liuyan">
                <div class="title2">客户留言</div>
                <div class="content2">
                    <form action="" method="post">
                        <table border="0" cellspacing="10" cellpadding="0">
                            <tr>
                                <td>反馈标题：</td>
                                <td><input type="text" name="tit" size="45" title=""/> <i>*</i></td>
                            </tr>
                            <tr>
                                <td>反馈类别：</td>
                                <td>
                                    <select name="cat" title="">
                                        <option value="关于产品">--关于产品--</option>
                                        <option value="关于公司">--关于公司--</option>
                                        <option value="关于服务">--关于服务--</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>反馈内容：</td>
                                <td>
                                    <textarea name="content" rows="6" cols="44" title=""></textarea>
                                    <i>*</i>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">请告诉我们如何与您取得联系</td>
                            </tr>
                            <tr>
                                <td>姓名：</td>
                                <td><input name="nam" type="text" size="45" title=""/> <i>*</i></td>
                            </tr>
                            <tr>
                                <td>性别：</td>
                                <td>
                                    <select name="sex" title="">
                                        <option value="先生">--先生--</option>
                                        <option value="女士">--女士--</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>电话：</td>
                                <td><input name="tel" type="text" size="45" title=""/> <i>*</i></td>
                            </tr>
                            <tr>
                                <td>邮箱：</td>
                                <td><input name="eml" type="text" size="45" title=""/> <i>*</i></td>
                            </tr>
                            <tr>
                                <td>地址：</td>
                                <td><input name="adr" type="text" size="45" title=""/> <i>*</i></td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="reset" value="重置" class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="提交" class="btn"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
</html>