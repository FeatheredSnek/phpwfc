<?php

include __DIR__ . '/output/StyleDef.php';
include __DIR__ . '/output/HTMLElement.php';
include __DIR__ . '/output/GridTile.php';
include __DIR__ . '/output/GridRenderer.php';
include __DIR__ . '/output/GridRendererSetup.php';

include __DIR__ . '/wfc/Tile.php';
include __DIR__ . '/wfc/Cell.php';
include __DIR__ . '/wfc/Generator.php';

include __DIR__ . '/App.php';

$app = new App(10, 'circuit');
echo $app->run();

exit;
