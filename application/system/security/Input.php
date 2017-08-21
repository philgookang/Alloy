<?php

class Input {

    public function post($key) {
        $list = $_POST;
        if (isset($list[$key])) {
            return $list[$key];
        }
        return null;
    }

    public function get($key) {
        $list = $_GET;
        if (isset($list[$key])) {
            return $list[$key];
        }
        return null;
    }

    public function request($key) {
        $list = $_REQUEST;
        if (isset($list[$key])) {
            return $list[$key];
        }
        return null;
    }
}
