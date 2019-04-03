<?php
//连接数据库
$dsn = 'mysql:host=localhost;dbname=hw;port=3306;charset=utf8';
$user = 'root';
$pass = 'root';
try {
    $conn = new pdo($dsn, $user, $pass);
} catch (exception $e) {
    exit($e);
}
//关闭数据库
function close() {
    global $conn;
    unset($conn);
}

//弹窗
function alert($msg) {
    echo sprintf('<script>alert("%s");</script>', $msg);
}

//跳转
function go($url = '#', $carry = '') {
    echo sprintf("<script>location.href='%s%s'</script>", $url, $carry);
}

//获取主键
function getPK($tn) {
    global $conn;
    $stmt = $conn->prepare("show full columns from $tn");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pk = NULL;
    foreach ($rows as $value) {
        if ($value['Key'] == 'PRI') {
            $pk = $value['Field'];
            break;
        }
    }

    return $pk;
}

//表中是否存在 $w条件 (name='jack')
function exist($tn, $w) {
    global $conn;
    $flag = false;
    if (empty($w)) return $flag;
    //echo "select count(*) from $tn where $w";
    $stmt = $conn->prepare("select count(*) from $tn where $w");
    $stmt->execute();
    $stmt->bindColumn(1, $c);
    $stmt->fetch(PDO::FETCH_BOUND);
    $stmt->closeCursor();
    if ($c >= 1) $flag = true;

    return $flag;
}

//加密算法
function mm($m, $w = 'abc') {
    $mm = $m . $w;
    $m1 = md5($mm);
    $m2 = sha1($mm);
    $mm = substr($m1, 0, 5) . substr($m2, 0, 5);
    $mm .= substr($m1, 10, 5) . substr($m2, 10, 5);
    $mm .= substr($m1, 20, 5) . substr($m2, 20, 7);

    return $mm;
}

//增加一条记录 返回影响的行数0或1
//字段不管是一个还是多个 都必须放在一个关联数组中
/**
 * @param $tn
 * @param $arr_assoc
 *
 * @return int
 */
function saveArray($tn, $arr_assoc) {
    global $conn;
    $filds = array();
    $values = array();
    foreach ($arr_assoc as $key => $value) {
        $filds[] = $key;
        $values[] = ':' . $key;
    }
    $filds = implode(',', $filds);
    $values = implode(',', $values);
//    echo "insert into $tn($filds) values($values)";
//    die;
    $stmt = $conn->prepare("insert into $tn($filds) values($values)");
    $stmt->execute($arr_assoc);
    $stmt->closeCursor();

    return $stmt->rowCount();
}

//增加一条记录 返回当前插入的主键值（ID？）
//字段不管是一个还是多个 都必须放在一个关联数组中
function saveArrayReturnID($tn, $arr_assoc) {
    global $conn;
    foreach ($arr_assoc as $key => $value) {
        $filds[] = $key;
        $values[] = ':' . $key;
    }
    $filds = implode(',', $filds);
    $values = implode(',', $values);
//    echo "insert into $tn($filds) values($values)";
//    die;
//    echo '<pre>';
//    print_r($arr_assoc);
//    die;
    $stmt = $conn->prepare("insert into $tn($filds) values($values)");
    $stmt->execute($arr_assoc);//参数绑定再看看
    $stmt->closeCursor();

    return $conn->lastInsertId();
}

//删除一条记录 2参数  返回影响的行数0或1
//根据条件 主键ID 条件不能写字段
function deleteByPId($tn, $id) {
    global $conn;
    $pk = getPK($tn);
//    echo "delete from $tn where $pk=?";
//    die;
    $stmt = $conn->prepare("delete from $tn where $pk=?");
    $stmt->execute(array($id));
    $stmt->closeCursor();

    return $stmt->rowCount();
}

function deleteByWhere($tn, $w) {
    global $conn;
    $stmt = $conn->prepare("delete from $tn where $w");
    $stmt->execute();
    $stmt->closeCursor();
//    echo "delete from $tn where $w";
}

//修改一条记录 3参数 根据条件 条件必须写字段
//字段不管是一个还是多个 都必须放在一个关联数组中
function updateArray($tn, $arr_assoc, $w) {
    global $conn;
    foreach ($arr_assoc as $key => $value) {
        $filds[] = $key . '=:' . $key;
    }
    $filds = implode(',', $filds);
    //echo "update $tn set $filds where $w";
    $stmt = $conn->prepare("update $tn set $filds where $w");
    $stmt->execute($arr_assoc);
    $stmt->closeCursor();

    return $stmt->rowCount();
}

//修改一条记录 2参数 返回值0或1 如果有错-1或-2
//如果参数2的关联数组中必须含有主键字段 如果没有 则返回-2
//如果要插入的表中没有主键 返回-1
//字段不管是一个还是多个 都必须放在一个关联数组中
function updateArrayInnerPK($tn, $arr_assoc) {
    global $conn;
    $pk = getpk($tn);
    if (empty($pk)) return -1;//要插入的表中没有主键
    if (!array_key_exists($pk, $arr_assoc)) return -2;//参数的关联数组中没有主键字段？
    $id = $arr_assoc[ $pk ];
    foreach ($arr_assoc as $key => $value) {
        if ($key == $pk) continue;//参数的关联数组中去掉主键字段
        $filds[] = $key . '=:' . $key;
    }
    $filds = implode(',', $filds);
//    echo "update $tn set $filds where $pk=:$pk";
//    die;
    $stmt = $conn->prepare("update $tn set $filds where $pk=:$pk");
    $stmt->execute($arr_assoc);
    $stmt->closeCursor();

    return $stmt->rowCount();
}

