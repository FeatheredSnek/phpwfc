<?php

namespace Output;

class GridTile
{
    public ?string $image;
    public int $xPos;
    public int $yPos;
    public ?string $content;
    public ?int $rotation;
    public ?string $debugInfo;

    public function __construct(int $xPos = 0, int $yPos = 0, ?string $image = null, ?string $content = null, ?int $rotation = null, ?string $debugInfo = null) {
        $this->image = $image;
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->content = $content;
        $this->rotation = $rotation;
        $this->debugInfo = $debugInfo;
    }
}
