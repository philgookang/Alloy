<?php

class Hook {

    /**
     * A static instance of Hook
     */
    private static $singleton;

    /**
     * List that holds all predefined hooking event
     */
    private $hook_event_list = array(

    );

    /**
     * Create/Retrieve's a instance of the Hook
     *
     * @return Map instance
     */
    public static function init() {
		// check if the instance has been created before
		if ( Hook::$singleton == null) {
			// create new object
			Hook::$singleton = new Hook();
		}
		return Hook::$singleton;
	}

    public static function add($name, $func) {

        // get global hook instance
        $hook = Hook::init();

        // add hooking event
        // by hashing
        $hook->hook_event_list[$name] = (new HookEvent())->setName($name)->setFunction($func);
    }

    public static function call($name) {

        // get global hook instance
        $hook = Hook::init();

        // check if such hook exsits
        if (isset($hook->hook_event_list[$name])) {

            // find predefined hook
            $event = $hook->hook_event_list[$name];

            // call hook
            call_user_func_array($event->getFunction(), array());
        }
    }
}
