<?php

use App\Helpers\PageInfo;
use App\Models\Menu;

if (!function_exists('MenuItem')) {
    function MenuItem($title, $icon, $url, $more = []) {
        return compact('title', 'icon', 'url', 'more');
    }
}


if (!function_exists('SideMenu')) {
    function SideMenu() {
        return (new Menu)->sideMenu();
    }
}


if (!function_exists('APIResponse')) {
    /**
     * Common API response
     *
     * @param string $status
     * @param string|array $message
     * @param string|array $detail
     * @param integer $code
     * @return void
     */
    function APIResponse($status, $message, $detail= [], $code = 200) {
        return response()->json(apiRes($status, $message, $detail), $code);
    }
}


if (!function_exists('apiRes')) {
    function apiRes($status, $result, $detail = [])
    {
        if ($status == "success") {
            return array(
                'status' => $status, 'timestamp' => dateTimeNow(), 'detail' => $detail, 'result' => $result
            );
        } else {
            return array(
                'status' => $status, 'timestamp' => dateTimeNow(), 'detail' => $detail, 'error_message' => $result
            );
        }
    }
}

if (!function_exists('dateTimeNow')) {
    function dateTimeNow()
    {
        return now()->format('Y-m-d H:i:s');
    }
}



if (!function_exists('PageInfo')) {
    function PageInfo() {
        return PageInfo::getInstance();
    }
}
