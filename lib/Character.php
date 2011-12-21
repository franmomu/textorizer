<?php

class Character {

    protected $character;
    protected $color;
    protected $font;
    protected $fontSize;
    protected $fontRotation;
    protected $width;
    protected $height;
    protected $minWidth;

    function __construct($character, $color, $font, $fontSize, $minWidth = 3, $fontRotation = 0) {
        $this->character = $character;
        $this->color = $color;
        $this->font = $font;
        $this->fontSize = $fontSize;
        $this->fontRotation = $fontRotation;
        $this->minWidth = $minWidth;

        // Calculate width and height
        $rect = imagettfbbox($this->getFontSize(), $this->getFontRotation(), $this->getFont(), $this->getCharacter());
        $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

        $this->width = max($maxX - $minX, $this->minWidth);
        $this->height = $maxY - $minY;
    }

    public function getCharacter() {
        return $this->character;
    }

    public function setCharacter($character) {
        $this->character = $character;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function getFontSize() {
        return $this->fontSize;
    }

    public function setFontSize($fontSize) {
        $this->fontSize = $fontSize;
    }

    public function getFontRotation() {
        return $this->fontRotation;
    }

    public function setFontRotation($fontRotation) {
        $this->fontRotation = $fontRotation;
    }

    public function getFont() {
        return $this->font;
    }

    public function setFont($font) {
        $this->font = $font;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getMinWidth() {
        return $this->minWidth;
    }

    public function setMinWidth($minWidth) {
        $this->minWidth = $minWidth;
    }

    public function isWhiteSpace() {
        return ($this->getCharacter() === ' ');
    }

    public function isSmall() {
        return $this->width < $this->minWidth;
    }

}

?>
