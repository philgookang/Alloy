<?php

function hash_array($param_list = array()) {
    $list = clean_array($param_list);
    $serialize = serialize($list);
    return md5($serialize);
}

function clean_array($param_list = array()) {
    $list = array();
    foreach($param_list as $val) {
        array_push($list, $val);
    }
    return $list;
}
