<?php

class Map {

    /**
     * Map single instance object
     */
    private static $singleton;

    /**
     * List that holds all the paths
     */
    private $path_list = array(

    );

    /**
     * Create/Retrieve's a instance of the Map
     *
     * @return Map instance
     */
    public static function init() {
		// check if the instance has been created before
		if ( Map::$singleton == null) {
			// create new object
			Map::$singleton = new Map();
		}
		return Map::$singleton;
	}

    /**
     * Add a access path to the route
     */
    public static function path() {

        // map object
        $map = Map::init();

        // check number of params
        $num_args = func_num_args();

        // a list holding all the arguments
        $arg_list = func_get_args();

        // check mimium params count
        // 0 - path
        // 1 - callback
        // there we must get atlest 2
        if ($num_args < 2) {
            die('not enough arguments for path');
        }

        // check if problem format
        // check if path is a string
        if (!is_string($arg_list[0])) {
            die('url path is not a string!');
        }

        // check if callback is a function
        if (!is_callable($arg_list[($num_args-1)])) {
            die('callback is not a function');
        }

        // create new path
        $path = new MapPath();
        $path->setUrl($arg_list[0])
             ->setCallback($arg_list[($num_args-1)]);

        // check if additional params
        if ($num_args == 3) {

            // get extra array
            $param = $arg_list[1];

            // before view is called, prehook action
            if (isset($param['prehook'])) {
                $path->setPrehookCallback( $param['prehook'] );
            }

            // after view is called, posthook
            if (isset($param['posthook'])) {
                $path->setPosthookCallback( $param['posthook'] );
            }
        }

        // create hash key
        $key = hash_array( array_filter(explode('/', $arg_list[0])) );

        // save to path list
        // array_push($path_list, $path);
        $map->path_list[$key] = $path;
	}

    /**
     * Look through path list call map item
     */
    public function view($key) {

        // check if path exist
        if (!isset($this->path_list[$key])) {
            die('view not found');
        }

        // get map item
        $map_path = $this->path_list[$key];

        // start path
        $map_path->run();
    }
}
