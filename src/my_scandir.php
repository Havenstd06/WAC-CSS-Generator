<?php

function my_scandir($dir, $is_rec = false) {
    if (is_dir($dir)) {
        if ($dir[mb_strlen($dir) - 1] !== DIRECTORY_SEPARATOR) {
            $dir .= DIRECTORY_SEPARATOR;
        }

        $files = [];

        $dirlist = opendir($dir);
        while (($file = readdir($dirlist)) !== false) {
            if (! is_dir($file)) {
                $files[] = $dir . $file;
            }
        }

        if ($is_rec === true) {
            foreach (my_scandir($dir) as $key => $file) {
                if (is_dir($file)) {
                    $files[] = my_scandir($file);
                }
            }
        }
        return $files;
    }

    return false;
}