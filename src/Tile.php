<?php

namespace WFC;

class Tile
{
    public string $image;
    public array $sockets;

    public function __construct(string $image, array $sockets)
    {
        $this->image = $image;
        $this->sockets = $sockets;
    }

    public function getSocketAtDirection(string $direction)
    {
        return $this->sockets[$direction];
    }
}
