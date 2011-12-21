<?php

require_once __DIR__.'/Color.php';
require_once __DIR__.'/Character.php';

class Image {

    protected $width;
    protected $height;
    protected $filename;
    protected $image;

    function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
        $this->image = imagecreatetruecolor($width, $height);
    }

    public static function createImageFromFilename($filename) {
        $info = getimagesize($filename);

        $width = $info[0];
        $height = $info[1];

        $newImage = new Image($width, $height);
        $image = null;
        switch ($info['mime']) {
            case "image/gif":
                $image = imagecreatefromgif($filename);
                break;
            case "image/jpeg":
                $image = imagecreatefromjpeg($filename);
                break;
            case "image/png":
                $image = imagecreatefrompng($filename);
                break;
        }

        $newImage->setImage($image);

        return $newImage;
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

    public function getFilename() {
        return $this->filename;
    }

    public function setFilename($filename) {
        $this->filename = $filename;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setBackgroundColor(Color $color) {
        $imageColor = $this->getColor($color);
        imagefilledrectangle($this->getImage(), 0, 0, $this->getWidth(), $this->getHeight(), $imageColor);
    }
    
    public function renderCharacter(Character $character, $x, $y) {
        $color = $this->getColor($character->getColor());        
        imagettftext($this->getImage(), $character->getFontSize(), $character->getFontRotation(), $x, $y, $color, $character->getFont(), $character->getCharacter());
    }

    public function getColor(Color $color) {
        return imagecolorallocate($this->getImage(), $color->getRed(), $color->getGreen(), $color->getBlue());
    }

    public function getColorAt($x, $y) {
        $colorIndex = imagecolorat($this->getImage(), $x, $y);
        $colorArr = imagecolorsforindex($this->getImage(), $colorIndex);
        return new Color($colorArr['red'], $colorArr['green'], $colorArr['blue'], $colorArr['alpha']);
    }

}

?>