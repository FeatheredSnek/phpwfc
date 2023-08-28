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
            new Tile('../tiles/demo/blank.png', ['N' => 0, 'E' => 0, 'S' => 0, 'W' => 0]),
            new Tile('../tiles/demo/down.png', ['N' => 0, 'E' => 1, 'S' => 1, 'W' => 1]),
            new Tile('../tiles/demo/left.png', ['N' => 1, 'E' => 0, 'S' => 1, 'W' => 1]),
            new Tile('../tiles/demo/right.png', ['N' => 1, 'E' => 1, 'S' => 1, 'W' => 0]),
            new Tile('../tiles/demo/up.png', ['N' => 1, 'E' => 1, 'S' => 0, 'W' => 1]),
        ];

        $circuitTileDefinitions = [
            new TileDefinition('../tiles/circuit/0.png', ['N' => 'blk-blk-blk', 'E' => 'blk-blk-blk', 'S' => 'blk-blk-blk', 'W' => 'blk-blk-blk']),
            new TileDefinition('../tiles/circuit/1.png', ['N' => 'grn-grn-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn']),
            new TileDefinition('../tiles/circuit/2.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('../tiles/circuit/3.png', ['N' => 'grn-grn-grn', 'E' => 'grn-whi-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-whi-grn'], true),
            new TileDefinition('../tiles/circuit/4.png', ['N' => 'blk-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'blk-grn-grn', 'W' => 'blk-blk-blk'], true),
            new TileDefinition('../tiles/circuit/5.png', ['N' => 'blk-grn-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-grn-grn', 'W' => 'blk-grn-grn'], true),
            new TileDefinition('../tiles/circuit/6.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('../tiles/circuit/7.png', ['N' => 'grn-whi-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-whi-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('../tiles/circuit/8.png', ['N' => 'grn-whi-grn', 'E' => 'grn-grn-grn', 'S' => 'grn-lim-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('../tiles/circuit/9.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('../tiles/circuit/10.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-lim-grn', 'W' => 'grn-lim-grn'], true),
            new TileDefinition('../tiles/circuit/11.png', ['N' => 'grn-lim-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-grn-grn'], true),
            new TileDefinition('../tiles/circuit/12.png', ['N' => 'grn-grn-grn', 'E' => 'grn-lim-grn', 'S' => 'grn-grn-grn', 'W' => 'grn-lim-grn'], true),
        ];

        $floorTileDefinitions = [
            new TileDefinition('../tiles/floor/001.png', ['N' => 'Y-Y-Y', 'E' => 'Y-L-Y', 'S' => 'Y-Y-Y', 'W' => 'Y-L-Y']),
            new TileDefinition('../tiles/floor/002.png', ['N' => 'Y-Y-Y', 'E' => 'Y-L-Y', 'S' => 'Y-L-Y', 'W' => 'Y-L-Y']),
            new TileDefinition('../tiles/floor/003.png', ['N' => 'Y-L-Y', 'E' => 'Y-L-Y', 'S' => 'Y-Y-Y', 'W' => 'Y-Y-Y']),
            new TileDefinition('../tiles/floor/004.png', ['N' => 'Y-Y-Y', 'E' => 'Y-L-Y', 'S' => 'Y-Y-Y', 'W' => 'Y-L-Y']),
            new TileDefinition('../tiles/floor/005.png', ['N' => 'W-W-W', 'E' => 'W-W-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
            new TileDefinition('../tiles/floor/006.png', ['N' => 'Y-Y-Y', 'E' => 'Y-Y-Y', 'S' => 'Y-Y-Y', 'W' => 'Y-Y-Y']),
            new TileDefinition('../tiles/floor/007.png', ['N' => 'Y-Y-Y', 'E' => 'Y-D-W', 'S' => 'W-W-W', 'W' => 'Y-D-W']),
            new TileDefinition('../tiles/floor/008.png', ['N' => 'Y-Y-Y', 'E' => 'Y-D-W', 'S' => 'W-W-W', 'W' => 'Y-B-W']),
            new TileDefinition('../tiles/floor/009.png', ['N' => 'Y-Y-Y', 'E' => 'Y-Y-Y', 'S' => 'W-B-Y', 'W' => 'Y-B-W']),
            new TileDefinition('../tiles/floor/010.png', ['N' => 'W-B-Y', 'E' => 'Y-B-W', 'S' => 'W-W-W', 'W' => 'W-W-W']),
            new TileDefinition('../tiles/floor/011.png', ['N' => 'Y-Y-Y', 'E' => 'Y-Z-S', 'S' => 'S-S-S', 'W' => 'Y-Z-S']),
            new TileDefinition('../tiles/floor/012.png', ['N' => 'Y-Y-Y', 'E' => 'Y-Y-Y', 'S' => 'Y-Y-Y', 'W' => 'Y-Y-Y']),
            new TileDefinition('../tiles/floor/013.png', ['N' => 'Y-Y-Y', 'E' => 'Y-Y-Y', 'S' => 'Y-Y-Y', 'W' => 'Y-Y-Y']),
            new TileDefinition('../tiles/floor/014.png', ['N' => 'Y-Y-Y', 'E' => 'Y-B-W', 'S' => 'W-W-W', 'W' => 'Y-B-W']),
            new TileDefinition('../tiles/floor/015.png', ['N' => 'Y-Y-Y', 'E' => 'Y-B-W', 'S' => 'W-W-W', 'W' => 'Y-B-W']),
            new TileDefinition('../tiles/floor/016.png', ['N' => 'Y-L-Y', 'E' => 'Y-B-W', 'S' => 'W-W-W', 'W' => 'Y-B-W']),
            new TileDefinition('../tiles/floor/017.png', ['N' => 'Y-Y-Y', 'E' => 'Y-B-W', 'S' => 'W-W-W', 'W' => 'Y-B-W']),
        ];

        $spaceTileDefinitions = [
            // floor
            new TileDefinition(
                '../tiles/space/floor-base.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/floor-crack-a.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], true
            ),
            new TileDefinition(
                '../tiles/space/floor-crack-b.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], true
            ),
            new TileDefinition(
                '../tiles/space/floor-terminal.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/floor-tank.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/floor-hatch-square.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/floor-hatch-round.png',
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),

            // outer space
            new TileDefinition(
                '../tiles/space/space-base.png',
                ['N' => 'O-O-O', 'E' => 'O-O-O', 'S' => 'O-O-O', 'W' => 'O-O-O'], true
            ),
            new TileDefinition(
                '../tiles/space/space-stars-a.png',
                ['N' => 'O-O-O', 'E' => 'O-O-O', 'S' => 'O-O-O', 'W' => 'O-O-O'], true
            ),
            new TileDefinition(
                '../tiles/space/space-stars-b.png',
                ['N' => 'O-O-O', 'E' => 'O-O-O', 'S' => 'O-O-O', 'W' => 'O-O-O'], true
            ),
            new TileDefinition(
                '../tiles/space/space-stars-c.png',
                ['N' => 'O-O-O', 'E' => 'O-O-O', 'S' => 'O-O-O', 'W' => 'O-O-O'], false
            ),
            

            // walls
            new TileDefinition(
                '../tiles/space/wall-hor-outside-n.png', 
                ['N' => 'O-O-O', 'E' => 'O-H-G', 'S' => 'G-G-G', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-hor-outside-s.png', 
                ['N' => 'G-G-G', 'E' => 'G-H-O', 'S' => 'O-O-O', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-vert-outside-e.png', 
                ['N' => 'G-V-O', 'E' => 'O-O-O', 'S' => 'G-V-O', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-vert-outside-w.png', 
                ['N' => 'O-V-G', 'E' => 'G-G-G', 'S' => 'O-V-G', 'W' => 'O-O-O'], false
            ),
            // bonus walls
            new TileDefinition(
                '../tiles/space/wall-hor-doodad-s-b.png', 
                ['N' => 'G-G-G', 'E' => 'G-H-O', 'S' => 'O-O-O', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-hor-doodad-s-a.png', 
                ['N' => 'O-O-O', 'E' => 'O-H-G', 'S' => 'G-G-G', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-vert-doodad-e.png', 
                ['N' => 'O-V-G', 'E' => 'G-G-G', 'S' => 'O-V-G', 'W' => 'O-O-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-vert-doodad-w.png', 
                ['N' => 'G-V-O', 'E' => 'O-O-O', 'S' => 'G-V-O', 'W' => 'G-G-G'], false
            ),

            // corners - outer
            new TileDefinition(
                '../tiles/space/wall-outer-corner-nw.png', 
                ['N' => 'O-O-O', 'E' => 'O-H-G', 'S' => 'O-V-G', 'W' => 'O-O-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-outer-corner-ne.png', 
                ['N' => 'O-O-O', 'E' => 'O-O-O', 'S' => 'G-V-O', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-outer-corner-se.png', 
                ['N' => 'G-V-O', 'E' => 'O-O-O', 'S' => 'O-O-O', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-outer-corner-sw.png', 
                ['N' => 'O-V-G', 'E' => 'G-H-O', 'S' => 'O-O-O', 'W' => 'O-O-O'], false
            ),
            // corners - inner
            new TileDefinition(
                '../tiles/space/wall-inner-corner-nw.png', 
                ['N' => 'G-G-G', 'E' => 'G-H-O', 'S' => 'G-V-O', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-inner-corner-ne.png', 
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'O-V-G', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-inner-corner-se.png', 
                ['N' => 'O-V-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-inner-corner-sw.png', 
                ['N' => 'G-V-O', 'E' => 'O-H-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),

            // pipes - straight
            new TileDefinition(
                '../tiles/space/pipe-hor.png', 
                ['N' => 'G-G-G', 'E' => 'G-Ph-G', 'S' => 'G-G-G', 'W' => 'G-Ph-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-hor-alt.png', 
                ['N' => 'G-G-G', 'E' => 'G-Ph-G', 'S' => 'G-G-G', 'W' => 'G-Ph-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-vert.png', 
                ['N' => 'G-Pv-G', 'E' => 'G-G-G', 'S' => 'G-Pv-G', 'W' => 'G-G-G'], false
            ),
            // pipes - corners
            new TileDefinition(
                '../tiles/space/pipe-n-w.png', 
                ['N' => 'G-Pv-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-Ph-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-n-e.png', 
                ['N' => 'G-Pv-G', 'E' => 'G-Ph-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-s-e.png', 
                ['N' => 'G-G-G', 'E' => 'G-Ph-G', 'S' => 'G-Pv-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-s-w.png', 
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-Pv-G', 'W' => 'G-Ph-G'], false
            ),
            // pipes - vents
            new TileDefinition(
                '../tiles/space/vent-pipe-n.png', 
                ['N' => 'G-Pv-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/vent-pipe-s.png', 
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-Pv-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/vent-pipe-e.png', 
                ['N' => 'G-G-G', 'E' => 'G-Ph-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/vent-pipe-w.png', 
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-Ph-G'], false
            ),
            // pipes - walls
            new TileDefinition(
                '../tiles/space/wall-pipe-n.png', 
                ['N' => 'G-Pv-G', 'E' => 'G-H-O', 'S' => 'O-O-O', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-pipe-s.png', 
                ['N' => 'O-O-O', 'E' => 'O-H-G', 'S' => 'G-Pv-G', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-pipe-e.png', 
                ['N' => 'O-V-G', 'E' => 'G-Ph-G', 'S' => 'O-V-G', 'W' => 'O-O-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-pipe-w.png', 
                ['N' => 'G-V-O', 'E' => 'O-O-O', 'S' => 'G-V-O', 'W' => 'G-Ph-G'], false
            ),

            // wires
            new TileDefinition(
                '../tiles/space/wires-straight-a.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-G-G', 'S' => 'G-Wir-G', 'W' => 'G-G-G'], true
            ),
            new TileDefinition(
                '../tiles/space/wires-straight-b.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-G-G', 'S' => 'G-Wir-G', 'W' => 'G-G-G'], true
            ),
            new TileDefinition(
                '../tiles/space/wires-turn-a.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-Wir-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], true
            ),
            new TileDefinition(
                '../tiles/space/wires-turn-b.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-Wir-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], true
            ),
            // wires x pipes
            new TileDefinition(
                '../tiles/space/pipe-hor-alt-wires.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-Ph-G', 'S' => 'G-Wir-G', 'W' => 'G-Ph-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-hor-wires.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-Ph-G', 'S' => 'G-Wir-G', 'W' => 'G-Ph-G'], false
            ),
            new TileDefinition(
                '../tiles/space/pipe-vert-wires.png', 
                ['N' => 'G-Pv-G', 'E' => 'G-Wir-G', 'S' => 'G-Pv-G', 'W' => 'G-Wir-G'], false
            ),
            // wired servers
            new TileDefinition(
                '../tiles/space/server-wires-e.png', 
                ['N' => 'G-G-G', 'E' => 'G-Wir-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/server-wires-n.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/server-wires-s.png', 
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-Wir-G', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/server-wires-w.png', 
                ['N' => 'G-G-G', 'E' => 'G-G-G', 'S' => 'G-G-G', 'W' => 'G-Wir-G'], false
            ),
            // wires x walls
            new TileDefinition(
                '../tiles/space/wall-hor-wires-n.png', 
                ['N' => 'G-Wir-G', 'E' => 'G-H-O', 'S' => 'O-O-O', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-hor-wires-s.png', 
                ['N' => 'O-O-O', 'E' => 'O-H-G', 'S' => 'G-Wir-G', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-vert-wires-e.png', 
                ['N' => 'O-V-G', 'E' => 'G-Wir-G', 'S' => 'O-V-G', 'W' => 'O-O-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-vert-wires-w.png', 
                ['N' => 'G-V-O', 'E' => 'O-O-O', 'S' => 'G-V-O', 'W' => 'G-Wir-G'], false
            ),


            // fuelpipes - straight
            new TileDefinition(
                '../tiles/space/fuelpipe-hor.png', 
                ['N' => 'O-O-O', 'E' => 'O-FPh-O', 'S' => 'O-O-O', 'W' => 'O-FPh-O'], false
            ),
            new TileDefinition(
                '../tiles/space/fuelpipe-vert.png', 
                ['N' => 'O-FPv-O', 'E' => 'O-O-O', 'S' => 'O-FPv-O', 'W' => 'O-O-O'], false
            ),
            // fuelpipes - corners
            new TileDefinition(
                '../tiles/space/fuelpipe-n-w.png', 
                ['N' => 'O-FPv-O', 'E' => 'O-O-O', 'S' => 'O-O-O', 'W' => 'O-FPh-O'], false
            ),
            new TileDefinition(
                '../tiles/space/fuelpipe-n-e.png', 
                ['N' => 'O-FPv-O', 'E' => 'O-FPh-O', 'S' => 'O-O-O', 'W' => 'O-O-O'], false
            ),
            new TileDefinition(
                '../tiles/space/fuelpipe-s-e.png', 
                ['N' => 'O-O-O', 'E' => 'O-FPh-O', 'S' => 'O-FPv-O', 'W' => 'O-O-O'], false
            ),
            new TileDefinition(
                '../tiles/space/fuelpipe-s-w.png', 
                ['N' => 'O-O-O', 'E' => 'O-O-O', 'S' => 'O-FPv-O', 'W' => 'O-FPh-O'], false
            ),
            // fuelpipes - walls
            new TileDefinition(
                '../tiles/space/wall-fuelpipe-n.png', 
                ['N' => 'O-FPv-O', 'E' => 'O-H-G', 'S' => 'G-G-G', 'W' => 'O-H-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-fuelpipe-s.png', 
                ['N' => 'G-G-G', 'E' => 'G-H-O', 'S' => 'O-FPv-O', 'W' => 'G-H-O'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-fuelpipe-e.png', 
                ['N' => 'G-V-O', 'E' => 'O-FPh-O', 'S' => 'G-V-O', 'W' => 'G-G-G'], false
            ),
            new TileDefinition(
                '../tiles/space/wall-fuelpipe-w.png', 
                ['N' => 'O-V-G', 'E' => 'G-G-G', 'S' => 'O-V-G', 'W' => 'O-FPh-O'], false
            ),

            // train - track
            new TileDefinition(
                '../tiles/space/train-vert-w.png', 
                ['N' => 'T-T-O', 'E' => 'O-O-O', 'S' => 'T-T-O', 'W' => 'T-T-T'], false
            ),
            new TileDefinition(
                '../tiles/space/train-vert-w-alt.png', 
                ['N' => 'T-T-O', 'E' => 'O-O-O', 'S' => 'T-T-O', 'W' => 'T-T-T'], false
            ),
            new TileDefinition(
                '../tiles/space/train-vert-e.png', 
                ['N' => 'O-T-T', 'E' => 'T-T-T', 'S' => 'O-T-T', 'W' => 'O-O-O'], false
            ),
                        
        ];

        $circuitTileFactory = new TilesFactory($circuitTileDefinitions, true);
        $circuitTiles = $circuitTileFactory->createTiles();

        $floorTileFactory = new TilesFactory($floorTileDefinitions, true);
        $floorTiles = $floorTileFactory->createTiles();

        $spaceTileFactory = new TilesFactory($spaceTileDefinitions, true);
        $spaceTiles = $spaceTileFactory->createTiles();


        $tileSets = [
            'demo' => $demoTiles,
            'circuit' => $circuitTiles,
            'floor' => $floorTiles,
            'space' => $spaceTiles,
        ];
        $allTiles = $tileSets[$this->tileSet];

        $generator = new Generator($this->size, $allTiles, $this->debug);

        $cells2 = $generator
            ->compute()
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
