<?php

require_once('./application/system/helper/Filter.php');
require_once('./application/system/helper/File.php');

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
        $file_list = list_files($filepath);

        // go through list of models and include each file
        foreach($file_list as $file) {
            if ($file['ext'] == 'php') {
                require_once $filepath . $file['name'];
            } else {
                $this->load_map($filepath.$file['name'].'/');
            }
        }
    }

    private function load_hook($filepath = './application/hook/') {

        // list through map directory, load all maps into memory
        $file_list = list_files($filepath);

        // go through list of models and include each file
        foreach($file_list as $file) {
            if ($file['ext'] == 'php') {
                require_once $filepath . $file['name'];
            } else {
                $this->load_map($filepath.$file['name'].'/');
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
