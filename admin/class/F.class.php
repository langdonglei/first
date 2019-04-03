<?php
namespace langdonglei {
    /**文件上传下载 （上传，下载）
     * Class F
     * apache Ver 2.4.25 (Win64)
     * mysql  Ver 14.14 Distrib 8.0.0-dmr,for Win64 (x86_64)
     * php    Ver 7.1.2 VC14 x64 Thread Safe
     *
     * @package langdonglei latst 20170225
     */
    class F
    {
        private $err;
        private $upFileNames = [];
        private $successList = [];
        private $failList = [];
        private $naming;
        private $ext;
        const ORIGINAL = 0;
        const DATE = 0;
        const UUID = 1;
        private $size = 20971520;/* 20MB */
        private $allow = ['jpg', 'gif', 'png', 'rar', 'zip'];
        public function __get($name) {
            return $this->$name;
        }
        public function __set($name, $value) {
            $this->$name = $value;
        }
        /**上传
         *
         * @param string $directory 目录
         * @param int    $naming    命名方式
         *
         * @return array|string 上传成功的文件名数组
         */
        public function upload($directory = './', $naming = self::UUID) {
            $this->naming = $naming;
            //先判断文件大于服务器设置的情况
            $this->err = error_get_last();
            if (!empty($error)) {
                if ($error['type'] == 2) {
                    $this->err = '文件太大了，超出了服务允许范围';
                    return $this->err;
                }
            }
            //判断目录是否存在
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            //筛选合格的文件
            foreach ($_FILES as $value) {
                if (is_array($value['name'])) {
                    //多文件
                    foreach ($value['name'] as $key => $name) {
                        $this->ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        if ($value['size'][$key] <= $this->size && in_array($this->ext, $this->allow)) {
                            $this->successList[] = ['tmp_name' => $value['tmp_name'][$key], 'name' => $name];
                        } else {
                            if ($value['size'][$key] == 0) {
                                $this->failList[] = ['fileName' => $name, 'errorinfo' => '空文件'];
                            } else if ($value['size'][$key] > $this->size) {
                                $this->failList[] = ['filename' => $name, 'errorinfo' => '文件太大了，只允许上传:' . $this->size . '字节'];
                            } else {
                                $this->failList[] = ['filename' => $name, 'errorinfo' => '文件不允许，只允许格式为:' . implode(',', $this->allow)];
                            }
                        }
                    }
                } else {
                    //单文件
                    $this->ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
                    if ($value['size'] <= $this->size && in_array($this->ext, $this->allow)) {
                        //符合条件 文件的大小 文件的类型
                        $this->successList[] = ['tmp_name' => $value['tmp_name'], 'name' => $value['name']];
                    } else {
                        //不符合条件
                        if ($value['size'] == 0) {
                            $this->failList[] = ['name' => $value['name'], 'errorinfo' => '空文件'];
                        } else if ($value['size'] > $this->size) {
                            $this->failList[] = ['name' => $value['name'], 'errorinfo' => '文件太大了，只允许上传:' . $this->size . '字节'];
                        } else {
                            $this->failList[] = ['name' => $value['name'], 'errorinfo' => '文件不允许，只允许格式为:' . implode(',', $this->allow)];
                        }
                    }
                }
            }
            //开始上传
            foreach ($this->successList as $value) {
                //获取新文件名
                $upFileName = $this->rename($value['name']);
                move_uploaded_file($value['tmp_name'], $directory . '/' . $upFileName);
                //已上传文件列表（新名字）
                $this->upFileNames[] = $upFileName;
            }
            //失败文件信息放在 $this->failList
            return $this->upFileNames;
        }
        /**防盗链下载
         *
         * @param string $path    源文件
         * @param string $setName 命名（不带扩展名）
         * @param bool   $member  会员下载
         */
        public function download($path, $setName = '未命名', $member = false) {
            if ($member) {
                @session_start();
                if (isset($_SESSION['member'])) {
                } else {
                    exit("此资源，必须是会员才可以下载");
                }
            }
            if (file_exists($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $path = fopen($path, "rb");
                Header("Content-type:application/octet-stream");
                Header("Accept-Ranges:bytes");
                Header("Content-Disposition:  attachment;  filename= " . $setName . '.' . $ext);
                $contents = '';
                while (!feof($path)) {
                    $contents .= fread($path, 8192);
                }
                echo $contents;
                fclose($path);
            } else {
                exit('未知资源,无法下载!!!');
            }
        }
        /**唯一ID for $this->rename()
         *
         * @return string
         */
        public function uuid() {
            static $uuid = '';
            $uid = uniqid("", true);
            $str = $_SERVER['REQUEST_TIME'];
            $str .= $_SERVER['HTTP_USER_AGENT'];
            $str .= $_SERVER['SERVER_ADDR'];
            $str .= $_SERVER['SERVER_PORT'];
            $str .= $_SERVER['REMOTE_ADDR'];
            $str .= $_SERVER['REMOTE_PORT'];
            $hash = strtoupper(hash('ripemd128', $uid . $uuid . md5($str)));
            $uuid = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4) . '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);
            return strtolower($uuid);
        }
        /**重命名 for $this->upload()
         *
         * @param $name
         *
         * @return string
         */
        public function rename($name) {
            switch ($this->naming) {
                case self::ORIGINAL:
                    $newName = strtolower($name);
                    break;
                case self::DATE:
                    $newName = date('YmdHis') . sprintf('_%06d', mt_rand(0, 999999)) . '.' . $this->ext;
                    break;
                case self::UUID:
                    $newName = $this->uuid() . '.' . $this->ext;
                    break;
                default:
                    $newName = $this->uuid() . '.' . $this->ext;
                    break;
            }
            return $newName;
        }
    }
}