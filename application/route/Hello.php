<?php

Map::path('hello', function() {

    $data['data'] = array(
        array(1, 2, 3),
        array(4, 5, 6),
        array(7, 8, 9)
    );

    $this->load->view('Table', 'table.js', $data);
});

Map::path('hello/view/{string}', function($idx) {
    echo 'hello view';
});

Map::path('hello/view/{string}/{integer}', function($name, $age) {
    echo 'this is longer ' . $name . ' ' . $age;
});
