<?php

Map::path('hello', array('prehook'=> 'MemberLoginCheck'), function() {
    echo 'Hello World';
});

Map::path('hello/pre', array(
    'prehook' => function() {
            echo 'Prehook Hooker';
            return true;
        }
), function() {
    echo 'Hello World';
});

Map::path('hello/post', array(
    'posthook' => function() {
            echo 'Posthook Hooker';
        }
), function() {
    echo 'Hello World';
});
