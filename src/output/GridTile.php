<?php

namespace Output;

class GridTile
{
    public ?string $image;
    public int $xPos;
    public int $yPos;
    public ?string $content;

    public function __construct(int $xPos = 0, int $yPos = 0, ?string $image = null, ?string $content = null) {
        $this->image = $image;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->content = $content;
    }
}
