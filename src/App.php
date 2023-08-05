<?php

use Output\GridRenderer;
use Output\GridRendererSetup;
use Output\GridTile;
use WFC\Generator;
use WFC\Tile;
use WFC\TileDefinition;
use WFC\TilesFactory;

final class App
{
    protected int $size = 10;
    protected string $tileSet = 'demo';
    
    private bool $debug = false;
    

    public function __construct(int $size = 10, string $tileSet = 'demo') {
        $this->size = $size;
        $this->tileSet = $tileSet;
    }


    public function run() : string
    {
        // setup tiles
        $demoTiles = [
            new Tile('/tiles/demo/blank.png', ['N' => 0, 'E' => 0, 'S' => 0, 'W' => 0]),
            new Tile('/tiles/demo/down.png', ['N' => 0, 'E' => 1, 'S' => 1, 'W' => 1]),
            new Tile('/tiles/demo/left.png', ['N' => 1, 'E' => 0, 'S' => 1, 'W' => 1]),
            new Tile('/tiles/demo/right.png', ['N' => 1, 'E' => 1, 'S' => 1, 'W' => 0]),
            new Tile('/tiles/demo/up.png', ['N' => 1, 'E' => 1, 'S' => 0, 'W' => 1]),
        ];

        $circuitTiles = [
            // new Tile('/tiles/circuit/0.png', ['N' => 'blk', 'E' => 'blk', 'S' => 'blk', 'W' => 'blk']),
            new Tile('/tiles/circuit/1.png', ['N' => 'grn', 'E' => 'grn', 'S' => 'grn', 'W' => 'grn']),
            new Tile('/tiles/circuit/2.png', ['N' => 'grn', 'E' => 'lim', 'S' => 'grn', 'W' => 'grn']),
            new Tile('/tiles/circuit/3.png', ['N' => 'grn', 'E' => 'whi', 'S' => 'grn', 'W' => 'whi']),
            new Tile('/tiles/circuit/6.png', ['N' => 'grn', 'E' => 'lim', 'S' => 'grn', 'W' => 'lim']),
            new Tile('/tiles/circuit/7.png', ['N' => 'whi', 'E' => 'lim', 'S' => 'whi', 'W' => 'lim']),
            new Tile('/tiles/circuit/8.png', ['N' => 'whi', 'E' => 'grn', 'S' => 'lim', 'W' => 'grn']),
            new Tile('/tiles/circuit/9.png', ['N' => 'lim', 'E' => 'lim', 'S' => 'grn', 'W' => 'lim']),
            new Tile('/tiles/circuit/10.png', ['N' => 'lim', 'E' => 'lim', 'S' => 'lim', 'W' => 'lim']),
            new Tile('/tiles/circuit/11.png', ['N' => 'lim', 'E' => 'lim', 'S' => 'grn', 'W' => 'grn']),
            new Tile('/tiles/circuit/12.png', ['N' => 'grn', 'E' => 'lim', 'S' => 'grn', 'W' => 'lim']),
        ];

        $circuitTileDefinitions = [
            new TileDefinition('/tiles/circuit/1.png', ['N' => 'grn', 'E' => 'grn', 'S' => 'grn', 'W' => 'grn']),
            new TileDefinition('/tiles/circuit/2.png', ['N' => 'grn', 'E' => 'lim', 'S' => 'grn', 'W' => 'grn'], true),
            new TileDefinition('/tiles/circuit/3.png', ['N' => 'grn', 'E' => 'whi', 'S' => 'grn', 'W' => 'whi'], true),
            new TileDefinition('/tiles/circuit/6.png', ['N' => 'grn', 'E' => 'lim', 'S' => 'grn', 'W' => 'lim'], true),
            new TileDefinition('/tiles/circuit/7.png', ['N' => 'whi', 'E' => 'lim', 'S' => 'whi', 'W' => 'lim'], true),
            new TileDefinition('/tiles/circuit/8.png', ['N' => 'whi', 'E' => 'grn', 'S' => 'lim', 'W' => 'grn'], true),
            new TileDefinition('/tiles/circuit/9.png', ['N' => 'lim', 'E' => 'lim', 'S' => 'grn', 'W' => 'lim'], true),
            new TileDefinition('/tiles/circuit/10.png', ['N' => 'lim', 'E' => 'lim', 'S' => 'lim', 'W' => 'lim'], true),
            new TileDefinition('/tiles/circuit/11.png', ['N' => 'lim', 'E' => 'lim', 'S' => 'grn', 'W' => 'grn'], true),
            new TileDefinition('/tiles/circuit/12.png', ['N' => 'grn', 'E' => 'lim', 'S' => 'grn', 'W' => 'lim'], true),
        ];

        $circuitTileFactory = new TilesFactory($circuitTileDefinitions, true);
        $rotatedCircuitTiles = $circuitTileFactory->createTiles();

        $tileSets = ['demo' => $demoTiles, 'circuit' => $circuitTiles, 'rotatedCircuit' => $rotatedCircuitTiles];
        $allTiles = $tileSets[$this->tileSet];

        $generator = new Generator($this->size, $allTiles, $this->debug);

        $cells2 = $generator
            ->compute()
            ->getCells();

        $setup = new GridRendererSetup($this->size, $this->size, 30);
        $gridTiles = [];
        foreach ($cells2 as $index => $cell) {
            $cellImagePath = isset($cell->result) ? "url($cell->result)" : null;

            $cellContent = '';

            if ($this->debug) {
                $neighborsText = var_export($cell->options, 1);
                $cellContent = "INDEX: $index, OPTIONS: $neighborsText";
            }

            $tileRotation = null;
            if (isset($cell->result)) {
                $tileRotation = $cell->result->rotation;
            }

            $gridTiles[] = new GridTile($cell->xPos + 1, $cell->yPos + 1, $cellImagePath, $cellContent, $tileRotation);
        }
        $renderer = new GridRenderer($setup, $gridTiles);
        return $renderer->render();
    }


}
