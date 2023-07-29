<?php

namespace WFC;

class Generator
{
    public int $size;
    public array $tiles;

    public function __construct(int $size) {
        $this->size = $size;
    }
}
