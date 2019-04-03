<?php
namespace langdonglei {
    /**工具 （加密，弹窗，跳转）
     * Class F
     * apache Ver 2.4.25 (Win64)
     * mysql  Ver 14.14 Distrib 8.0.0-dmr,for Win64 (x86_64)
     * php    Ver 7.1.2 VC14 x64 Thread Safe
     *
     * @package langdonglei latest 20170225
     */
    class T
    {
        public function __get($name) {
            return $this->$name;
        }
        public function __set($name, $value) {
            $this->$name = $value;
        }
        //加密算法
        /**
         * @param string $m 要加密的对象
         * @param string $w 干扰字符串
         *
         * @return string 密文
         */
        public function mm($m, $w = 'abc') {
            $mm = $m . $w;
            $m1 = md5($mm);
            $m2 = sha1($mm);
            $mm = substr($m1, 0, 5) . substr($m2, 0, 5);
            $mm .= substr($m1, 10, 5) . substr($m2, 10, 5);
            $mm .= substr($m1, 20, 5) . substr($m2, 20, 7);
            return $mm;
        }
        /**弹窗
         *
         * @param $msg
         */
        public function alert($msg) {
            echo sprintf('<script>alert("%s");</script>', $msg);
        }
        public function alertArt($msg) {
            echo sprintf('<script>art.dialog.alert("%s");</script>', $msg);
        }
        /**跳转带参
         *
         * @param string $url
         * @param string $carry
         */
        public function go($url = '', $carry = '') {
            echo sprintf("<script>location.href='%s?%s'</script>", $url, $carry);
        }
    }
}