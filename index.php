<?php

include_once 'lib/Textorizer.php';

if(isset($_POST['submit'])) {

    // $filename = "coca_cola_logo.gif";

    $tags = array(
        'Javier' => 1,
        'Paco' => 1,
        'Ana' => 1,
        'Noelia' => 1,
        'Yara' => 1,
        'José Luís' => 1,
        'Miguel Ángel' => 1,
        'Eugenio' => 1,
        'Fran' => 1
    );


    $image = $_FILES['image'];
    $textorizer = new Textorizer($image['tmp_name'], $tags, "9", "/usr/share/fonts/truetype/msttcorefonts/Verdana_Bold.ttf");

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