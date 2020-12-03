<?php

function my_merge_image($scan, $name)
{
    $scan = mergeIntoSingle($scan); // Merge all array into single one

    $images = [];
    foreach ($scan as $file) { // Create array with only images in png
        if (is_file($file) && exif_imagetype($file) === IMAGETYPE_PNG) {
            $images[] = $file;
        }
    }

    // default value
    $width = 0;
    $height = 0;
    $pos = 0;
    $tmpFile = [];
    $totalWidth = 0;
    $biggestHeight = 0;

    foreach ($images as $image) {
        $infos = getimagesize($image);
        if (isset($infos)) {
            // get image size
            list($width, $height) = $infos;
        }

        // put image and size into array
        $tmpFile[$image] = [
            "width" => $width,
            "height" => $height
        ];

        // get total width (for sprite image)
        $totalWidth += $width;
        // get biggest height (for sprite image)
        $biggestHeight = max($tmpFile)['height'];
    }

    // create empty image with default background etc
    $spriteImg = imagecreatetruecolor($totalWidth, $biggestHeight);
    $background = imagecolorallocatealpha($spriteImg, 255, 255, 255, 127);
    imagefill($spriteImg, 0, 0, $background);
    imagealphablending($spriteImg, false);
    imagesavealpha($spriteImg, true);

    // for each file into the array with file and sizes
    foreach ($tmpFile as $image => $size) {
        // get image data
        $tempImg = imagecreatefrompng($image);

        // copy the image into the default sprite image
        imagecopy($spriteImg, $tempImg, $pos, 0, 0, 0, $size['width'], $size['height']);

        // spacing images
        $pos += $size['width'];
        imagedestroy($tempImg);
    }

    // create the sprite image with name passed in parameter
    imagepng($spriteImg, $name);
}

function mergeIntoSingle(array $array)
{
    $single = [];

    foreach ($array as $item) {
        if (is_array($item)) {
            $single = array_merge($single, mergeIntoSingle($item));

        } else {
            $single[] = $item;
        }
    }

    return $single;
}