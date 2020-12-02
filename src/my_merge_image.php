<?php

function my_merge_image($scan, $name)
{
    $scan = nestedToSingle($scan); // Merge all array into single
//    dump($scan);

    foreach ($scan as $key => $file) {
        if (is_file($file)) {
            if (exif_imagetype($file) === IMAGETYPE_PNG){

            }
        }
    }
}

function nestedToSingle(array $array)
{
    $singleDimArray = [];

    foreach ($array as $item) {

        if (is_array($item)) {
            $singleDimArray = array_merge($singleDimArray, nestedToSingle($item));

        } else {
            $singleDimArray[] = $item;
        }
    }

    return $singleDimArray;
}