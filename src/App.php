<?php

use Output\GridRenderer;
use Output\GridRendererSetup;
use Output\GridTile;
use WFC\Grid2D\Generator;
use WFC\Grid2D\Tile;
use WFC\Grid2D\TileDefinition;
use WFC\Grid2D\TilesFactory;

final class App
{
    protected int $size = 10;
    protected string $tileSet = 'demo';
    
    private bool $debug = false;
    

    public function __construct(int $size = 10, string $tileSet = 'demo', bool $debug = false) {
        $this->size = $size;
        $this->tileSet = $tileSet;
        $this->debug = $debug;
    }


    public function run() : string
    {
        $demoTiles = [
            new Tile('/tiles/demo/blank.png', ['N' => 0, 'E' => 0, 'S' => 0, 'W' => 0]),
            new Tile('/tiles/demo/down.png', ['N' => 0, 'E' => 1, 'S' => 1, 'W' => 1]),
            new Tile('/tiles/demo/left.png', ['N' => 1, 'E' => 0, 'S' => 1, 'W' => 1]),
            new Tile('/tiles/demo/right.png', ['N' => 1, 'E' => 1, 'S' => 1, 'W' => 0]),
            new Tile('/tiles/demo/up.png', ['N' => 1, 'E' => 1, 'S' => 0, 'W' => 1]),
        ];

        $circuitTiles = [
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

        $fullCircuitTileDefinitionsPlain = [
            new TileDefinition('/tiles/circuit/0.png', ['N' => 'blk-blk-blk', 'E' => 'blk-blk-blk', 'S' => 'blk-blk-blk', 'W' => 'blk-blk-blk']),
            new TileDefinition('/tiles/circuit/1.png', ['N' => 'grn-grn-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn']),
            new TileDefinition('/tiles/circuit/2.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('/tiles/circuit/3.png', ['N' => 'grn-grn-grn', 'E' => 'grn-whi-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-whi-grn'], true),
            new TileDefinition('/tiles/circuit/4.png', ['N' => 'blk-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-blk', 'W' => 'blk-blk-blk'], true),
            new TileDefinition('/tiles/circuit/5.png', ['N' => 'blk-grn-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-blk'], true),
            new TileDefinition('/tiles/circuit/6.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/7.png', ['N' => 'grn-whi-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-whi-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/8.png', ['N' => 'grn-whi-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-lim-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('/tiles/circuit/9.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/10.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-lim-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/11.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('/tiles/circuit/12.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
        ];

        $fullCircuitTileDefinitions = [
            new TileDefinition('/tiles/circuit/0.png', ['N' => 'blk-blk-blk', 'E' => 'blk-blk-blk', 'S' => 'blk-blk-blk', 'W' => 'blk-blk-blk']),
            new TileDefinition('/tiles/circuit/1.png', ['N' => 'grn-grn-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn']),
            new TileDefinition('/tiles/circuit/2.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('/tiles/circuit/3.png', ['N' => 'grn-grn-grn', 'E' => 'grn-whi-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-whi-grn'], true),
            new TileDefinition('/tiles/circuit/4.png', ['N' => 'blk-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'blk-grn-grn', 'W' => 'blk-blk-blk'], true),
            new TileDefinition('/tiles/circuit/5.png', ['N' => 'blk-grn-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-grn-grn', 'W' => 'blk-grn-grn'], true),
            new TileDefinition('/tiles/circuit/6.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/7.png', ['N' => 'grn-whi-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-whi-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/8.png', ['N' => 'grn-whi-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-lim-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('/tiles/circuit/9.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/10.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-lim-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('/tiles/circuit/11.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('/tiles/circuit/12.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
        ];


        $customTestTileDefinitions = [
            // new TileDefinition('/tiles/customTest/001.png', ['N' => 'B-B-B', 'E' => 'B-W-W', 'S' => 'W-W-W', 'W' => 'B-W-W']),
            // new TileDefinition('/tiles/customTest/002.png', ['N' => 'B-B-B', 'E' => 'B-B-B', 'S' => 'W-W-B', 'W' => 'B-W-W']),
            // new TileDefinition('/tiles/customTest/003.png', ['N' => 'B-B-B', 'E' => 'B-G-G', 'S' => 'W-G-W', 'W' => 'B-W-W']),
            new TileDefinition('/tiles/customTest/004.png', ['N' => 'W-G-W', 'E' => 'W-W-W', 'S' => 'W-G-W', 'W' => 'W-W-W']),
            new TileDefinition('/tiles/customTest/005.png', ['N' => 'W-G-W', 'E' => 'W-G-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
            new TileDefinition('/tiles/customTest/006.png', ['N' => 'W-G-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
            // new TileDefinition('/tiles/customTest/007.png', ['N' => 'W-G-W', 'E' => 'W-T-W', 'S' => 'W-G-W', 'W' => 'W-T-W']),
            // new TileDefinition('/tiles/customTest/008.png', ['N' => 'W-W-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-T-W']),
            // new TileDefinition('/tiles/customTest/009.png', ['N' => 'W-W-W', 'E' => 'W-T-W', 'S' => 'W-W-W', 'W' => 'W-T-W']),
            // new TileDefinition('/tiles/customTest/010.png', ['N' => 'W-O-W', 'E' => 'W-T-W', 'S' => 'W-O-W', 'W' => 'W-T-W']),
            new TileDefinition('/tiles/customTest/011.png', ['N' => 'P-P-P', 'E' => 'P-W-W', 'S' => 'W-O-W', 'W' => 'P-W-W']),
            new TileDefinition('/tiles/customTest/012.png', ['N' => 'P-W-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'P-W-W']),
            new TileDefinition('/tiles/customTest/013.png', ['N' => 'P-P-P', 'E' => 'P-P-P', 'S' => 'P-P-P', 'W' => 'P-P-P']),
            // new TileDefinition('/tiles/customTest/014.png', ['N' => 'W-O-W', 'E' => 'W-W-B', 'S' => 'B-B-B', 'W' => 'W-W-B']),
            new TileDefinition('/tiles/customTest/015.png', ['N' => 'W-O-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
            new TileDefinition('/tiles/customTest/016.png', ['N' => 'W-O-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-O-W']),
            // new TileDefinition('/tiles/customTest/017.png', ['N' => 'V-V-V', 'E' => 'V-V-V', 'S' => 'V-V-V', 'W' => 'V-V-V']),
            // new TileDefinition('/tiles/customTest/018.png', ['N' => 'V-V-V', 'E' => 'V-W-W', 'S' => 'W-W-W', 'W' => 'V-W-W']),
            // new TileDefinition('/tiles/customTest/019.png', ['N' => 'V-W-W', 'E' => 'W-W-P', 'S' => 'W-W-P', 'W' => 'V-W-W']),
            // new TileDefinition('/tiles/customTest/020.png', ['N' => 'R-R-W', 'E' => 'W-W-W', 'S' => 'R-R-W', 'W' => 'R-R-R']),
            // new TileDefinition('/tiles/customTest/021.png', ['N' => 'R-R-W', 'E' => 'W-G-W', 'S' => 'R-R-W', 'W' => 'R-G-R']),
            // new TileDefinition('/tiles/customTest/022.png', ['N' => 'R-R-R', 'E' => 'R-R-R', 'S' => 'R-R-R', 'W' => 'R-R-R']),
            // new TileDefinition('/tiles/customTest/023.png', ['N' => 'R-R-R', 'E' => 'R-G-R', 'S' => 'R-R-R', 'W' => 'R-G-R']),
            // new TileDefinition('/tiles/customTest/024.png', ['N' => 'R-R-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'R-R-W']),
            new TileDefinition('/tiles/customTest/025.png', ['N' => 'W-W-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
            new TileDefinition('/tiles/customTest/026.png', ['N' => 'W-W-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
        ];

        $circuitTileFactory = new TilesFactory($circuitTileDefinitions, true);
        $rotatedCircuitTiles = $circuitTileFactory->createTiles();

        $fullCircuitTileFactory = new TilesFactory($fullCircuitTileDefinitions, true);
        $fullCircuitTiles = $fullCircuitTileFactory->createTiles();

        $customTestTileFactory = new TilesFactory($customTestTileDefinitions, true);
        $customTestTiles = $customTestTileFactory->createTiles();

        $tileSets = [
            'demo' => $demoTiles, 
            'circuit' => $circuitTiles, 
            'rotatedCircuit' => $rotatedCircuitTiles,
            'fullCircuit' => $fullCircuitTiles,
            'customTest' => $customTestTiles,
        ];
        $allTiles = $tileSets[$this->tileSet];

        $generator = new Generator($this->size, $allTiles, $this->debug);

        $cells2 = $generator
            ->compute(1)
            ->getCells();

        $setup = new GridRendererSetup($this->size, $this->size, 30, $this->debug);
        $gridTiles = [];
        foreach ($cells2 as $index => $cell) {
            $cellImagePath = isset($cell->result) ? "url($cell->result)" : null;

            $cellContent = '';
            $debugSocketInfo = null;

            if ($this->debug) {
                $cellContent = (string) $index;
                $debugSocketInfo = var_export($cell->result->sockets, 1);
            }

            $tileRotation = null;
            if (isset($cell->result)) {
                $tileRotation = $cell->result->rotation;
            }

            $gridTiles[] = new GridTile($cell->xPos + 1, $cell->yPos + 1, $cellImagePath, $cellContent, $tileRotation, $debugSocketInfo);
        }
        $renderer = new GridRenderer($setup, $gridTiles);
        return $renderer->render();
    }


}
