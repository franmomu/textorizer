<?php

include_once 'lib/Textorizer.php';

if(isset($_POST['submit'])) {

    // $filename = "coca_cola_logo.gif";

    $tags = array(
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


    $image = $_FILES['image'];
    $textorizer = new Textorizer($image['tmp_name'], $tags);

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