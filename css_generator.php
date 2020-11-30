<?php

function my_merge_image($first_img_path, $second_img_path)
{
//    $files = [$first_img_path, $second_img_path];

//    $result = '';
//    foreach ($files as $file)
//    {
//        list($width, $height) = getimagesize($file);
//        $toString = imagecreatefrompng($file);
//        imagecopymerge($file, $toString, 104, 160, 0, 0, $width, $height, 100);
//    }
//
//    imagepng($result, "images.png");

    list($width, $height) = getimagesize($second_img_path);

    $first_img_path = imagecreatefromstring(file_get_contents($first_img_path));
    $second_img_path = imagecreatefromstring(file_get_contents($second_img_path));

    imagecopymerge($first_img_path, $second_img_path, 0,0, 0, 0, $width, $height, 100);
    header('Content-Type: image/png');

    imagepng($first_img_path, "image.png");

}

my_merge_image('images/1.png', 'images/2.png');