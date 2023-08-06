<?php

namespace WFC;

use Exception;

abstract class AbstractCell
{
    public bool $collapsed = false;
    public array $options;
    /** @var ?AbstractTile */
    public $result;
    public array $neighbors = [];

    abstract public function getIdentifier() : string;


    public function collapse() : void
    {
        if (empty($this->options)) {
            throw new Exception("no options available for cell {$this->getIdentifier()}");
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

    public function getResult() : ?self
    {
        return $this->result;
    }
}