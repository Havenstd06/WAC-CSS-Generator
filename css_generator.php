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
$shortopts .= "p:"; // padding (parameter required)
$shortopts .= "o:"; // override size (parameter required)
$longopts = [
    "help",
    "recursive",
    "output-image:",
    "output-style:",
    "padding:",
    "override-size:"
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
    echo "\"$folder\" does not exist!" . PHP_EOL . PHP_EOL;
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
    $imageName = ($options['output-image'] ?? $options['i']) . '.png';

    if (! is_string($imageName)) {
        echo "The name format is incorrect!" . PHP_EOL . PHP_EOL;
        help();
    }
} else {
    $imageName = "sprite.png";
}
//dump($imageName);

// OUTPUT CSS NAME
if (isset($options['output-style']) || isset($options['s'])) {
    $styleName = ($options['output-style'] ?? $options['s']) . '.css';

    if (! is_string($styleName)) {
        echo "The name format is incorrect!" . PHP_EOL . PHP_EOL;
        help();
    }
} else {
    $styleName = "style.css";
}

// BONUS PADDING
if (isset($options['padding']) || isset($options['p'])) {
    $padding = $options['padding'] ?? $options['p'];

    if (! is_numeric($padding)) {
        echo "The padding format is incorrect!" . PHP_EOL . PHP_EOL;
        help();
    }
} else {
    $padding = 0;
}

// BONUS OVERRIDE SIZE
if (isset($options['override-size']) || isset($options['o'])) {
    $overrideSize = $options['override-size'] ?? $options['o'];

    // Check if size is correct format
    $split = explode("x", $overrideSize);
    if (empty($split[0]) || empty($split[1]) || (is_numeric($split[0]) === false || is_numeric($split[1]) === false)) {
        echo "The override size format is incorrect!" . PHP_EOL . PHP_EOL;
        help();
    }
} else {
    $overrideSize = '';
}

echo "Generation of the image..." . PHP_EOL;

// MERGE IMAGES
my_merge_image($scan, $padding, $overrideSize, $imageName);

echo "Image generated as \"$imageName\"." . PHP_EOL;