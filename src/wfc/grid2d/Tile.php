<?php

namespace WFC\Grid2D;

use WFC\AbstractTile;

class Tile extends AbstractTile
{
    public string $image;
    public array $sockets;
    public ?int $rotation;


    public function __construct(string $image, array $sockets, ?int $rotation = null)
    {
        $this->resource = $image;
        $this->image = $image;
        $this->sockets = $sockets;
        $this->rotation = $rotation;
    }

    public function getSocketAtDirection(string $direction) : array
    {
        return $this->sockets[$direction];
    }

    public function getRequiredSocketAtDirection(string $direction) : array
    {
        return $this->sockets[self::getOpposite($direction)];
    }

    public function __toString()
    {
        return $this->getResource();
    }

    private static function getOpposite(string $direction) : string 
    {
        $opposites = [
            'N' => 'S',
            'S' => 'N',
            'E' => 'W',
            'W' => 'E'
        ];
        return $opposites[$direction];
    }

    public function getResource() : string
    {
        return $this->image;
    }
}
