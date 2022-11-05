<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->_setPageInfo();
    }

    public function _setPageInfo() {
        PageInfo()->setInfo(
            "_Module Name_",
            "_Module Description_"
        );
    }
}
