<?php

function list_files($path) {

    // list to return back
    $return_list = array();

    // list through map directory, load all maps into memory
    $file_list = array_diff(scandir($path), array('..','.'));

    // go through list of models and include each file
    foreach($file_list as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        array_push($return_list, array(
            'ext'   => $ext,
            'path'  => $path . $file,
            'name'  => $file
        ));
    }

    return $return_list;
}
