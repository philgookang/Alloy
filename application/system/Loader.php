<?php

class Loader {

    private $viewer;

    public function __construct() {
        $this->viewer = new Viewer();
    }

    public function view($name, $filename = '', $target, $data = array()) {
        $this->viewer->addView($name, $filename, $target, $data);
    }

    public function html($filename = '', $data = array()) {
        $this->viewer->addView('', $filename, '', $data);
    }

    public function drawer() {
        $this->viewer->generate();
    }
}