//修改一条记录 自增 返回影响的行数0或1
function updateInc($tn, $w = '1=1', $f, $n = 1) {
    global $conn;
//    echo "update $tn set $f=$f+$n where $w";
//    die;
    $stmt = $conn->prepare("update $tn set $f=$f+$n where $w");
    $stmt->execute();
    $stmt->closeCursor();

    return $stmt->rowCount();
}

//查 返回一个二维数组
//$w条件 $f字段 $o排序呢 $l分页
function query($tn, $w = '1=1', $f = '*', $o = '', $l = '', $j = '') {
    global $conn;
    $stmt = $conn->prepare("select $f from $tn $j where $w $o $l");
//    echo "select $f from $tn $j where $w $o $l";
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $rows;
}

//查 返回一个二维数组
//根据条件主键ID 条件不能写字段  默认查所有字段
function queryByPID($tn, $id, $f = '*') {
    global $conn;
    $pk = getpk($tn);
    $stmt = $conn->prepare("select $f from $tn where $pk=?");
    $stmt->execute(array($id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return array_shift($rows);
}

//分页
function page($tn, $ps = 10, $f = '*', $w = '1=1', $o = '', $j = '', $tp = '') {
    global $conn;
    $stmt = $conn->prepare("select count(*) from $tn $j where  $w");
//    echo "select count(*) from $tn $j where $w";
//    die;
    $stmt->execute();
    $stmt->bindColumn(1, $recordcount);
    $stmt->fetch(PDO::FETCH_BOUND);
    $stmt->closeCursor();
    $pagecount = ceil($recordcount / $ps);
    $p = isset($_GET['p']) ? $_GET['p'] : 1;
    if ($p < 1) $p = 1;
    if ($p > $pagecount) $p = $pagecount;
    $dd['recordcount'] = $recordcount;
    $dd['pagecount'] = $pagecount;
    $dd['p'] = $p;
    //求这一页的数据
    $stmt = $conn->prepare("select $f from $tn $j where $w $o limit ?,?");
    $start = $p * $ps - $ps;
    $stmt->bindParam(1, $start, PDO::PARAM_INT);
    $stmt->bindParam(2, $ps, PDO::PARAM_INT);
    $stmt->execute();
    $dd['rows'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    //实现百度分页效果
    $info = '<div class="my_page">';
    $ss = 1;
    $ee = 10;
    if ($p > 6) {
        $ss = $p - 5;
        $ee = $p + 4;
    }
    $info .= sprintf('<a href="?p=%d%s">首页</a>', 1, $tp);
    $info .= sprintf('<a href="?p=%d%s">上一页</a>', $p - 1, $tp);
    for ($i = $ss; $i <= $ee; $i++) {
        if ($i > $pagecount) break;
        if ($i == $p) {
            $info .= sprintf('<span>%d</span>', $i);
            continue;
        }
        $info .= sprintf('<a href="?p=%d%s">%d</a>', $i, $tp, $i);
    }
    $info .= sprintf('<a href="?p=%d%s">下一页</a>', $p + 1, $tp);
    $info .= sprintf('<a href="?p=%d%s">尾页</a>', $pagecount, $tp);
    $info .= '</div>';
    $dd['info'] = $info;

    return $dd;
}
//function page($tn, $ps = 10, $f = '*', $w = '1=1', $o = '', $j = '', $tp = '') {
//    global $conn;
//    $stmt = $conn->prepare("select count(*) from $tn where $w");
//    $stmt->execute();
//    $stmt->bindColumn(1, $recordcount);
//    $stmt->fetch(PDO::FETCH_BOUND);
//    $stmt->closeCursor();
//    $pagecount = ceil($recordcount / $ps);
//    $p = isset($_GET['p']) ? $_GET['p'] : 1;
//    if ($p < 1) $p = 1;
//    if ($p > $pagecount) $p = $pagecount;
//    $dd['recordcount'] = $recordcount;
//    $dd['pagecount'] = $pagecount;
//    $dd['p'] = $p;
//    //求这一页的数据
//    $stmt = $conn->prepare("select $f from $tn $j where $w $o limit ?,?");
//    $start = $p * $ps - $ps;
//    $stmt->bindParam(1, $start, PDO::PARAM_INT);
//    $stmt->bindParam(2, $ps, PDO::PARAM_INT);
//    $stmt->execute();
//    $dd['rows'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    $stmt->closeCursor();
//    //实现百度分页效果
//    $info = '<div class="my_page">';
//    $ss = 1;
//    $ee = 10;
//    if ($p > 6) {
//        $ss = $p - 5;
//        $ee = $p + 4;
//    }
//    if ($ss > 1) $info .= sprintf('<a href="?p=%d&tp=%s">首页</a>', 1, $tp);
//    if ($p > 1) $info .= sprintf('<a href="?p=%d&tp=%s">上一页</a>', $p - 1, $tp);
//    for ($i = $ss; $i <= $ee; $i++) {
//        if ($i > $pagecount) break;
//        if ($i == $p) {
//            $info .= sprintf('<span>%d</span>', $i);
//            continue;
//        }
//        $info .= sprintf('<a href="?p=%d&tp=%s">%d</a>', $i, $tp, $i);
//    }
//    if ($p != $pagecount) $info .= sprintf('<a href="?p=%d&tp=%s">下一页</a>', $p + 1, $tp);
//    if ($p < $pagecount) $info .= sprintf('<a href="?p=%d&tp=%s">尾页</a>', $pagecount, $tp);
//    $info .= '</div>';
//    $dd['info'] = $info;
//    return $dd;
//}














