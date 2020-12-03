<?php

// EXTERNAL FILE
include_once('src/help.php'); // HELP FUNCTION
include_once('src/my_scandir.php'); // CUSTOM SCANDIR (RECURSIVE OPTION)
include_once('src/my_merge_image.php'); // MERGE IMAGES

// GLOBAL VAR
$folder = end($argv);

// OPTIONS
$shortopts = "h";  // help (bool)
$shortopts .= "r"; // recursive (bool)
$shortopts .= "i:"; // output-image (parameter required)
$shortopts .= "s:"; // output-style (parameter required)
$longopts = [
    "help",
    "recursive",
    "output-image:",
    "output-style:"
];
$options = getopt($shortopts, $longopts);
// dump($options);
// dd($argc);

// If user call help (--help || -h) or if no more than 1 args
if ((isset($options['help']) || isset($options['h'])) || $argc === 1) {
    help();
}

// FOLDER CHECKER
if (! file_exists($folder)) { // if folder does not exist message + help
    echo "Le dossier \"$folder\" n'existe pas !" . PHP_EOL . PHP_EOL;
    help();
    exit(1);
}

// LIST OF FILE
if (isset($options['recursive']) || isset($options['r'])) {
    $scan = my_scandir($folder, true);
} else {
    $scan = my_scandir($folder);
}
//dump($scan);

// OUTPUT IMAGE NAME
if (isset($options['output-image']) || isset($options['i'])) {
    $imageName = $options['output-image'] ?? $options['i'];
} else {
    $imageName = "sprite.png";
}
//dump($imageName);

// OUTPUT CSS NAME
if (isset($options['output-style']) || isset($options['s'])) {
    $styleName = $options['output-style'] ?? $options['s'];
} else {
    $styleName = "style.css";
}
//dump($styleName);

echo "Génération de l'image..." . PHP_EOL;

// MERGE IMAGES
my_merge_image($scan, $imageName);

echo "Image générée sous le nom de \"$imageName\"." . PHP_EOL;