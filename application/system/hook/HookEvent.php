<?php

class HookEvent {

    private $name = '';
    private $func = '';

    public function setName($name) {
        $this->name = $name; return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setFunction($function) {
        $this->func = $function; return $this;
    }

    public function getFunction() {
        return $this->func;
    }
}
