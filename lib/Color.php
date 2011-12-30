<?php

class Color {
    protected $red;
    protected $green;
    protected $blue;
    protected $alpha;
    function __construct($red, $green, $blue, $alpha = 0) {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->alpha = $alpha;
    }
    
    public function getRed() {
        return $this->red;
    }

    public function setRed($red) {
        $this->red = $red;
    }

    public function getGreen() {
        return $this->green;
    }

    public function setGreen($green) {
        $this->green = $green;
    }

    public function getBlue() {
        return $this->blue;
    }

    public function setBlue($blue) {
        $this->blue = $blue;
    }

    public function getAlpha() {
        return $this->alpha;
    }

    public function setAlpha($alpha) {
        $this->alpha = $alpha;
    }

    public function getSum() {
        return $this->getRed()+$this->getGreen()+$this->getBlue();
    }
    
    public function isBlack()
    {
        return ($this->getSum()==0);
    }
    
    public function isWhite()
    {
        return ($this->getSum()==255*3);
    }
    
    public function isTransparent()
    {
        return ($this->getAlpha() > 0 && $this->isBlack());
    }

}

?>
