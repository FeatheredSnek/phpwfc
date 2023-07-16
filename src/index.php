<?php

// header('Access-Control-Allow-Methods: GET');
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include __DIR__ . '/StyleDef.php';
include __DIR__ . '/HTMLElement.php';
include __DIR__ . '/Tile.php';
include __DIR__ . '/GridRenderer.php';
include __DIR__ . '/GridRendererSetup.php';

use Output\GridRenderer;
use Output\GridRendererSetup;
use WFC\Tile;

$setup = new GridRendererSetup();
$tiles = [];
for ($i=0; $i < 5; $i++) { 
    for ($j=0; $j < 5; $j++) { 
        $tiles[] = new Tile($i+1, $j+1);
    }
}
$renderer = new GridRenderer($setup, $tiles);

echo $renderer->render();

exit;
