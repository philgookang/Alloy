<?php

require_once('./application/system/helper/Filter.php');
require_once('./application/system/helper/File.php');

require_once('./application/system/hook/Hook.php');
require_once('./application/system/hook/HookEvent.php');

require_once('./application/system/map/Map.php');
require_once('./application/system/map/MapPath.php');
require_once('./application/system/map/MapUrl.php');

require_once('./application/system/Loader.php');
require_once('./application/system/Viewer.php');

require_once('./application/system/vendor/v8js/ReactJS.php');

class Alloy {

    public function GodSpeed() {

        // load all maps
        $this->load_map();

        // load all prehooks
        $this->load_hook();

        // create loader
        $this->load_variable();

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

    private function load_variable() {

        // set new loader
        $this->load = new Loader();
    }

    private function call_map() {

        // call route config
        require_once('./application/config/route.php');

        // url uri
        $uri = ($_SERVER['REQUEST_URI'] == '/') ? $map['default'] : $_SERVER['REQUEST_URI'];

        // get uri list
        $uri_list = array_filter(explode('/', $uri));

        // get hash key
        $key_list = clean_array($uri_list);

        $map = Map::init();
        $map->view($key_list, function() {
            $this->load->drawer();
        });
    }
}
