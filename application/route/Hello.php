<?php

Map::path('hello', function() {
    if ($this->config['view']['view_type'] == 'html') {
        $this->load->html('hello.php', array());
    } else if ($this->config['view']['view_type'] == 'react') {
        $this->load->view('Hello', 'hello.js', 'root', array('data' => array('happy' => ':]', 'name' => 'alloy')));
    }
});
