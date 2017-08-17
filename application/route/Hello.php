<?php

Map::path('hello', function() {

})
->before('MemberLoginCheck')
->after(function() {
    echo '----------------------------------------------';
});

Map::path('hello/pre', function() {
    echo 'Hello World';
});

Map::path('hello/post', function() {
    echo 'Hello World';
});
