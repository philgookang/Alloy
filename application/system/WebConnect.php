<?php

class WebConnect {

    public function getAccessUrl() {

        // get alloy instance
        $alloy = Alloy::init();

        // url uri
        $uri = ($_SERVER['REQUEST_URI'] == '/') ? $alloy->config['route']['default'] : $_SERVER['REQUEST_URI'];

        // get request method
        $REQUEST_METHOD = (isset($_SERVER["REQUEST_METHOD"])) ? $_SERVER["REQUEST_METHOD"] : 'GET';


        // get uri list
        $uri_list = explode('/', $uri);

        // get hash key
        $key_list = clean_array($uri_list);


        // add request method to key list
        array_unshift($key_list, $REQUEST_METHOD);

        //get key list
        return $key_list;
    }
}
