<?php

function my_merge_image(array $scan, int $padding, string $overrideSize, string $name)
{
    $scan = mergeIntoSingle($scan); // Merge all array into single one

    dd($scan);
    $images = [];
    foreach ($scan as $file) { // Create array with only images in png
        if (is_file($file) && exif_imagetype($file) === IMAGETYPE_PNG) {
            $images[] = $file;
        }
    }

    // default value
    $pos = 0;
    $tmpFile = [];
    $totalWidth = 0;
    $biggestHeight = 0;

    foreach ($images as $image) {
        // get image size
        if ($overrideSize !== '') {
            list($width, $height) = explode("x", $overrideSize);
        } else {
            list($width, $height) = getimagesize($image);
        }

        // put image and size into array
        $tmpFile[$image] = [
            "width" => $width,
            "height" => $height
        ];

        // get total width (for sprite image)
        $totalWidth += $padding + $width;
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
        $pos += $padding + $size['width'];
        imagedestroy($tempImg);
    }

    // create the sprite image with name passed in parameter
    imagepng($spriteImg, $name);
}