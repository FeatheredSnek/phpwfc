<?php

namespace WFC;

abstract class AbstractTile
{
    protected $resource;
    public array $sockets;
    
    abstract public function getSocketAtDirection(string $direction) : array;

    abstract public function getRequiredSocketAtDirection(string $direction) : array;
    
    abstract public function getResource();

    abstract public function __toString();
}
