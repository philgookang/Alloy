<?php

$config = array();

/*
|--------------------------------------------------------------------------
| HTML Minify
|--------------------------------------------------------------------------
|
| If you want a php based html minify.
| This can cause alot of server overhead
| therefore be aware of the CPU requirements for
| alots of load
|
*/
$config['html_minify'] = false;

/*
|--------------------------------------------------------------------------
| View Page Type
|--------------------------------------------------------------------------
|
| OPTIONS
| 1. "html" - Use for php view file
| 2. "react" - Use when views are generated by ReactJS
|
*/
$config['view_type'] = 'react';
