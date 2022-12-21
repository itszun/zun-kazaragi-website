<?php

namespace App\Blog;

class Blog {
    public static $page_title = "Zun Fuyuzora";

    public static function getPageTitle() {
        return self::$page_title;
    }
}
