<?php

use Output\GridRenderer;
use Output\GridRendererSetup;
use Output\GridTile;
use Tilesets\TilesetManager;
use WFC\Grid2D\Generator;

final class App
{
    protected int $size = 10;
    protected string $tileSet = 'demo';
    protected bool $debug = false;

    public function __construct(int $size = 10, string $tileSet = 'demo', bool $debug = false)
    {
        $this->size = $size;
        $this->tileSet = $tileSet;
        $this->debug = $debug;
    }

    public function run() : string
    {
        $tiles = TilesetManager::getTileset($this->tileSet);
        $generator = new Generator($this->size, $tiles, $this->debug);

        $cells = $generator
            ->compute()
            ->getCells();

        $gridTiles = [];
        
        foreach ($cells as $index => $cell) {
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

            $gridTiles[] = new GridTile(
                $cell->xPos + 1, 
                $cell->yPos + 1, 
                $cellImagePath, 
                $cellContent, 
                $tileRotation, 
                $debugSocketInfo
            );
        }

        $rendererSetup = new GridRendererSetup($this->size, $this->size, 30, $this->debug);
        $renderer = new GridRenderer($rendererSetup, $gridTiles);

        return $renderer->render();
    }
}
