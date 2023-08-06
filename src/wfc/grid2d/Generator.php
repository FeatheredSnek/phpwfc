<?php

namespace WFC\Grid2D;

use WFC\AbstractGenerator;

class Generator extends AbstractGenerator
{
    public function __construct(int $size, array $tiles, $debug = false, $verbose = false) {
        $this->size = $size;
        $this->tiles = $tiles;
        $this->debug = $debug;
        $this->verbose = $verbose;
    }


    public function init() : self {
        $this->cells = [];

        // generate cells for the grid
        for ($i = 0; $i < $this->size; $i++) { 
            for ($j = 0; $j < $this->size; $j++) { 
                $this->cells[] = new Cell($i, $j, $this->tiles);
            }
        }
        
        // set cell neighbors
        foreach ($this->cells as $cell) {
            $neighboringCoordinates = [
                'N' => [
                    'xPos' => $cell->xPos, 
                    'yPos' => $cell->yPos - 1,
                ],
                'S' => [
                    'xPos' => $cell->xPos, 
                    'yPos' => $cell->yPos + 1,
                ],
                'E' => [
                    'xPos' => $cell->xPos + 1, 
                    'yPos' => $cell->yPos,
                ],
                'W' => [
                    'xPos' => $cell->xPos - 1, 
                    'yPos' => $cell->yPos,
                ],
            ];
            foreach ($neighboringCoordinates as $direction => $coordinates) {
                $key = self::array_search_func($this->cells, function ($c) use ($coordinates) {
                    return $c->xPos === $coordinates['xPos'] && $c->yPos === $coordinates['yPos'];
                });
                
                if ($key >= 0) {
                    $cell->addNeighbor($direction, $key);
                }
            }
        }
        return $this;
    }


    public static function array_search_func(array $arr, callable $func)
    {
        foreach ($arr as $key => $v)
            if ($func($v))
                return $key;
    
        return -1;
    }
}
