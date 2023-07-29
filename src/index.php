<?php

// header('Access-Control-Allow-Methods: GET');
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
use WFC\Cell;
use WFC\GridTile;
use WFC\Tile;




function array_search_func(array $arr, $func)
{
    foreach ($arr as $key => $v)
        if ($func($v))
            return $key;

    return -1;
}



$gridSize = 3;



$grid = [];
$cells = [];


// setup tiles
$allTiles = [
    'blank' => new Tile('/tiles/demo/blank.png', ['N' => 0, 'E' => 0, 'S' => 0, 'W' => 0]),
    'down' => new Tile('/tiles/demo/down.png', ['N' => 0, 'E' => 1, 'S' => 1, 'W' => 1]),
    'left' => new Tile('/tiles/demo/left.png', ['N' => 1, 'E' => 0, 'S' => 1, 'W' => 1]),
    'right' => new Tile('/tiles/demo/right.png', ['N' => 1, 'E' => 1, 'S' => 1, 'W' => 0]),
    'up' => new Tile('/tiles/demo/up.png', ['N' => 1, 'E' => 1, 'S' => 0, 'W' => 1]),
];


// generate cells for the grid
for ($i=0; $i < $gridSize; $i++) { 
    for ($j=0; $j < $gridSize; $j++) { 
        $cells[] = new Cell($i, $j, $allTiles);
    }
}


// find cell neighbors
foreach ($cells as $cellIndex => $cell) {
    $neighboringCoordinates = [
        'N' => [
            'xPos' => $cell->xPos, 
            'yPos' => $cell->yPos - 1,
        ],
        'S' => [
            'xPos' => $cell->xPos, 
            'yPos' => $cell->yPos + 1,
        ],
        'E' => [
            'xPos' => $cell->xPos + 1, 
            'yPos' => $cell->yPos,
        ],
        'W' => [
            'xPos' => $cell->xPos - 1, 
            'yPos' => $cell->yPos,
        ],
    ];
    foreach ($neighboringCoordinates as $direction => $coordinates) {
        $key = array_search_func($cells, function ($c) use ($coordinates) {
            return $c->xPos === $coordinates['xPos'] && $c->yPos === $coordinates['yPos'];
        });
        
        if ($key >= 0) {
            $cell->addNeighbor($direction, $key);
        }
    }
}

$lowestEntropy = count($allTiles);









/// the WFC loop

for ($i=0; $i < 10; $i++) { 

// get the lowest entropy
$lowestEntropy = count($allTiles);
foreach ($cells as $cell) {
    $cellEntropy = $cell->getEntropy();
    if (!$cell->collapsed && $cellEntropy < $lowestEntropy) {
        $lowestEntropy = $cellEntropy;
    }
}

// get ids of cells with lowest entropy (set to options count before the loop)
$lowestEntropyCellsKeys = array_keys(array_filter($cells, function ($cell) use ($lowestEntropy) {
    return $cell->getEntropy() === $lowestEntropy;
}));

// break if there are no cells left
if (empty($lowestEntropyCellsKeys)) {
    echo "no more cells with lowest entropy, wfc done";
    break;
}

// iterate through those lowest entropy cells and try to collapse each one, skip non collapsable ones
shuffle($lowestEntropyCellsKeys);
foreach ($lowestEntropyCellsKeys as $k => $cellKey) {
    try {
        $cells[$cellKey]->collapse();
        break;
    } catch (Exception $e) {
        continue;
    }
}


// recalculate entropy for all non-collapsed cells
foreach ($cells as $cellIndex => $cell) {
    if ($cell->collapsed) {
        // echo "cell $cellIndex collapsed, continue<br/>";
        continue;
    }

    $cellNeighbors = $cell->neighbors;

    foreach ($cellNeighbors as $neighborDirection => $neighborIndex) {
        $neighborCell = $cells[$neighborIndex];
        if ($neighborCell->collapsed) {
            $requiredSocket = $neighborCell->result->getRequiredSocketAtDirection($neighborDirection);
            
            // echo "cell index $cellIndex neighbor index $neighborIndex, ";
            // echo "neighborcell result: $neighborCell->result";
            // echo "there has to be a socket $requiredSocket at $neighborDirection in cell $cellIndex, <br/>";
            
            $filteredOptions = array_filter($cell->options, function ($option) use ($neighborDirection, $requiredSocket) {
                // echo "it has option $option, ";
                $optionSocket = $option->getSocketAtDirection($neighborDirection);
                // echo "and this option has socket $optionSocket at $neighborDirection, ";
                $isOptionValid = $optionSocket === $requiredSocket;
                // $str = $isOptionValid ? "valid" : "invalid";
                // echo "therefore it is $str";
                // echo "<br/>";
                return $isOptionValid;
            });
            $cell->options = $filteredOptions;
            // echo "that leaves following options for cell $cellIndex <br/>";
            // var_dump(array_keys($cell->options));
            // echo "<br/>";
        }
    }
}

}

$setup = new GridRendererSetup($gridSize, $gridSize, 150);
$gridTiles = [];
foreach ($cells as $index => $cell) {
    $cellImagePath = isset($cell->result) ? "url($cell->result)" : null;

    $neighborsText = var_export($cell->options, 1);
    $cellContent = "INDEX: $index, OPTIONS: $neighborsText";

    $gridTiles[] = new GridTile($cell->xPos + 1, $cell->yPos + 1, $cellImagePath, $cellContent);
}
$renderer = new GridRenderer($setup, $gridTiles);
echo "<hr/>";
echo $renderer->render();

// //renderer test
// $setup = new GridRendererSetup();
// $tiles = [];
// for ($i = 0; $i < 5; $i++) {
//     for ($j = 0; $j < 5; $j++) {
//         $tiles[] = new GridTile($i + 1, $j + 1);
//     }
// }
// $renderer = new GridRenderer($setup, $tiles);
// echo $renderer->render();

exit;
