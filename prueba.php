<?php

$string = "Lorem Ipsum";
$size = 20;
$angle = 0;
$fontfile = '/Library/Fonts/Verdana.ttf';

for ($i = 0; $i <= strlen($string); $i++)
 {
    $dimensions = imagettfbbox($size, $angle, $fontfile, $string[$i]);

	$minX = min(array($dimensions[0],$dimensions[2],$dimensions[4],$dimensions[6]));
	    $maxX = max(array($dimensions[0],$dimensions[2],$dimensions[4],$dimensions[6]));
	    $minY = min(array($dimensions[1],$dimensions[3],$dimensions[5],$dimensions[7]));
	    $maxY = max(array($dimensions[1],$dimensions[3],$dimensions[5],$dimensions[7]));

	echo "<pre>";
	print_r(array(
	     "left"   => abs($minX) - 1,
	     "top"    => abs($minY) - 1,
	     "width"  => $maxX - $minX,
	     "height" => $maxY - $minY,
	     "box"    => $dimensions
	    ));
	echo "</pre>";
    echo "Width of ".$string[$i]." is ".$dimensions[2]."<br>";

 }

 
?>