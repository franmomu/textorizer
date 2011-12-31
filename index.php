<?php

include_once 'lib/Textorizer.php';
include_once 'lib/Tag.php';

if(isset($_POST['submit'])) {
    $fontSize = (isset($_POST['font-size']))?intval($_POST['font-size']):8;

    $tags = array();
    
    $tagsWithWeight = explode(',',trim($_POST['tags']));
    foreach($tagsWithWeight as $tagWithWeight) {
        list($tag, $value) = explode(':',$tagWithWeight);
        $tags[] = new Tag($tag, $value);
    }        
    
    $fontCode = (isset($_POST['font']))?intval($_POST['font']):1; 

    $font = "";

    switch ($fontCode) {
        case 1:
            $font = "fonts/Verdana_Bold.ttf";
            break;
        case 2:
            $font = "fonts/Arial_Bold.ttf";
            break;   
        default:
            $font = "fonts/Verdana_Bold.ttf";
            break;
    }

    $shadow = (isset($_POST['shadow']))?intval($_POST['shadow']):1; 
         
    $image = $_FILES['image'];

    $textorizer = new Textorizer($image['tmp_name'], $tags, $fontSize, $font, $shadow);

    $textorizer->textorize();
} else { ?>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
            <title>Textorizer</title>
            <style type="text/css">
                .container {
                    width:260px;
                    margin:0 auto;
                    padding: 15px;
                }
                .field{
                    margin: 7px 0;
                }
            </style>
        </head>
        <body>            
            <div class="container">
                <h2>Textorizer</h2>
                <form class="form" action="#" method="post" enctype="multipart/form-data">
                    <div class="field">                        
                        <input type="file" name="image" />
                    </div>
                    <div class="field">
                        Tamaño fuente
                        <select name="font-size">
                            <?php for($i = 1; $i<20; $i ++): ?>
                                <option value="<?php echo $i ?>" <?php $i==8?print 'selected':'' ?>>
                                    <?php echo $i ?>
                                </option>       
                            <?php endfor ?>                                  
                        </select>
                    </div>
                    <div class="field">
                        Fuente
                        <select name="font">
                            <option value="1">Verdana</option>
                            <option value="2">Arial</option>}                            
                        </select>
                    </div>
                    <div class="field">
                        Sombra
                        <select name="shadow">
                            <option value="1">Sí</option>
                            <option value="0">No</option>}                         
                        </select>
                    </div>
                    <div  class="field">
                        <textarea name="tags" placeholder="Tags" id="" cols="30" rows="10" class="tags">Javier:1,Paco:1,Ana:1,Noelia:1,Yara:1,José Luís:1,Miguel Ángel:1,Eugenio:1,Fran:1
                        </textarea>
                    </div>                                    
                    <div class="field">
                        <input type="submit" name="submit" value="Enviar" />
                    </div>
                </form>
            </div>
            
        </body>
    </html>
<?php } ?>