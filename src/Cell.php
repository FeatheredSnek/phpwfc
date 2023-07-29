<?php

namespace WFC;

use Exception;

class Cell
{
    public bool $collapsed = false;
    public array $options;
    public string $result;
    public int $xPos;
    public int $yPos;
    // public int $entropy;

    public array $neighbors = [];

    public function __construct(int $xPos = 0, int $yPos = 0, array $options = []) {
        $this->options = $options;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        // $this->entropy = count($options);
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
        $randomOptionKey = array_rand($this->options);
        $this->result = $this->options[$randomOptionKey];
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
}