<?php

namespace Output;

final class GridRenderer {

    protected GridRendererSetup $setup;
    protected iterable $tiles;
    protected string $output;

    /**
     * @param GridRendererSetup $setup
     * @param GridTile[] $tiles
     */
    public function __construct(GridRendererSetup $setup = null, iterable $tiles = [])
    {
        $this->setup = $setup;
        $this->tiles = $tiles;
    }

    private function createGrid() : HTMLElement 
    {
        $cols = $this->setup->cols;
        $rows = $this->setup->rows;
        $size = $this->setup->tileSize;
        $width = $cols * $size;
        $height = $rows * $size;
        
        $gridStyleDef = new StyleDef([
            'display' => 'grid',
            'grid-template-columns' => "repeat($cols, $size" . 'px)',
            'grid-template-rows' => "repeat($rows, $size" . 'px)',
            'width' => $width . 'px',
            'height' => $height . 'px',
        ]);

        $tileElements = [];
        foreach ($this->tiles as $tile) {
            $tileStyleDef = new StyleDef([
                'grid-column' => "$tile->xPos / auto",
                'grid-row' => "$tile->yPos / auto",
                'width' => '100%',
                'height' => '100%',
                'outline' => '1px solid lightgray',
                'background-size' => 'cover',
                'background-color' => '#333',
            ]);
            if (isset($tile->image)) {
                $tileStyleDef->addProperty('background-image', $tile->image);
            }

            $tileElement = null;
            if (isset($tile->content)) {
                $tileElement = new HTMLElement('div', $tileStyleDef, null, $tile->content);
            } else {
                $tileElement = new HTMLElement('div', $tileStyleDef);
            }
            
            array_push($tileElements, $tileElement);
        }

        $gridElement = new HTMLElement('div', $gridStyleDef, $tileElements);
        return $gridElement;
    } 

    private static function randomHSL(bool $affectHue = true, bool $affectSaturation = false, bool $affectLightness = false) : string
    {
        $h = $affectHue ? rand(0, 360) : 0;
        $s = $affectSaturation ? rand(0, 100) : 80;
        $l = $affectLightness ? rand(0, 100) : 50;
        return "hsl($h $s% $l%)";
    }

    public function render() : string
    {
        return (string) $this->createGrid();
    }
};