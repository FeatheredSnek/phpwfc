# PHP-WFC

A simple WFC tiled model generator made with PHP. Check it out at [my website](https://dorianm.com/demos/php-wfc).

## Background and purpose
Having watched [Dan Shiffman's video on WFC](https://thecodingtrain.com/challenges/171-wave-function-collapse/) I really wanted to have a go at the code -- and, even more so, at designing a tileset. At the same time, I strongly believe in using wrong tools for the job, as it really helps with creativity and problem solving. PHP feels like an absolute wrong choice for generative art, so there it is.

## How it's made
The WFC itself is made with plain PHP 8.2 (though it does not use features above 8). Simple HTML/CSS UI added on top. Custom space station tileset made with Krita.

## Concluding remarks
My goal here was to implement WFC with clean OOP, which turned out fine. There are base abstract classes which are currently being extended by Grid2D -- but they can readily be used to make hex or even 3d version. Output renderer is also separated form the generator, so you could theoretically render to xml, three.js compatible JSON etc. At the same time, I spent no time on thinking about the algorithm itself whatsoever, so it's absolutely not optimized and will always kill the PHP runner when asked for a grid bigger than 30x30. If I'd ever come back to the project, I'd like to add a JSON importer to TilesetManager. It would receive a file with tile definitions (image links + slot setups) and would then output a generated map.

Demo tiles courtesy of Coding Train (link above).
Circuit and Floor Map tilesets grabbed from the original WFC repo https://github.com/mxgmn/WaveFunctionCollapse.
All code and the space station tileset licensed MIT.