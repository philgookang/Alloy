<?php

require_once('./application/system/helper/Cli.php');
require_once('./application/system/helper/Filter.php');
require_once('./application/system/helper/File.php');

require_once('./application/system/hook/Hook.php');
require_once('./application/system/hook/HookEvent.php');

require_once('./application/system/map/Map.php');
require_once('./application/system/map/MapPath.php');
require_once('./application/system/map/MapUrl.php');
require_once('./application/system/map/MapTree.php');
require_once('./application/system/map/MapTreeNode.php');

require_once('./application/system/security/Input.php');

require_once('./application/system/Loader.php');
require_once('./application/system/Viewer.php');
require_once('./application/system/WebConnect.php');

require_once('./application/system/vendor/v8js/autoload.php');
require_once('./application/system/vendor/WebSocket/autoload.php');

class Alloy {

    /**
     * A config array that holds all the config
     */
    public $config = array();

    /**
     * Alloy single instance object
     */
    private static $singleton;

    /**
     *
     */
    private $load;

    /**
     * Create/Retrieve's a instance of the Map
     *
     * @return Map instance
     */
    public static function init() {
		// check if the instance has been created before
		if ( Alloy::$singleton == null) {
			// create new object
			Alloy::$singleton = new Alloy();
		}
		return Alloy::$singleton;
	}

    /**
     * The boot function of Alloy
     */
    public function GodSpeed() {

        // load all configs
        $this->load_config();

        // load all maps
        $this->load_map();

        // load all prehooks
        $this->load_hook();

        // create loader
        $this->load_variable();

        // call map to load
        // this has been changed
        // legacy code before we had socket feature
        // $this->call_map();

        // call web access
        $this->call_web();
    }

    private function load_config($filepath = './application/config/') {

        // list through map directory, load all maps into memory
        $file_list = list_files($filepath);

        // go through list of models and include each file
        foreach($file_list as $file) {
            require_once $filepath . $file['name'];
            $config_name = pathinfo($file['name'], PATHINFO_FILENAME);
            foreach($config as $key=>$val) {
                $this->config[$config_name][$key] = $val;
            }
        }
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

    private function call_web() {



        // check if socket is enabled
        if ($this->config['socket']['enabled']) {

            // for socket,
            // the socket calls the call_map function web there is activity, thats all
            // so we don't need to do it here

        } else {

            $key_list = $this->load->wc->getAccessUrl();
            $this->call_map($key_list);
        }
    }

    private function call_map($key_list) {

        $map = Map::init();
        $map->view($key_list, function() {
            $this->load->drawer();
        });
    }
}
