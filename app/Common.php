<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

function api($service, $path){
    $host = env('MODE') == 'multi' ? env($service . '_HOST') : 'localhost';
    try {
        $res = \Config\Services::curlrequest(['http_errors' => false, 'timeout' => 5, 'connect_timeout' => 2])
            ->get('http://' . $host . ':' . env($service . '_PORT') . $path);
    } catch (\Throwable $e) {
        log_message('error', $service . ' unreachable: ' . $e->getMessage());
        return null;
    }
    return $res->getStatusCode() == 200 ? (json_decode($res->getBody(), true)['data'] ?? null) : null;
}
function attach($rows, $key, $service, $path, $as){
    $ids = implode(',', array_unique(array_column($rows, $key)));
    $found = array_column(api($service, $path . '?ids=' . $ids) ?? [], null, $key);
    foreach ($rows as $i => $row) {
        $rows[$i][$as] = $found[$row[$key]] ?? null;
    }
    return $rows;
}