<?php

class Loader {

    private $viewer;
    private $ws;
    public $wc;

    public function __construct() {

        $alloy = Alloy::init();

        $this->viewer = new Viewer();

        // check if socket is enabled
        if ($alloy->config['socket']['enabled']) {

            if (!is_cli()) {
                die('CLI Access is prohibited');
            }

            $this->ws = new WebSocket($alloy->config['socket']['host'], $alloy->config['socket']['port']);

            try {
                $this->ws->run();
            }
            catch (Exception $e) {
                $this->ws->stdout($e->getMessage());
            }
            ////////////////////////////////////////////////////
        } else {
            $this->wc = new WebConnect();
        }
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
