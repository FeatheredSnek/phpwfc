<?php

namespace WFC;

use Exception;

class Generator
{
    public int $size;
    public array $tiles;

    private array $cells = [];

    public function __construct(int $size, array $tiles) {
        $this->size = $size;
        $this->tiles = $tiles;
    }

    public function init() {
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

    public function compute() {
        for ($i=0; $i < 10; $i++) { 

            // get the lowest entropy
            $lowestEntropy = count($this->tiles);
            foreach ($this->cells as $cell) {
                $cellEntropy = $cell->getEntropy();
                if (!$cell->collapsed && $cellEntropy < $lowestEntropy) {
                    $lowestEntropy = $cellEntropy;
                }
            }
            
            // get ids of cells with lowest entropy (set to options count before the loop)
            $lowestEntropyCellsKeys = array_keys(array_filter($this->cells, function ($cell) use ($lowestEntropy) {
                return $cell->getEntropy() === $lowestEntropy;
            }));
            
            // break if there are no cells left
            if (empty($lowestEntropyCellsKeys)) {
                echo "no more cells with lowest entropy, wfc done";
                break;
            }
            
            // iterate through those lowest entropy cells and try to collapse each one, skip non collapsable ones
            shuffle($lowestEntropyCellsKeys);
            foreach ($lowestEntropyCellsKeys as $cellKey) {
                try {
                    $this->cells[$cellKey]->collapse();
                    break;
                } catch (Exception $e) {
                    continue;
                }
            }
            
            
            // recalculate entropy for all non-collapsed cells
            foreach ($this->cells as $cell) {
                if ($cell->collapsed) {
                    continue;
                }
            
                $cellNeighbors = $cell->neighbors;
            
                foreach ($cellNeighbors as $neighborDirection => $neighborIndex) {
                    $neighborCell = $this->cells[$neighborIndex];
                    if ($neighborCell->collapsed) {
                        $requiredSocket = $neighborCell->result->getRequiredSocketAtDirection($neighborDirection);
                        
                        // echo "cell index $cellIndex neighbor index $neighborIndex, ";
                        // echo "neighborcell result: $neighborCell->result";
                        // echo "there has to be a socket $requiredSocket at $neighborDirection in cell $cellIndex, <br/>";
                        
                        $filteredOptions = array_filter($cell->options, function ($option) use ($neighborDirection, $requiredSocket) {
                            // echo "it has option $option, ";
                            $optionSocket = $option->getSocketAtDirection($neighborDirection);
                            // echo "and this option has socket $optionSocket at $neighborDirection, ";
                            $isOptionValid = $optionSocket === $requiredSocket;
                            // $str = $isOptionValid ? "valid" : "invalid";
                            // echo "therefore it is $str";
                            // echo "<br/>";
                            return $isOptionValid;
                        });
                        $cell->options = $filteredOptions;
                        // echo "that leaves following options for cell $cellIndex <br/>";
                        // var_dump(array_keys($cell->options));
                        // echo "<br/>";
                    }
                }
            }
        }
        return $this;
    }

    public function getCells()
    {
        return $this->cells;
    }

    public static function array_search_func(array $arr, callable $func)
    {
        foreach ($arr as $key => $v)
            if ($func($v))
                return $key;
    
        return -1;
    }
}
