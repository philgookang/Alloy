<?php

class MapPath {

    // request method
    private $request_method = null;

    // path string url
    private $url;

    // path array uri
    private $uri = array();

    // callback function
    private $callback;

    // prehook callback function
    private $prehookCallback = null;

    // posthook callback function
    private $posthookCallback = null;

    /**
     * Set the request method
     *
     * @param request_method request_method
     *
     */
     public function setRequestMethod($request_method) {
        $this->request_method = $request_method; return $this;
     }

     /**
      * Get the request method
      *
      * @return request_method
      *
      */
      public function getRequestMethod() {
        return $this->request_method;
      }

    /**
     * Set the path url
     *
     * @param url path url
     *
     */
    public function setUrl($url) {
        $this->url = $url; return $this;
    }

    /**
     * Retrieve a url string
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set the array path uri
     *
     * @param array path uri
     *
     */
    public function setUri($uri) {
        $this->uri = $uri; return $this;
    }

    /**
     * Retrieve a uri array
     *
     * @return array
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Add a map uri item
     *
     */
    public function addUri($key) {

        // create url map item
        $uri = new MapUrl();
        $uri->setUri($key);

        // check if the key is a number
        if (is_numeric($key)) {
            $uri->setType(MapUriType::INTEGER);
        } else {
            $uri->setType(MapUriType::STRING);
        }

        // push to list
        array_push($this->uri, $uri);
    }

    /**
     * Set the callback function
     *
     * @param callable object
     *
     */
    public function setCallback($callback) {
        $this->callback = $callback; return $this;
    }

    /**
     * Retrieve a callable object
     *
     * @return object
     */
    public function getCallback() {
        return $this->callback;
    }

    /**
     * Set the prehook callback callback function
     *
     * @param callable object
     *
     */
    public function setPrehookCallback($prehookCallback) {

        // check if its a list or single item
        $prehookCallback = (is_array($prehookCallback)) ? $prehookCallback : array($prehookCallback);

        // set prehook callback variable
        $this->prehookCallback = $prehookCallback; return $this;
    }

    /**
     * Retrieve a callable object
     *
     * @return object
     */
    public function getPrehookCallback() {
        return $this->prehookCallback;
    }

    /**
     * Set the posthook callback callback function
     *
     * @param callable object
     *
     */
    public function setPosthookCallback($posthookCallback) {

        // check if its a list or a single item
        $posthookCallback = (is_array($posthookCallback)) ? $posthookCallback : array($posthookCallback);

        // set post hook callback varible
        $this->posthookCallback = $posthookCallback; return $this;
    }

    /**
     * Retrieve a callable object
     *
     * @return object
     */
    public function getPosthookCallback() {
        return $this->posthookCallback;
    }

    public function before($hooks) {
        $this->setPrehookCallback($hooks);
        return $this;
    }

    public function after($hooks) {
        $this->setPosthookCallback($hooks);
        return $this;
    }

    /**
     * When there is a url access to this path,
     * call the callback with parameters
     */
    public function run($args, $callback_loader) {

        // check if prehook has no problem
        $proceed = true;

        // if prehook is selt, call it
        if (is_array($this->prehookCallback)) {

            // loop through list of prehooks
            foreach($this->prehookCallback as $func) {

                // if its a function set, then call it,
                if (is_callable($func)) {

                    // call hook function
                    $proceed = call_user_func_array($func, array());

                // if its a string, check predefined hooks
                } else if (is_string($func)) {

                    // call function by name
                    Hook::call($func);
                }
            }
            // end foreach
        }


        // give callback a call
        if ($proceed) {
            // $this->callback();
            call_user_func_array($this->callback, $args);
            // call_user_func_array();

            // call callback to start view loading
            call_user_func_array($callback_loader, array());
        }

        // check is posthook is set
        if (is_array($this->posthookCallback)) {

            // loop through list of prehooks
            foreach($this->posthookCallback as $func) {

                // if its a function set, then call it,
                if (is_callable($func)) {

                    // call hook function
                    call_user_func_array($func, array());

                // if its a string, check predefined hooks
                } else if (is_string($func)) {

                    // call function by name
                    Hook::call($func);
                }
            }
            // end foreach
        }
    }
}
