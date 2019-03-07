<?php


/* function my_merge_image($first_img_path, $second_img_path)
{
    if(file_exists($first_img_path) && file_exists($second_img_path)) // Vérifie si les images existes
    {
        if(exif_imagetype($first_img_path) == IMAGETYPE_PNG && exif_imagetype($second_img_path) == IMAGETYPE_PNG) // Vérifie le type des images
        {
            $first_img_path = imagecreatefrompng($first_img_path); // Crée les images
            $second_img_path = imagecreatefrompng($second_img_path);

            $widthImg1 = imagesx($first_img_path); // Prends la largeur et la hauteur des deux images
            $heightImg1 = imagesy($second_img_path);
   
            $widthImg2 = imagesx($first_img_path);
            $heightImg2 = imagesy($second_img_path);

            $createImg = imagecreate($widthImg1 + $widthImg2, $heightImg1); // Créer une image vide qui peut stocker deux images

            imagecopy($createImg, $first_img_path, 0, 0, 0, 0, $widthImg1, $heightImg1); // Copie les deux images dans l'image vide
            imagecopy($createImg, $second_img_path, $widthImg2, 0, 0, 0, $widthImg1, $heightImg1);
            return imagepng($createImg, "pictures/image3.png"); // Créer le repertoire pour afficher l'image
        }
        else
        {
            echo "Veuillez renseigner une image de type PNG\n";
        }
    }
    else
    {
        echo "Veuillez renseigner deux images\n";
    }
}

function my_generate_css()
{
    $fichier = fopen("styles.css", "w");
    fwrite($fichier, "gest");
my_generate_css();
}
my_merge_image("pictures/image1.png","pictures/image2.png");

?> */


function redimension_images(&$images)
{
    $heightMax = 0;
    for($i = 0; $i < sizeof($images); $i++)
    {
        if(imagesy($images[$i]) > $heightMax)
        {
            $heightMax = imagesy($images[$i]);
        }
    }
    for($i = 0; $i < sizeof($images); $i++)
    {
        if(imagesy($images[$i]) != $heightMax)
        {
            $distance = $heightMax - imagesx($images[$i]);
            $nouvelleImage = imagecreatetruecolor(imagesx($images[$i]) + $distance, $heightMax);
            imagecopyresampled($nouvelleImage, $images[$i], 0, 0, 0, 0, imagesx($images[$i]) + $distance, $heightMax, imagesx($images[$i]), imagesy($images[$i]));
            imagesavealpha($nouvelleImage, true);
            $images[$i] = $nouvelleImage;
        }
    }
}
//-----------------------------------------------------------------------
function is_redimensionnable($tableau)
{
    $height = 0;
    $numberRep = 0;
    for($i = 0; $i < sizeof($tableau); $i++)
    {
        if(imagesy($tableau[$i]) != $height)
        {
            $height = imagesy($tableau[$i]);
            $numberRep++;
 
            if($numberRep > 1)
            {
                return true;
            }
        }
    }
    return true;
}
//-----------------------------------------------------------------------
function my_create_png($tableau)
{
    for($i = 0; $i < sizeof($tableau); $i++)
    {
        if (exif_imagetype($tableau[$i]) == IMAGETYPE_PNG)
        {
            $images[$i] = imagecreatefrompng ($tableau[$i]);
        }
        else
        {
            return false;
        }
    }
    return $images;
}
//-----------------------------------------------------------------------
function my_create_image_spritesheet($tableau)
{
    $widthSpriteSheet = 0;
    $heightSpriteSheet = 0;
 
    foreach ($tableau as $value)
    {
        $widthSpriteSheet += imagesx($value);
 
        if(imagesy($value) > $heightSpriteSheet)
        {
            $heightSpriteSheet = imagesy($value);
        }
    }
    $spriteSheet = imagecreatetruecolor($widthSpriteSheet, $heightSpriteSheet);
    imagesavealpha($spriteSheet, true);
    $color = imagecolorallocatealpha($spriteSheet, 0, 0, 0, 127);
    imagefill($spriteSheet, 0, 0, $color);
    return $spriteSheet;
}
//-----------------------------------------------------------------------
function my_merge_image()
{
    $args = func_get_args();
    $mesImages = my_create_png($args);
 
    if($mesImages != false)
    {
        if(is_redimensionnable($mesImages))
        {
            redimension_images($mesImages);
        } 
 
        $spriteSheet = my_create_image_spritesheet($mesImages);
        $positionx = 0;
        for ($i = 0; $i < sizeof($mesImages); $i++)
        {
            imagecopy ($spriteSheet , $mesImages[$i] , $positionx, 0, 0, 0 , imagesx($mesImages[$i]) , imagesy($mesImages[$i]));
            $positionx += imagesx($mesImages[$i]);
        }
        imagepng($spriteSheet, "pictures/imagefinal.png");
        //return $spriteSheet;
    }
}

my_merge_image("pictures/image1.png", "pictures/image2.png", "pictures/image4.png", "pictures/image5.png", "pictures/image6.png", "pictures/image7.png");