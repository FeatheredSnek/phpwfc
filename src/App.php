<?php

use Output\GridRenderer;
use Output\GridRendererSetup;
use Output\GridTile;
use WFC\Generator;
use WFC\Tile;

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
        // setup size
        $gridSize = 13;

        // setup tiles
        $allTiles = [
            new Tile('/tiles/demo/blank.png', ['N' => 0, 'E' => 0, 'S' => 0, 'W' => 0]),
            new Tile('/tiles/demo/down.png', ['N' => 0, 'E' => 1, 'S' => 1, 'W' => 1]),
            new Tile('/tiles/demo/left.png', ['N' => 1, 'E' => 0, 'S' => 1, 'W' => 1]),
            new Tile('/tiles/demo/right.png', ['N' => 1, 'E' => 1, 'S' => 1, 'W' => 0]),
            new Tile('/tiles/demo/up.png', ['N' => 1, 'E' => 1, 'S' => 0, 'W' => 1]),
        ];

        $generator = new Generator($this->size, $allTiles, $this->debug);

        $cells2 = $generator
            ->init()
            ->compute()
            ->getCells();

        $setup = new GridRendererSetup($this->size, $gridSize, 30);
        $gridTiles = [];
        foreach ($cells2 as $index => $cell) {
            $cellImagePath = isset($cell->result) ? "url($cell->result)" : null;

            $cellContent = '';

            if ($this->debug) {
                $neighborsText = var_export($cell->options, 1);
                $cellContent = "INDEX: $index, OPTIONS: $neighborsText";
            }

            $gridTiles[] = new GridTile($cell->xPos + 1, $cell->yPos + 1, $cellImagePath, $cellContent);
        }
        $renderer = new GridRenderer($setup, $gridTiles);
        return $renderer->render();
    }


}
