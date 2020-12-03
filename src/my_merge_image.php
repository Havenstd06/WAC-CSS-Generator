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

    $width = 0;
    $height = 0;
    $pos = 0;
    $tmpFile = [];
    $totalWidth = 0;
    $biggestHeight = 0;

    foreach ($images as $image) {
        $infos = getimagesize($image);
        if (isset($infos)) {
            list($width, $height) = $infos;
        }

        $tmpFile[$image] = [
            "width" => $width,
            "height" => $height
        ];
//
//        dump($tmpFile);

        $totalWidth += $width;
        $biggestHeight = max($tmpFile)['height'];
    }

    // create empty image
    $spriteImg = imagecreatetruecolor($totalWidth, $biggestHeight);
    $background = imagecolorallocatealpha($spriteImg, 255, 255, 255, 127);
    imagefill($spriteImg, 0, 0, $background);
    imagealphablending($spriteImg, false);
    imagesavealpha($spriteImg, true);

    foreach ($tmpFile as $image => $size) {
        $tempImg = imagecreatefrompng($image);
        imagecopy($spriteImg, $tempImg, $pos, 0, 0, 0, $size['width'], $size['height']);

        $pos += $size['width'];
        imagedestroy($tempImg);
    }

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