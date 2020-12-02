<?php

function help()
{
    echo "Usage: php css_generator [options]... assets_folder
  -r, --recursive              Look for images into the assets_folder passed as arguments and all of its subdirectories.
  -i, --output-image=IMAGE     Name of the generated image. If blank, the default name is \"sprite.png\".
  -s, --output-style=STYLE     Name of the generated stylesheet. If blank, the default name is \"style.css\".
  -h, --help                   This help
\n";

    exit(1);
}