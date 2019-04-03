<?php
namespace langdonglei {
    /**图形处理 (缩略图，水印图标，水印文字，验证码_静态)
     * Class I
     * apache Ver 2.4.25 (Win64)
     * mysql  Ver 14.14 Distrib 8.0.0-dmr,for Win64 (x86_64)
     * php    Ver 7.1.2 VC14 x64 Thread Safe
     *
     * @package langdonglei latest 20170226
     */
    class I
    {
        public const NUM = 0;
        public const LETTER = 1;
        public const NOSCALE = 2;
        public const SCALE4WIDTH = 3;
        public const MIDDLE = 5;
        public function __get($name) {
            return $this->$name;
        }
        public function __set($name, $value) {
            $this->$name = $value;
        }
        /**缩略图
         *
         * @param string $path        原图（带路径）
         * @param string $directory   存放缩略图的目录
         * @param int    $thumbWidth  缩略图宽度
         * @param int    $thumbHeight 缩略图高度
         * @param int    $scale       是否按比例
         *
         * @return string
         */
        public function thumb($path, $directory = 'thumb', $thumbWidth = 400, $thumbHeight = 400, $scale = self::NOSCALE) {
            if (!file_exists($path)) {
                return '检查原图路径';
            }
            //建立原图资源
            $image = imagecreatefromstring(file_get_contents($path));
            //获取原图信息
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);
            $dirName = pathinfo($path, PATHINFO_DIRNAME);
            $fileName = pathinfo($path, PATHINFO_BASENAME);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            //判断尺寸
            if ($scale == self::NOSCALE) {
                //非比例
                if ($originalWidth < $thumbWidth || $originalHeight < $thumbHeight) {
                    return '检查原图尺寸';
                }
            } else {
                //（指定宽度）比例
                if ($originalWidth < $thumbWidth) {
                    return '检查原图尺寸';
                }
                $thumbHeight = $originalHeight * ($thumbWidth / $originalWidth);
            }
            //建立缩略图资源
            $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
            //生成缩缩略图
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $originalWidth, $originalHeight);
            //默认路径为：当前原图目录下的thumb文件夹
            $directory = $dirName . '/' . $directory;
            if (!file_exists($directory)) {
                @mkdir($directory, 0777, true);
            }
            //缩略图与原图同名
            $return = $directory . '/' . $fileName;
            switch ($ext) {
                case 'jpg':
                    imagejpeg($thumb, $return);
                    break;
                case 'png':
                    imagepng($thumb, $return);
                    break;
                case 'gif':
                    imagegif($thumb, $return);
                    break;
            }
            imagedestroy($thumb);
            imagedestroy($image);
            return 'ok';
        }
        /**在原始图片上添加logo水印图片
         *
         * @param string $path     原图路径
         * @param int    $position 水印图片在原图的位置
         */
        public function logoPng($path, $position = self::MIDDLE) {
            //建立资源 获取资源信息
            $original = imagecreatefromstring(file_get_contents($path));
            $originalWidth = imagesx($original);
            $originalHeight = imagesy($original);
            $logo = imagecreatefromstring(file_get_contents(dirname(__FILE__) . '/logo/logo.png'));
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);
            //计算位置
            $x = 1;
            $y = 1;
            switch ($position) {
                case 1:
                    break;
                case 2:
                    break;
                case 3:
                    break;
                case 4:
                    break;
                case self::MIDDLE:
                    $x = ($originalWidth - $logoWidth) / 2;
                    $y = ($originalHeight - $logoHeight) / 2;
                    break;
                case 6:
                    break;
                case 7:
                    break;
                case 8:
                    break;
                case 9:
                    $x = $originalWidth - $logoWidth - 10;
                    $y = $originalHeight - $logoHeight - 10;
                    break;
                default:
                    $x = ($originalWidth - $logoWidth) / 2;
                    $y = ($originalHeight - $logoHeight) / 2;
                    break;
            }
            //二图合一
            imagecopy($original, $logo, $x, $y, 0, 0, $logoWidth, $logoHeight);
            //完成后的图片输出到$path路径（覆盖原图）
            imagejpeg($original, $path);
            //销毁资源
            imagedestroy($original);
            imagedestroy($logo);
        }
        //TODO
        public function logoText() { }
        /**验证码
         *
         * @param string $bgcolor 背景色
         * @param int    $w       默认宽度100px
         * @param int    $h       默认高度50px
         * @param int    $num     默认4位
         * @param int    $type    数字|字母
         */
        public static function captcha($bgcolor = '#EEEEEE', $w = 100, $h = 50, $num = 4, $type = self::NUM) {
            session_start();
            $image = imagecreatetruecolor($w, $h);
            imagefill($image, 0, 0, self::setColor($image, $bgcolor, 0));
            switch ($type) {
                case self::NUM:
                    $str = '0123456789';
                    break;
                case self::LETTER:
                    $str = 'abcdefghijklmnopqrstuvwxyz';
                    break;
                default:
                    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    break;
            }
            $captcha = '';
            $font = dirname(__FILE__) . '\font\font.ttf';
            for ($i = 0; $i < $num; $i++) {
                $start = mt_rand(0, mb_strlen($str, 'utf-8') - 1);
                $t = mb_substr($str, $start, 1, 'utf-8');
                $captcha .= $t;
                $size = mt_rand(20, 30);
                $angle = mt_rand(-15, 20);
                $x = $i * 25 + 5;
                $y = mt_rand(30, 35);
                imagettftext($image, $size, $angle, $x, $y, self::setColor($image, 'rand', 0), $font, $t);
            }
            $_SESSION['captcha'] = $captcha;
            header('Content-Type: image/png');
            imagepng($image);
            imagedestroy($image);
        }
        /**为image资源设置颜色 for $this->cpatcha()
         *
         * @param        $image
         * @param string $color
         * @param string $alpha
         *
         * @return int
         */
        public static function setColor($image, $color = 'rand', $alpha = '0~80') {
            if ($alpha == '0~80') {
                $alpha = mt_rand(0, 80);
            }
            switch ($color) {
                case 'red' :
                    $c = imagecolorallocatealpha($image, 255, 0, 0, $alpha);
                    break;
                case 'green' :
                    $c = imagecolorallocatealpha($image, 0, 255, 0, $alpha);
                    break;
                case 'blue' :
                    $c = imagecolorallocatealpha($image, 0, 0, 255, $alpha);
                    break;
                case 'yellow' :
                    $c = imagecolorallocatealpha($image, 255, 255, 0, $alpha);
                    break;
                case 'rand' :
                    $c = imagecolorallocatealpha($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255), $alpha);
                    break;
                default :
                    $p = '/#?[0-9,a-f]{6}/i';
                    if (preg_match_all($p, $color, $arr)) {
                        $str = $arr[0][0];
                        if (substr($str, 0, 1) == '#') {
                            $str = substr($str, 1, 6);
                        }
                        $arr = str_split($str, 2);
                        $c = imagecolorallocatealpha($image, hexdec($arr[0]), hexdec($arr[1]), hexdec($arr[2]), $alpha);
                    } else {
                        $c = imagecolorallocatealpha($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255), $alpha);
                    }
                    break;
            }
            return $c;
        }
    }
}