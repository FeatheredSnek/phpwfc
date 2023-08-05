<?php

namespace WFC;

class TileDefinition 
{
    public string $image;
    public array $sockets;
    public bool $rotate;

    public function __construct(string $image, array $sockets, bool $rotate = false) {
        $this->image = $image;
        $this->sockets = $sockets;
        $this->rotate = $rotate;
    }
}
