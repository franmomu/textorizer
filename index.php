<?php

include_once 'lib/Textorizer.php';
include_once 'lib/Tag.php';

if(isset($_POST['submit'])) {
    

    $textTags = array(
        'Javier',
        'Paco',
        'Ana',
        'Noelia',
        'Yara',
        'José Luís',
        'Miguel Ángel',
        'Eugenio',
        'Fran'
    );

    $tags = array();
    foreach ($textTags as $tag) {
        $tags[] = new Tag($tag);   
    }       

    $image = $_FILES['image'];
    $textorizer = new Textorizer($image['tmp_name'], $tags, "8", "/usr/share/fonts/truetype/msttcorefonts/Verdana_Bold.ttf", true);

    $textorizer->textorize();
} else { ?>
    <html>
        <head><title>Prueba textorizer</title></head>
        <body>
            <form action="#" method="post" enctype="multipart/form-data">
                <input type="file" name="image" />
                <input type="submit" name="submit" value="subir" />
            </form>
        </body>
    </html>
<?php } ?>