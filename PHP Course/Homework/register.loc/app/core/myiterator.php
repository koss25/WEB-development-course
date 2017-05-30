<?php

class MyIterator implements IteratorAggregate {
    public $emails = [];

    public function __construct($data) {
        if (is_array($data)) {
            $this->emails = $data;
        }
    }

    public function getIterator() {
        return new ArrayIterator($this->emails);
    }
}