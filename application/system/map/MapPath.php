<?php

class MapPath {

    // path string url
    private $url;

    // callback function
    private $callback;

    // prehook callback function
    private $prehookCallback = null;

    // posthook callback function
    private $posthookCallback = null;

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

    /**
     * When there is a url access to this path,
     * call the callback with parameters
     */
    public function run() {

        // check if prehook has no problem
        $proceed = true;

        // if prehook is sell, call it
        if (is_callable($this->prehookCallback)) {
            $proceed = call_user_func_array($this->prehookCallback, array());
        }

        // give callback a call
        if ($proceed) {
            // $this->callback();
            call_user_func_array($this->callback, array());
            // call_user_func_array();
        }

        // check is posthook is set
        if (is_callable($this->posthookCallback)) {
            call_user_func_array($this->posthookCallback, array());
        }
    }
}
