<?php
namespace langdonglei {
    /**PDO数据库操作常用的14个方法
     * Class D
     * apache Ver 2.4.25 (Win64)
     * mysql  Ver 14.14 Distrib 8.0.0-dmr,for Win64 (x86_64)
     * php    Ver 7.1.2 VC14 x64 Thread Safe
     *
     * @package langdonglei 边用边测 latest20170221
     * @field $sql 语句
     * @field $err 错误信息
     * @field $tnpre 表前缀
     * @field $pagesize 分页方法->每页显示的记录数
     * @field $currpage 分页方法->当前页
     * @field $recordcount 分页方法->总记录数
     */
    class D extends \PDO
    {
        private $sql;
        private $err;
        private $tnpre = '';
        private $pagesize = 6;
        private $currpage;
        private $pagecount;
        private $recordcount;
        public function __get($name) {
            return $this->$name;
        }
        public function __set($name, $value) {
            $this->$name = $value;
        }
        /**构造方法
         * D constructor.
         *
         * @param string $user    用户名
         * @param string $pwd     密码
         * @param string $host    主机
         * @param string $dbname  库名
         * @param int    $port    端口
         * @param string $charset 字符集
         */
        public function __construct($dbname = 'hw', $user = 'root', $pwd = '', $host = 'localhost', $port = 3306, $charset = 'utf8') {
            $dsn = sprintf('mysql:host=%s;dbname=%s;port=%d;charset=%s', $host, $dbname, $port, $charset);
            try {
                parent::__construct($dsn, $user, $pwd);
            } catch (\Exception $e) {
                $this->err = iconv('gbk', 'utf-8', $e->getMessage());
            }
        }
        /**增
         *
         * @param string $tn  表名
         * @param array  $arr 要插入的数据集 必须是索引数组
         *
         * @return string 插入成功则返回插入ID 否则返回错误信息
         */
        public function saveArrayReturnPID($tn, $arr) {
            //准备 预处理 参数格式 字符串
            $fields = array();
            $values = array();
            foreach ($arr as $key => $value) {
                $fields[] = $key;
                $values[] = ':' . $key;
            }
            $fields = implode(',', $fields);
            $values = implode(',', $values);
            //end
            $tn = $this->tnpre . $tn;
            $this->sql = "insert into $tn($fields) values($values)";
            $stmt = $this->prepare($this->sql);
            $stmt->execute($arr);
            $this->err = $stmt->errorInfo()[2];
            $stmt->closeCursor();
            return $this->lastInsertId();
        }
        /**删 根据 主键ID
         *
         * @param string $tn  表名
         * @param int    $PID 主键ID
         *
         * @return int|string 影响行数|错误信息
         */
        public function deleteByPID($tn, $PID) {
            $pk = $this->getPK($tn);
            if ($pk == NULL) {
                return '该表无主键';
            } else {
                $tn = $this->tnpre . $tn;
                $this->sql = "delete from $tn where $pk=?";
                $stmt = $this->prepare($this->sql);
                $stmt->execute(array($PID));
                $this->err = $stmt->errorInfo()[2];
                $stmt->closeCursor();
                return $stmt->rowCount();
            }
        }
        //没用到预处理
        /**
         * @param $tn
         * @param $w
         *
         * @return int 影响行数
         */
        public function deleteByWhere($tn, $w) {
            $tn = $this->tnpre . $tn;
            $this->sql = "delete from $tn where $w";
            $stmt = $this->prepare($this->sql);
            $stmt->execute();
            $this->err = $stmt->errorInfo()[2];
            $stmt->closeCursor();
            return $stmt->rowCount();
        }
        /**改
         *
         * @param $tn
         * @param $arr
         *
         * @return int|string
         */
        public function updateInnerPK($tn, $arr) {
            $pk = $this->getpk($tn);
            if ($pk == NULL) {
                return '要插入的表中没有主键';
            } else {
                if (!array_key_exists($pk, $arr)) {
                    return '参数的关联数组中没有主键字段';
                } else {
                    $fields = array();
                    foreach ($arr as $key => $value) {
                        if ($key == $pk) continue;//参数的关联数组中去掉主键字段
                        $fields[] = $key . '=:' . $key;
                    }
                    $fields = implode(',', $fields);
                    $tn = $this->tnpre . $tn;
                    $this->sql = "update $tn set $fields where $pk=:$pk";
                    $stmt = $this->prepare($this->sql);
                    $stmt->execute($arr);
                    $this->err = $stmt->errorInfo()[2];
                    $stmt->closeCursor();
                    return $stmt->rowCount();
                }
            }
        }
        /**改
         *
         * @param $tn
         * @param $arr
         * @param $w
         *
         * @return int
         */
        public function updateByWhere($tn, $arr, $w) {
            $fields = array();
            foreach ($arr as $key => $value) {
                $fields[] = $key . '=:' . $key;
            }
            $fields = implode(',', $fields);
            $tn = $this->tnpre . $tn;
            $this->sql = "update $tn set $fields where $w";
            $stmt = $this->prepare($this->sql);
            $stmt->execute($arr);
            $this->err = $stmt->errorCode()[2];
            $stmt->closeCursor();
            return $stmt->rowCount();
        }
        /**改 自增
         *
         * @param        $tn
         * @param string $w
         * @param        $f
         * @param int    $n
         *
         * @return int|string
         */
        public function updateInc($tn, $f, $w = '1=1', $n = 1) {
            $tn = $this->tnpre . $tn;
            $this->sql = "update $tn set $f=$f+$n where $w";
            $stmt = $this->prepare($this->sql);
            $stmt->execute();
            $this->err = $stmt->errorInfo()[2];
            $stmt->closeCursor();
            return $stmt->rowCount();
        }
        /**查 根据 主键
         *
         * @param        $tn
         * @param        $PID
         * @param string $f
         *
         * @return array|string
         */
        public function queryByPID($tn, $PID, $f = '*') {
            $pk = $this->getpk($tn);
            if ($pk == NULL) {
                return '该表无主键';
            } else {
                $tn = $this->tnpre . $tn;
                $this->sql = "select $f from $tn where $pk=?";
                $stmt = $this->prepare($this->sql);
                $stmt->execute(array($PID));
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $this->err = $stmt->errorInfo()[2];
                $stmt->closeCursor();
                return $rows;
            }
        }
        /**查 根据 条件
         *
         * @param        $tn
         * @param string $w
         * @param string $f
         * @param string $o
         * @param string $l
         * @param string $j
         *
         * @return array
         */
        public function queryByWhere($tn, $w = '1=1', $f = '*', $o = '', $l = '', $j = '') {
            $tn = $this->tnpre . $tn;
            $this->sql = "select $f from $tn $j where $w $o $l";
            $stmt = $this->prepare($this->sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $this->err = $stmt->errorInfo()[2];
            $stmt->closeCursor();
            return $rows;
        }
        /**分页方法
         *
         * @param string $tn 表名
         * @param string $w  条件
         * @param string $f  字段
         * @param string $o  排序
         * @param string $j  连接查询
         *
         * @return array|string 返回当前页的记录集|错误信息
         */
        public function page($tn, $w = '1=1', $f = '*', $o = '', $j = '') {
            //准备总记录数
            if (is_numeric($this->count($tn, $w, $j)) && $this->recordcount != 0) {
                //准备总页数 并 赋值到成员属性
                $this->pagecount = ceil($this->recordcount / $this->pagesize);//ceil有余进位
                //约定当前页 并赋值到成员属性
                $this->currpage = isset($_GET['p']) ? $_GET['p'] : 1;
                if ($this->currpage < 1) {
                    $this->currpage = 1;
                }
                if ($this->currpage > $this->pagecount) {
                    $this->currpage = $this->pagecount;
                }
                //准备表名
                $tn = $this->tnpre . $tn;
                //准备sql语句 并 赋值到成员属性
                $this->sql = "select $f from $tn where $w $o limit ?,?";
                //准备预处理
                $stmt = $this->prepare($this->sql);
                //准备预处理参数
                $startline = $this->currpage * $this->pagesize - $this->pagesize;
                //绑定预处理参数
                $stmt->bindParam(1, $startline, \PDO::PARAM_INT);//第3个参数可选 默认字符串
                $stmt->bindParam(2, $this->pagesize, \PDO::PARAM_INT);
                //执行预处理
                $stmt->execute();
                //获取执行结果
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                //获取错误信息 并 赋值到成员属性
                $err = $stmt->errorInfo();
                $this->err = $err[2];
                //关闭预处理
                $stmt->closeCursor();
                //判断 如果有错误 返回错误 没有错误 返回执行结果
                if (empty($this->err)) {
                    return $rows;
                } else {
                    return $this->err;
                }
            } else {
                $this->err = '未查出记录总数';
                return $this->err;
            }
        }
        /**实现分页效果 前提必须先执行page方法 可携带参数 eg: &cid=3
         *
         * @param string $carry 携带参数
         *
         * @return string 分页效果div class="mypage"
         */
        public function pageDiv($carry = '') {
            //样式 不建议写这里
            //TODO 把样式改漂亮点儿
            $str = '<style>
                        .mypage{}
                        .mypage a,
                        .mypage span{
                            border:1px solid #d7d7d7;
                            margin:5px;
                            display: inline-block;
                            padding:5px;
                            text-decoration: none;
                            border-radius: 5px;
                            min-width: 18px;
                            text-align: center;
                            font:14px/15px \'微软雅黑\';
                            color: #5c5c5c;
                        }
                        .mypage span{
                            background-color: #f5f5f5;
                        }
                        .mypage a:hover{
                            border:1px solid #c9c9c9;
                            background-color: #f9f9f9;
                        }
                    </style>';
            //开始标签
            $str .= '<div class="mypage">';
            //TODO 分页算法有问题
            //约定页码
            $firstNum = 1;
            $lastNum = 11;
            if ($this->currpage > 5) {
                $firstNum = $this->currpage - 5;
                $lastNum = $this->currpage + 5;
                if ($this->currpage > $this->pagecount - 5) {
                    $firstNum = $this->pagecount - 10;
                    $lastNum = $this->pagecount;
                }
            }
            //判断首页和上一页可点击状态
            if ($this->currpage > 1) {
                if ($this->currpage >= 7) {
                    $str .= sprintf('<a href="?p=1%s">首页</a>', $carry);
                    $str .= sprintf('<a href="?p=%d%s">上一页</a>', $this->currpage - 1, $carry);
                } else {
                    $str .= '<span>首页</span>';
                    $str .= sprintf('<a href="?p=%d%s">上一页</a>', $this->currpage - 1, $carry);
                }
            } else {
                $str .= '<span>首页</span>';
                $str .= '<span>上一页</span>';
            }
            //遍历页码
            for ($i = $firstNum; $i <= $lastNum; $i++) {
                if ($i > $this->pagecount) break;
                if ($i == $this->currpage) {
                    $str .= sprintf('<span>%d</span>', $i);
                    continue;
                }
                $str .= sprintf('<a href="?p=%d%s">%d</a>', $i, $carry, $i);
            }
            //判断尾页和下一页可点击状态
            if ($this->currpage < $this->pagecount) {
                $str .= sprintf('<a href="?p=%d%s">下一页</a>', $this->currpage + 1, $carry);
                if ($lastNum == $this->pagecount) {
                    $str .= sprintf('<span >尾页</span>');
                } else {
                    $str .= sprintf('<a href="?p=%d%s">尾页</a>', $this->pagecount, $carry);
                }
            } else {
                $str .= sprintf('<span>下一页</span>');
                $str .= sprintf('<span >尾页</span>');
            }
            //结束标签
            $str .= '</div>';
            return $str;
        }
        /**上下篇
         *
         * @param string $tn        表名
         * @param string $titlefild 标题字段
         * @param int    $getID     当前页文章ID
         * @param string $andw      and类别条件
         * @param string $key       接值键名
         *
         * @return string 上下篇div
         */
        public function pianDiv($tn, $titlefild, $getID, $andw = '', $key = 'id') {
            $tn = $this->tnpre . $tn;
            $pk = $this->getPK($tn);
            //获取上一篇
            $psql = "select * from $tn where $pk < $getID $andw order by $pk desc limit 1";
            $stmt = $this->prepare($psql);
            $stmt->execute();
            $pp = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $perr = $stmt->errorInfo()[2];
            $stmt->closeCursor();
            //获取下一篇
            $nsql = "select * from $tn where $pk > $getID $andw limit 1";
            $stmt = $this->prepare($nsql);
            $stmt->execute();
            $np = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $nerr = $stmt->errorInfo()[2];
            $stmt->closeCursor();
            //调试信息
            $this->sql = 'psql=' . $psql . '&nsql=' . $nsql;
            $this->err = 'perr=' . $perr . '&nerr=' . $nerr;
            //拼装div
            $str = '<div style="text-align: center;">';
            if (empty($pp)) {
                $str .= sprintf('<span>上一篇：没有了</span>');
            } else {
                $str .= sprintf('<a href="?%s=%d">上一篇：%s</a>', $key, $pp[0][$pk], $pp[0][$titlefild]);
            }
            $str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if (empty($np)) {
                $str .= sprintf('<span>下一篇：没有了</span>');
            } else {
                $str .= sprintf('<a href="?%s=%d">下一篇：%s</a>', $key, $np[0][$pk], $np[0][$titlefild]);
            }
            $str .= '</div>';
            return $str;
        }
        /**获取一个表的主键字段
         *
         * @param string $tn 表名
         *
         * @return null|string 有主键返回主键名 没有主键返回null
         */
        public function getPK($tn) {
            $tn = $this->tnpre . $tn;
            $this->sql = "show full columns from $tn";
            $stmt = $this->prepare($this->sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $pk = NULL;
            foreach ($rows as $value) {
                if ($value['Key'] == 'PRI') {
                    $pk = $value['Field'];
                }
            }
            return $pk;
        }
        /**统计多少条记录
         *
         * @param string $tn 表名
         * @param string $w  条件
         * @param string $j  连接查询
         *
         * @return string 记录条数|错误信息
         */
        public function count($tn, $w = '1=1', $j = '') {
            //准备表名
            $tn = $this->tnpre . $tn;
            //准备sql语句 并赋值到成员属性
            $this->sql = "select count(*) from $tn $j where $w";
            //准备预处理
            $stmt = $this->prepare($this->sql);
            //绑定参数
            $stmt->bindColumn('count(*)', $this->recordcount);
            //执行预处理
            $stmt->execute();
            //获取执行结果 并 赋值到成员属性
            $stmt->fetch(\PDO::FETCH_BOUND);
            //获取错误信息 并 赋值到成员属性
            $this->err = $stmt->errorInfo()[2];
            //关闭预处理
            $stmt->closeCursor();
            //判断 如果有错误 返回错误 没有错误 返回执行结果
            if (empty($this->err)) {
                return $this->recordcount;
            } else {
                return $this->err;
            }
        }
        /**判断表中是否存在 符合条件的某字段 类似count()方法
         *
         * @param string $tn 表名
         * @param string $w  条件
         *
         * @return bool|string 布尔值|错误信息
         */
        public function exist($tn, $w) {
            //判断条件是否为空，空条件无意义
            if (empty($w)) {
                $this->err = '无条件参数';
                return $this->err;
            } else {
                //准备表名
                $tn = $this->tnpre . $tn;
                //准备sql语句
                $this->sql = "select count(*) from $tn where $w";
                //准备预处理
                $stmt = $this->prepare($this->sql);
                //绑定参数
                $stmt->bindColumn(1, $c);
                //执行处理
                $stmt->execute();
                //获取结果
                $stmt->fetch(\PDO::FETCH_BOUND);
                //获取错误信息 并 写入成员属性
                $this->err = $stmt->errorInfo()[2];
                //关闭预处理
                $stmt->closeCursor();
                //判断 如果有错误 返回错误 没有错误 返回执行结果
                if (empty($this->err)) {
                    if ($c >= 1) {
                        return true;
                    } elseif ($c == 0) {
                        return false;
                    } else {
                        return $this->err;
                    }
                } else {
                    return $this->err;
                }
            }
        }
    }
}


