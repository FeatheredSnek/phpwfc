<?php

namespace WFC;

use Exception;

class Cell
{
    public bool $collapsed = false;
    public array $options;
    public Tile $result;
    public int $xPos;
    public int $yPos;

    public array $neighbors = [];

    public function __construct(int $xPos = 0, int $yPos = 0, array $options = []) {
        $this->options = $options;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
    }

    public function collapse() : void
    {
        if (empty($this->options)) {
            throw new Exception("no options available for cell $this->xPos, $this->yPos");
        }

        if ($this->collapsed) {
            throw new Exception("cell already collapsed with $this->result");
        }

        $this->collapsed = true;
        $resultKey = array_rand($this->options);
        $this->result = $this->options[$resultKey];
        $this->options = [];
    }

    public function setNeighbors(array $neighbors) : void
    {
        $this->neighbors = $neighbors;
    }

    public function addNeighbor(string $direction, int $neighborIndex)
    {
        $this->neighbors[$direction] = $neighborIndex;
    }

    public function getEntropy() : int
    {
        return $this->collapsed ? 0 : count($this->options); 
    }

    public function getResult() : ?Tile
    {
        return $this->result;
    }
}