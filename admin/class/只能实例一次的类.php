<?php

class abc{
    private function __construct() {
    }
    public static $a;
    public static function instance(){
        self::$a = new abc();
        return self::$a;
    }
}

