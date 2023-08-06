<?php

namespace WFC;

use Exception;

abstract class AbstractGenerator
{
    public int $size;
    public array $tiles;
    
    protected array $cells = [];
    protected bool $debug = false;
    protected bool $verbose = false;


    abstract public function __construct(int $size, array $tiles, $debug = false, $verbose = false);

    abstract protected function init() : self;


    public function compute(?int $maxAttempts = null) : self {
        $currentAttempt = 0;
        $result = null;

        if (!isset($maxAttempts)) {
            $maxAttempts = $this->size;
        }

        while ($currentAttempt < $maxAttempts) {
            $this->init();
            while (!($result instanceof AbstractGenerator)) {
                try {
                    $result = $this->observe();
                } catch (Exception $e) {
                    break;
                }
            }

            if ($result instanceof AbstractGenerator) {
                break;
            }

            $currentAttempt++;
            if ($this->debug) {
                echo "attempt $currentAttempt of $maxAttempts completed <br/>";
            }
        }

        return $this;
    }


    private function observe() : ?self
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
                if ($this->debug) {
                    echo $e->getMessage();
                }
                throw $e;
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
                    
                    if ($this->debug && $this->verbose) {
                        echo "cell index $cellIndex neighbor index $neighborIndex, ";
                        echo "neighbor cell result: $neighborCell->result";
                        echo "there has to be a socket $requiredSocket at $neighborDirection in cell $cellIndex, <br/>";
                    }
                    
                    $filteredOptions = array_filter($cell->options, function ($option) use ($neighborDirection, $requiredSocket) {
                        $optionSocket = $option->getSocketAtDirection($neighborDirection);
                        $isOptionValid = $optionSocket === $requiredSocket;
                        
                        if ($this->debug && $this->verbose) {
                            $str = $isOptionValid ? "valid" : "invalid";
                            echo "it has option $option, ";
                            echo "and this option has socket $optionSocket at $neighborDirection, ";
                            echo "therefore it is $str";
                            echo "<br/>";
                        }

                        return $isOptionValid;
                    });
                    $cell->options = $filteredOptions;

                    if ($this->debug && $this->verbose) {
                        echo "that leaves following options for cell $cellIndex <br/>";
                        echo var_export(array_keys($cell->options, 1));
                        echo "<br/>";
                    }
                }
            }
        }
        return null;
    }


    public function getCells() : array
    {
        return $this->cells;
    }

}
