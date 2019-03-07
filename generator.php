<?php

$dir = end($argv);
$recursif = false;
$nameimage = "sprite";
$namecss  = "style";

if(is_dir($dir) && isset($argv[1]))
{
	foreach($argv as $key => $value)
	{
		if($argv[$key] == "-r" || $argv[$key] == "-recursif")
		{
			$recursif = true;
		}

		elseif($argv[$key] == "-i" || $argv[$key] == "-output-image")
		{
			$nameimage = $argv[$key +1];
		}
		elseif($argv[$key] == "-s" || $argv[$key] == "-output-style")
		{
			$namecss = $argv[$key +1];
		}
	}
} 

$tab = create_png(my_scandir($dir ,  $recursif, $ext = array('png')));
$css = merge_image(background($tab), $tab);
generate_css($tab); 

function my_scandir($folder,$recursif, $ext=array('png')) 
{
    $files = array();
    $dir=opendir($folder);
    while($file = readdir($dir)) 
    {
        if($file == '.' || $file == '..') continue;
        if(is_dir($folder . '/' . $file)) 
        {
            if($recursif == true)
                $files = array_merge($files, my_scandir($folder . '/' . $file, $ext));
        } 
        else 
        {
            foreach($ext as $value) 
            {
                if(strtolower($value) == strtolower(substr($file, -strlen($value))))
                {
                    $files[] = $folder . '/' . $file;
                    break;
                }
            }
        }
    }
    closedir($dir);
    return $files;
}


function create_png($array)
{
	for($i = 0; $i < sizeof($array); $i++)
	{
		if(exif_imagetype($array[$i]) == IMAGETYPE_PNG)
		{
			$pictures[$i] = imagecreatefrompng($array[$i]);
		}
	}
	return $pictures;
}

function background($array)
{
	$height = 0;
	$width = 0;

	foreach($array as $value)
	{
		$width += imagesx($value);
		if(imagesy($value) > $height) 
		{
			$height = imagesy($value);
		}
	}
	$sprite = imagecreatetruecolor($width, $height);
	imagesavealpha($sprite, true);
	$color = imagecolorallocatealpha($sprite, 0, 0, 0, 127);
	imagefill($sprite, 0, 0, $color);
	return $sprite;
}

function generate_css($array)
{
	global $namecss; 

	static $increment = 1;
	$fichier = fopen($namecss . ".css", "w");
    foreach($array as $value)
    {
   		$temp1 = imagesy($value);
   		$temp2 = imagesx($value);
    	$css = fwrite($fichier, ".image" . $increment ." 
{ 
    background-repeat: no-repeat;
    display: block;
   	width:" . $temp2 . "px; 
   	height:" . $temp1 . "px;
   	background-position: " . $temp2 . "px ". $temp1 . "px;
}\n\n");
    	$increment += 1; 
    }
}

function merge_image($background, $pictures)
{
	global $nameimage;
	global $dir;

	$positionx = 0;
	for ($i = 0; $i < sizeof($pictures); $i++)
	{
		imagecopy($background, $pictures[$i], $positionx, 0, 0, 0, imagesx($pictures[$i]), imagesy($pictures[$i]));
		$positionx += imagesx($pictures[$i]);
	}
	imagepng($background, $dir . "/" . $nameimage . ".png");
}