<?php

require_once __DIR__.'/Image.php';
require_once __DIR__.'/Color.php';
require_once __DIR__.'/Character.php';

class Textorizer {
    protected $filename;
    protected $font;
    protected $tags;
    protected $fontSize;
    protected $shadow;

    public function __construct($filename, $tags, $fontSize = "10", $font = "/Library/Fonts/Verdana.ttf", $shadow = true) {
        $this->filename = $filename;
        $this->tags = $tags; 
        $this->font = $font;
        $this->fontSize = $fontSize;    
        $this->shadow = $shadow;  
    }

    public function textorize() {
        // Obtiene un array en el que cada posición es un Character       
        $characters = $this->getCharactersFromTags();
        // Se crea el objeto Image de la imagen que se quiere textorizar
        $imageToTextorize = Image::createImageFromFilename($this->filename);
        // Se crea la imagen textorizada donde se va a escribir
        $imageTextorized = new Image($imageToTextorize->getWidth(), $imageToTextorize->getHeight());
        // Color blanco para ponerlo de fondo de la imagen textorizada
        $colorWhite = new Color(255, 255, 255, 0);
        $imageTextorized->setBackgroundColor($colorWhite);
        // Contador del Character que se va a escribir
        $ti = 0;
        // Tamaños por defecto de la fuente
        $fontHeight = imagefontheight($this->fontSize);
        $fontWidth = imagefontwidth($this->fontSize) * 0.6;
        // Se recorren las Y sumándole el alto de la fuente en cada iteración
        for ($y = $fontHeight; $y < $imageToTextorize->getHeight(); $y+=$fontHeight) {
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
                // Si el punto no es blanco ni transparente se pinta
                if (!$colorImage->isWhite() && !$colorImage->isTransparent()) {         
                    // Se obtiene el caracter a escribir      
                    $character = $characters[$ti % count($characters)];
                    // Se obtiene el ancho del caracters
                    $fontWidth = $character->getWidth();
                    // Si el caracter no es un espacio en blanco se imprime                    
                    if (!$character->isWhiteSpace()) {
                        // Se obtiene la altura máxima
                        $fontHeightMax = ($fontHeightMax < $character->getHeight()) ? $character->getHeight() : $fontHeightMax;
                        // Se escribe el caracter en la imagen a textorizar
                        $imageTextorized->renderCharacter($character, $colorImage, $x, $y, $this->shadow);
                    }
                    $ti++;
                } 
                // Se aumenta la X añadiendo el ancho del caracter la imprima o no
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

    private function getCharactersFromTags() {
        $characters = array();
        foreach($this->tags as $tag) {
            $fontWeight = 1+($tag->getWeight()/5);            
            $string = mb_convert_encoding($tag->getText(), 'HTML-ENTITIES',"UTF-8");
                // Convert HTML entities into ISO-8859-1
            $string = html_entity_decode($string,ENT_NOQUOTES, "ISO-8859-1");
            for($i = 0; $i < strlen($string);$i++) {
               
                $characters[] = new Character($string[$i], $this->font, $this->fontSize*$fontWeight);    
            }                     
            $characters[] = new Character(" ", $this->font, $this->fontSize);   
        }
        return $characters;
    }


}

?>