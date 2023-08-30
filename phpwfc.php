<?php

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

include __DIR__ . '/render.php';

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
$errors = $app->getError();

if (isset($errors)) {
    echo renderError($errors);
} else {
    echo renderResult($app->getResult(), $app->getCompletionStatus());
}

exit;
