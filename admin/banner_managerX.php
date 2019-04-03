<?php
require_once 'log.php';
require_once '../inc/d.php';
deleteByPId('hw_banner', $_GET['did']);
header('location:banner_manager.php');