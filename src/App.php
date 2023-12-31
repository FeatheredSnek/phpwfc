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

    protected bool $completionStatus = false;
    protected string $renderedResult = '';
    protected Exception $error;

    public function __construct(int $size = 10, string $tileSet = 'demo', bool $debug = false)
    {
        $this->size = $size;
        $this->tileSet = $tileSet;
        $this->debug = $debug;
    }

    public function run() : void
    {
        try {
            if ($this->size < 4 || $this->size > 15) {
                throw new Exception("Invalid size: min 3, max 15, $this->size given");
            }

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

            $this->renderedResult = $renderer->render();
            $this->completionStatus = $generator->getCompletionStatus();
        } catch (Exception $e) {
            $this->error = $e;
            return;
        }
    }

    public function getResult() : string
    {
        return $this->renderedResult;
    }

    public function getCompletionStatus() : bool
    {
        return $this->completionStatus;
    }

    public function getError() : ?string
    {
        if (isset($this->error)) {
            return $this->error->getMessage();
        } else {
            return null;
        }
    }
}
