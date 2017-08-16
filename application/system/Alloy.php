<?php

require_once('./application/system/helper/Filter.php');

require_once('./application/system/hook/Hook.php');
require_once('./application/system/hook/HookEvent.php');

require_once('./application/system/map/Map.php');
require_once('./application/system/map/MapPath.php');

class Alloy {

    public function GodSpeed() {

        // load all maps
        $this->load_map();

        // load all prehooks
        $this->load_hook();

        // call map to load
        $this->call_map();
    }

    private function load_map($filepath = './application/route/') {

        // list through map directory, load all maps into memory
        $file_list = array_diff(scandir($filepath), array('..','.'));

        // go through list of models and include each file
        foreach($file_list as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext == 'php') {
                require_once $filepath . $file;
            } else {
                $this->load_map($filepath.$file.'/');
            }
        }
    }

    private function load_hook($filepath = './application/hook/') {

        // list through map directory, load all maps into memory
        $file_list = array_diff(scandir($filepath), array('..','.'));

        // go through list of models and include each file
        foreach($file_list as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext == 'php') {
                require_once $filepath . $file;
            } else {
                $this->load_map($filepath.$file.'/');
            }
        }
    }

    private function call_map() {

        // get uri list
        $uri_list = array_filter(explode('/', $_SERVER['REQUEST_URI']));

        // get hash key
        $key = hash_array($uri_list);

        $map = Map::init();
        $map->view($key);
    }
}
