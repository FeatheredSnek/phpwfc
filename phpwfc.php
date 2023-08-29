<?php

error_reporting(E_ALL ^ E_WARNING); 

include __DIR__ . '/src/output/StyleDef.php';
include __DIR__ . '/src/output/HTMLElement.php';
include __DIR__ . '/src/output/GridTile.php';
include __DIR__ . '/src/output/GridRenderer.php';
include __DIR__ . '/src/output/GridRendererSetup.php';

include __DIR__ . '/src/wfc/AbstractTile.php';
include __DIR__ . '/src/wfc/AbstractCell.php';
include __DIR__ . '/src/wfc/AbstractGenerator.php';
include __DIR__ . '/src/wfc/GeneratorException.php';

include __DIR__ . '/src/wfc/grid2d/Tile.php';
include __DIR__ . '/src/wfc/grid2d/Cell.php';
include __DIR__ . '/src/wfc/grid2d/Generator.php';
include __DIR__ . '/src/wfc/grid2d/TilesFactory.php';
include __DIR__ . '/src/wfc/grid2d/TileDefinition.php';

include __DIR__ . '/src/tilesets/TilesetManager.php';

include __DIR__ . '/src/App.php';

$size = 15;
$tileset = 'space';
$debug = false;

if (isset($_GET['size'])) {
    $sizeParam = (int) $_GET['size'];
    if ($sizeParam > 2 && $sizeParam < 16) {
        $size = $sizeParam;
    } else {
        throw new Exception('invalid size');
    }
}

if (isset($_GET['tileset'])) {
    $tileset = (string) $_GET['tileset'];
}

if (isset($_GET['debug'])) {
    $debug = (bool) $_GET['debug'];
}

$app = new App($size, $tileset, $debug);
$app->run();


$html = '';

$errors = $app->getError();
if (isset($errors)) {
    $html .= "<div class='error-fatal'>$errors</div>";
} else {
    $html .= "<div class='result'>{$app->getResult()}</div>";
    if ($app->getCompletionStatus() === false) {
        $html .= "<div class='error-unfinished'>WFC has not been able to finish within the preset attempt limit</div>";
    }
}

echo $html;

exit;
