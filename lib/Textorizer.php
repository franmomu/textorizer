<?php

require_once __DIR__.'/Image.php';
require_once __DIR__.'/Color.php';
require_once __DIR__.'/Character.php';

class Textorizer {
    protected $filename;
    protected $font;
    protected $tags;
    protected $fontSize;

    public function __construct($filename, $tags, $fontSize = "10", $font = "/Library/Fonts/Verdana.ttf") {
        $this->filename = $filename;
        $this->tags = $tags; 
        $this->font = $font;
        $this->fontSize = $fontSize;    
    }

    public function textorize() {

        $string = $this->getTextFromTags();

        $imageToTextorize = Image::createImageFromFilename($this->filename);

        $imageTextorized = new Image($imageToTextorize->getWidth(), $imageToTextorize->getHeight());

        $colorWhite = new Color(255, 255, 255, 0);

        $imageTextorized->setBackgroundColor($colorWhite);

        //$color = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
        //$colorShadow = imagecolorallocate($image, 0x66, 0x66, 0x66);


        /* Shadow */
        //imagettftext($image, $fontSize, $fontRotation, 7, 22, $colorShadow, $font, $str);

        /* Top Level */
        //imagettftext($image, $fontSize, $fontRotation, 5, 20, $color, $font, $str);

        $ti = 0;
        $fontHeight = imagefontheight($this->fontSize);
        $fontWidth = imagefontwidth($this->fontSize) * 0.6;

        for ($y = 0; $y < $imageToTextorize->getHeight(); $y+=$fontHeight) {
            $rx = 1;
            $fontHeightMax = 0;
            while ($rx < $imageToTextorize->getWidth()) {
                $x = floor($rx);

                $colorImage = $imageToTextorize->getColorAt($x, $y);
                if (!$colorImage->isWhite()) {               
                    $c = $string[$ti % strlen($string)];
                    $character = new Character($c, $colorImage, $this->font, $this->fontSize);
                    $fontWidth = $character->getWidth();
                    if (!$character->isWhiteSpace()) {
                        $fontHeightMax = ($fontHeightMax < $character->getHeight()) ? $character->getHeight() : $fontHeightMax;
                        $imageTextorized->renderCharacter($character, $x, $y);
                    }
                    $ti++;
                } 
                $rx += $fontWidth;
            }
            $fontHeightMax = (!$fontHeightMax)?$fontHeight:$fontHeightMax;
            $fontHeight = $fontHeightMax;
        }

        header("Content-Type: image/PNG");
        imagepng($imageTextorized->getImage());
        imagedestroy($imageTextorized->getImage());
    }

    private function getTextFromTags() {
        $string = implode(' ', $this->tags);
        $string.=" ";
        $string = mb_convert_encoding($string, 'HTML-ENTITIES',"UTF-8");
        // Convert HTML entities into ISO-8859-1
        $string = html_entity_decode($string,ENT_NOQUOTES, "ISO-8859-1");

        return $string;
    }


}

?>