<?php

class Tag {
    protected $text;
    protected $weight;    
    function __construct($text, $weight = 1) {
        $this->text = $text;
        $this->weight = $weight;        
    }
    
    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }
}

?>
