<?php
require_once 'log.php';
require_once '../inc/d.php';
$d['banner_id'] = $_POST['uid'];
$d['banner_name'] = $_POST['name'];
$d['banner_url'] = $_POST['url'];
$d['banner_flag'] = $_POST['flag'];
updateArrayInnerPK('hw_banner', $d);
header('location:banner_manager.php');