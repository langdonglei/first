<?php


session_start();
require_once '../inc/d.php';
$flag = false;
//验证码
if (isset($_POST['veri'])) {
    $s = $_POST['veri'];
    $s = trim($s);
    if ($_SESSION['captcha'] == $s) {
        $flag = true;
    }
}
//登陆
if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $pwd = mm($_POST['pwd']);

    if ($rs = query('hw_admin', "admin_act='$user' and admin_pwd='$pwd'")) {

        $_SESSION['admin'] = $rs[0]['admin_act'];
        #$_SESSION['time'] = date('Y-m-d H:i:s', $rs[0]['admin_time']);
        #$_SESSION['ip'] = long2ip($rs[0]['admin_ip']);
        $d['admin_act'] = $rs[0]['admin_act'];
        #$d['admin_time'] = time();
        #$d['admin_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
        updateArrayInnerPK('hw_admin', $d);
        $flag = true;
    }
}
//产品名
if (isset($_POST['pnam'])) {
    $s = $_POST['pnam'];
    $s = trim($s);
    if (empty(query('hw_image_product', "product_name='$s'"))) {
        $flag = true;
    }
}
//主类名
if (isset($_POST['cname'])) {
    $s = $_POST['cname'];
    $s = trim($s);
    if (empty(query('hw_product_class', "class_name='$s'"))) {
        $flag = true;
    }
}
//子类名
if (isset($_POST['sname'])) {
    $s = $_POST['sname'];
    $s = trim($s);
    if (empty(query('sub', "nam='$s'"))) {
        $flag = true;
    }
}
if ($flag) {
    echo 'true';
} else {
    echo 'false';
}