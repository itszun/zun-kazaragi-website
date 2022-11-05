<?php

namespace App\Helpers;

class PageInfo {
    private static $instance;
    public $page_name, $page_description, $page_info, $data;

    private function __construct() {}

    public static function getInstance() {
        self::$instance = self::$instance ?? new static();
        return self::$instance;
    }

    public function setInfo($page_name, $page_description, $page_info = "", $data = []) {
        $this->page_name = $page_name;
        $this->page_description = $page_description;
        $this->page_info = $page_info;
        $this->data = $data;
        return $this;
    }
}
