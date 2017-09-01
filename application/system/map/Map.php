<?php

class Map {

    /**
     * Map single instance object
     */
    private static $singleton;

    /**
     * Maptree that holds the B+ Tree
     */
    public $tree;

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

            // create new map tree
            Map::$singleton->tree = new MapTree();
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

        // check if were using request method
        if (in_array($arg_list[0], array('POST', 'GET', 'PUT', 'DELETE', 'OPTION', 'HEAD'))) {

            // if we are using request method check for path string
            // check if path is a string
            if (!is_string($arg_list[1])) {
                die('url path is not a string!');
            }
        }

        // check if callback is a function
        if (!is_callable($arg_list[($num_args-1)])) {
            die('callback is not a function');
        }

        // variables
        $url = '';
        $request_method = 'GET';

        // check if request method is send
        if (in_array($arg_list[0], array('POST', 'GET', 'PUT', 'DELETE', 'OPTION', 'HEAD'))) {
            $request_method = $arg_list[0];
            $url = $arg_list[1];
        } else {
            $url = $arg_list[0];
        }

        // create new path
        $path = new MapPath();
        $path->setCallback($arg_list[($num_args-1)]);
        $path->setRequestMethod($request_method);
        $path->setUrl($url);

        ////////////////////////

        // get extra array
        $param = array();
        if (in_array($arg_list[0], array('POST', 'GET', 'PUT', 'DELETE', 'OPTION', 'HEAD')) && isset($arg_list[1])) {
            $param = $arg_list[1];
        } else if (isset($arg_list[2])) {
            $param = $arg_list[2];
        }

        // before view is called, prehook action
        if (is_array($param) && isset($param['prehook'])) {
            $path->setPrehookCallback( $param['prehook'] );
        }

        // after view is called, posthook
        if (is_array($param) && isset($param['posthook'])) {
            $path->setPosthookCallback( $param['posthook'] );
        }

        //////////////////////////

        // get path uri list
        $key = array_filter(explode('/', $url));

        // clean array, missing indexes
        $key = clean_array($key);

        // added request method
        $path->addUri($request_method);

        // loop through and save uri
        foreach($key as $uri) {
            $path->addUri($uri);
        }


        // save to path list
        $map->tree->add(0, $path);


        // return new path
        return $path;
	}

    /**
     * Look through path list call map item
     */
    public function view($key, $callback_loader) {

        // map object
        $map = Map::init();

        // check if the path matches
        $result = $map->tree->search(0, $key, $map->tree->tree, $callback_loader);

        // we cannot find view, we've got a problem
        if (!$result) {
            echo 'view not found';
        }
    }
}
