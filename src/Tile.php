<?php

namespace WFC;

class Tile
{
    public string $image;
    public int $xPos;
    public int $yPos;

    public function __construct(int $xPos = 0, int $yPos = 0, string $image = '') {
        $this->image = $image;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
    }
}
