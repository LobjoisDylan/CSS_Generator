<?php

function my_create_png($array)
{
	for($i = 0; $i < sizeof($array); $i++)
	{
		if (exif_imagetype($array[$i]) == IMAGETYPE_PNG)
		{
			$images[$i] = imagecreatefrompng($array[$i]);
		}
		else
		{ 
			return false;
		}
	}
	return $images;
}

function my_create_image_sprite($array)
{
	$width = 0;
	$height = 0;

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
}

function my_merge_image()
{
	$args = func_get_args();
	$images = my_create_png($args);

		$sprite = my_create_image_sprite($images);
		$positionx = 0;
		for ($i = 0; $i < sizeof($images); $i++)
		{
			imagecopy($sprite, $images[$i], $positionx, 0, 0, 0, imagesx($images[$i]), imagesy($images[$i]));
			$positionx += imagesx($images[$i]);
		}
		imagepng($sprite, "pictures/spirite.png");
		return $sprite;
	
}

my_merge_image("pictures/image1.png", "pictures/image2.png", "pictures/image3.png", "pictures/image4.png", "pictures/image5.png", "pictures/image6.png", "pictures/image7.png", "pictures/image8.png", "pictures/image9.png");


function getDirContents($dir, &$results = array())
{
	//$stdin = fopen('php://stdin', 'r');
	//if($argv[1] == "-r")
	{ 
		foreach($files as $key => $value)
		{
			$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
			if(!is_dir($path))
			{
				$results[] = $path;
			} 
			else if($value != "." && $value != "..") 
			{
				getDirContents($path, $results);
				$results[] = $path;
			}
		}
	}
	return $results;
}

var_dump(getDirContents('./pictures'));