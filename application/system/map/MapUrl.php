<?php

class MapUriType {
    const NOT_SET   = 0;
    const INTEGER   = 1;
    const STRING    = 2;
}

class MapUrl {

    private $uri    = '';
    private $type   = 0;

    public function setUri($uri) {
        $this->uri = $uri; return $this;
    }

    public function getUri($check_format = false) {

        if (!$check_format) {
            return $this->uri;
        }

        ///// integer
        $front = substr($this->uri, 0, 8);
        $back = substr($this->uri, (strlen($this->uri) - 1), 1);
        $integer = $front.$back;
        if ($integer == '{integer}') {
            return $integer;
        }

        ///// string
        $front = substr($this->uri, 0, 7);
        $back = substr($this->uri, (strlen($this->uri) - 1), 1);
        $string = $front.$back;
        if ($string == '{string}') {
            return $string;
        }

        // not found
        return $this->uri;
    }

    public function getUriDefaultValue() {
        preg_match("/\=(.*?)\}/", $this->uri, $matches);
        return $matches;
    }

    public function setType($type) {
        $this->type = $type; return $this;
    }

    public function getType() {
        return $this->type;
    }
}
