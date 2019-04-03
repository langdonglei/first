<?php
require_once 'log.php';
require_once '../inc/d.php';
require_once '../inc/f.php';
$d['banner_name'] = $_POST['name'];
$d['banner_img'] = upload('../upload/banner/',3)[0];
$d['banner_url'] = $_POST['url'];
$d['banner_flag'] = $_POST['flag'];
saveArray('hw_banner', $d);
header('location:banner_manager.php');
