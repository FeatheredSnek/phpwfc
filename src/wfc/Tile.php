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

    public function getRequiredSocketAtDirection(string $direction)
    {
        return $this->sockets[self::getOpposite($direction)];
    }

    public function __toString()
    {
        return $this->image;
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
}
