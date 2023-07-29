<?php

include __DIR__ . '/StyleDef.php';
include __DIR__ . '/HTMLElement.php';
include __DIR__ . '/GridTile.php';
include __DIR__ . '/GridRenderer.php';
include __DIR__ . '/GridRendererSetup.php';

include __DIR__ . '/Tile.php';
include __DIR__ . '/Cell.php';
include __DIR__ . '/Generator.php';

use Output\GridRenderer;
use Output\GridRendererSetup;
use WFC\Generator;
use WFC\GridTile;
use WFC\Tile;

// setup size
$gridSize = 3;

// setup tiles
$allTiles = [
    new Tile('/tiles/demo/blank.png', ['N' => 0, 'E' => 0, 'S' => 0, 'W' => 0]),
    new Tile('/tiles/demo/down.png', ['N' => 0, 'E' => 1, 'S' => 1, 'W' => 1]),
    new Tile('/tiles/demo/left.png', ['N' => 1, 'E' => 0, 'S' => 1, 'W' => 1]),
    new Tile('/tiles/demo/right.png', ['N' => 1, 'E' => 1, 'S' => 1, 'W' => 0]),
    new Tile('/tiles/demo/up.png', ['N' => 1, 'E' => 1, 'S' => 0, 'W' => 1]),
];

$generator = new Generator($gridSize, $allTiles);

$cells2 = $generator
    ->init()
    ->compute()
    ->getCells();

$setup = new GridRendererSetup($gridSize, $gridSize, 150);
$gridTiles = [];
foreach ($cells2 as $index => $cell) {
    $cellImagePath = isset($cell->result) ? "url($cell->result)" : null;

    $neighborsText = var_export($cell->options, 1);
    $cellContent = "INDEX: $index, OPTIONS: $neighborsText";

    $gridTiles[] = new GridTile($cell->xPos + 1, $cell->yPos + 1, $cellImagePath, $cellContent);
}
$renderer = new GridRenderer($setup, $gridTiles);
echo "<hr/>";
echo $renderer->render();

exit;
