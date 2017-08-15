<?php

function hash_array($param_list = array()) {
    $list = array();
    foreach($param_list as $val) {
        array_push($list, $val);
    }
    $serialize = serialize($list);
    return md5($serialize);
}
