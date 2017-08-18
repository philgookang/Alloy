<?php

class Loader {

    private $viewer;

    public function __construct() {
        $this->viewer = new Viewer();
    }

    public function view($name, $filename = '', $data = array()) {
        $this->viewer->addView($name, $filename, $data);
    }

    public function drawer() {
        $this->viewer->generate();
    }
}
