<?php

error_reporting(E_ALL ^ E_WARNING); 

include __DIR__ . '/output/StyleDef.php';
include __DIR__ . '/output/HTMLElement.php';
include __DIR__ . '/output/GridTile.php';
include __DIR__ . '/output/GridRenderer.php';
include __DIR__ . '/output/GridRendererSetup.php';

include __DIR__ . '/wfc/AbstractTile.php';
include __DIR__ . '/wfc/AbstractCell.php';
include __DIR__ . '/wfc/AbstractGenerator.php';

include __DIR__ . '/wfc/grid2d/Tile.php';
include __DIR__ . '/wfc/grid2d/Cell.php';
include __DIR__ . '/wfc/grid2d/Generator.php';
include __DIR__ . '/wfc/grid2d/TilesFactory.php';
include __DIR__ . '/wfc/grid2d/TileDefinition.php';

include __DIR__ . '/App.php';

$app = new App(4, 'customTest', true);
echo $app->run();

exit;
