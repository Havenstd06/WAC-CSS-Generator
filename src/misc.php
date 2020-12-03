<?php

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