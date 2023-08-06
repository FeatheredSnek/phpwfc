<?php

namespace WFC\Grid2D;

use WFC\AbstractCell;

class Cell extends AbstractCell
{
    /** @var ?Tile */
    public $result;
    public int $xPos;
    public int $yPos;


    public function __construct(int $xPos = 0, int $yPos = 0, array $options = []) {
        $this->options = $options;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
    }


    public function getIdentifier() : string
    {
        return "$this->xPos, $this->yPos"; 
    }
}