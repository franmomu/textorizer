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
        // Pasa el array de tags a cadena de texto
        // En un futuro podría ser un array con cada posición un objeto de tipo Character
        $string = $this->getTextFromTags();
        // Se crea el objeto Image de la imagen que se quiere textorizar
        $imageToTextorize = Image::createImageFromFilename($this->filename);
        // Se crea la imagen textorizada donde se va a escribir
        $imageTextorized = new Image($imageToTextorize->getWidth(), $imageToTextorize->getHeight());
        // Color blanco para ponerlo de fondo de la imagen textorizada
        $colorWhite = new Color(255, 255, 255, 0);
        $imageTextorized->setBackgroundColor($colorWhite);

        //$color = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
        //$colorShadow = imagecolorallocate($image, 0x66, 0x66, 0x66);

        /* Shadow */
        //imagettftext($image, $fontSize, $fontRotation, 7, 22, $colorShadow, $font, $str);

        /* Top Level */
        //imagettftext($image, $fontSize, $fontRotation, 5, 20, $color, $font, $str);

        // Contador de la letra que se va a escribir
        $ti = 0;
        // Tamaños por defecto de la fuente
        $fontHeight = imagefontheight($this->fontSize);
        $fontWidth = imagefontwidth($this->fontSize) * 0.6;
        // Se recorren las Y sumándole el alto de la fuente en cada iteración
        for ($y = 0; $y < $imageToTextorize->getHeight(); $y+=$fontHeight) {
            // rx será la posición de la x
            $rx = 1;
            // Este parámetro se usará para indicar la altura máxima en un línea
            $fontHeightMax = 0;
            // Se recorren las X
            while ($rx < $imageToTextorize->getWidth()) {
                // Se obtiene la X actual
                $x = floor($rx);
                // Se recupera el color de ese punto en la imagen a textorizar
                $colorImage = $imageToTextorize->getColorAt($x, $y);
                // Si el punto no es blanco se escribe
                if (!$colorImage->isWhite() && !$colorImage->isTransparent()) {         
                    // Se obtiene el caracter a escribir      
                    $c = $string[$ti % strlen($string)];
                    // Se crea un objeto de tipo Character 
                    $character = new Character($c, $colorImage, $this->font, $this->fontSize);
                    // Se obtiene el ancho del caracters
                    $fontWidth = $character->getWidth();
                    // Si el caracter no es un espacio en blanco se imprime
                    // Si es espacio en blanco sólo sumará su ancho
                    if (!$character->isWhiteSpace()) {
                        // Se obtiene la altura máxima
                        $fontHeightMax = ($fontHeightMax < $character->getHeight()) ? $character->getHeight() : $fontHeightMax;
                        // Se escribe el caracter en la imagen a textorizar
                        $imageTextorized->renderCharacter($character, $x, $y);
                    }
                    $ti++;
                } 
                // Se aumenta la X añadiendo el ancho del caracter
                $rx += $fontWidth;
            }
            // Si la linea es blanca $fontHeightMax valdrá 0, si pasa eso $fontHeightMax valdrá
            // el alto por defecto    
            $fontHeight = (!$fontHeightMax)?$fontHeight:$fontHeightMax;
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