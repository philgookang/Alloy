<?php

function hash_array($param_list = array()) {
    $list = clean_array($param_list);
    $serialize = serialize($list);
    return md5($serialize);
}

function clean_array($param_list = array()) {
    $list = array();
    foreach($param_list as $val) {
        if ($val != "") {
            array_push($list, $val);
        }
    }
    return $list;
}

function addon_array($original_array, $new_value) {
    $list = array();
    for($i = 0; $i < count($original_array); $i++) {
        array_push($list, $original_array[$i]);
    }

    array_push($list, $new_value);
    return $list;
}
