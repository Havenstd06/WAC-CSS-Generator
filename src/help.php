<?php

function help()
{
    echo "Usage: php css_generator [options]... assets_folder
  -r, --recursive              Look for images into the assets_folder passed as arguments and all of its subdirectories.
  -i, --output-image=IMAGE     Name of the generated image (without extension). If blank, the default name is \"sprite.png\".
  -s, --output-style=STYLE     Name of the generated stylesheet (without extension). If blank, the default name is \"style.css\".
  -p, --padding=NUMBER         Add padding between images of NUMBER pixels.
  -o, --override-size=SIZE     Force each images of the sprite to fit a size of WIDTHxHEIGHT pixels.
  -h, --help                   This help
\n";

    exit(1);
}