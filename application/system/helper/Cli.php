<?php

function is_cli() {
    return (php_sapi_name() === 'cli');
}
