<?php

namespace Output;

class GridRendererSetup {
    public int $cols;
    public int $rows;
    public int $tileSize;

    public function __construct(int $cols = 5, int $rows = 5, int $tileSize = 20) {
        $this->cols = $cols;
        $this->rows = $rows;
        $this->tileSize = $tileSize;
    }
}