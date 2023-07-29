<?php

namespace WFC;

use Exception;

class Generator
{
    public int $size;
    public array $tiles;
    
    private array $cells = [];
    private bool $debug = false;


    public function __construct(int $size, array $tiles, $debug = false) {
        $this->size = $size;
        $this->tiles = $tiles;
        $this->debug = $debug;
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


    public function compute(int $maxIterations = null) : Generator
    {
        $iteration = 0;
        $result = null;
        
        if (!isset($maxIterations)) {
            $maxIterations = pow($this->size, 2);
        }

        echo $maxIterations;

        while ((!$result instanceof Generator) && $iteration < $maxIterations) {
            $result = $this->observe();
            $iteration++;
        }

        return $this;
    }


    private function observe() : ?Generator
    {
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
            if ($this->debug) {
                echo "no more cells with lowest entropy, wfc done";
            }
            return $this;
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
        foreach ($this->cells as $cellIndex => $cell) {
            if ($cell->collapsed) {
                continue;
            }

            $cellNeighbors = $cell->neighbors;

            foreach ($cellNeighbors as $neighborDirection => $neighborIndex) {
                $neighborCell = $this->cells[$neighborIndex];
                if ($neighborCell->collapsed) {
                    $requiredSocket = $neighborCell->result->getRequiredSocketAtDirection($neighborDirection);
                    
                    if ($this->debug) {
                        echo "cell index $cellIndex neighbor index $neighborIndex, ";
                        echo "neighbor cell result: $neighborCell->result";
                        echo "there has to be a socket $requiredSocket at $neighborDirection in cell $cellIndex, <br/>";
                    }
                    
                    $filteredOptions = array_filter($cell->options, function ($option) use ($neighborDirection, $requiredSocket) {
                        $optionSocket = $option->getSocketAtDirection($neighborDirection);
                        $isOptionValid = $optionSocket === $requiredSocket;
                        
                        if ($this->debug) {
                            $str = $isOptionValid ? "valid" : "invalid";
                            echo "it has option $option, ";
                            echo "and this option has socket $optionSocket at $neighborDirection, ";
                            echo "therefore it is $str";
                            echo "<br/>";
                        }

                        return $isOptionValid;
                    });
                    $cell->options = $filteredOptions;

                    if ($this->debug) {
                        echo "that leaves following options for cell $cellIndex <br/>";
                        echo var_export(array_keys($cell->options, 1));
                        echo "<br/>";
                    }
                }
            }
        }
        return null;
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
