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

include __DIR__ . '/src/wfc/grid2d/Tile.php';
include __DIR__ . '/src/wfc/grid2d/Cell.php';
include __DIR__ . '/src/wfc/grid2d/Generator.php';
include __DIR__ . '/src/wfc/grid2d/TilesFactory.php';
include __DIR__ . '/src/wfc/grid2d/TileDefinition.php';

include __DIR__ . '/src/App.php';

$app = new App(15, 'space', false);
echo $app->run();

exit;
