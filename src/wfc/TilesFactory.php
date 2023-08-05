<?php

namespace WFC;

final class TilesFactory
{
    private array $tiles = [];
    private array $tileSet = [];
    private bool $removeDuplicates = true;


    public function __construct($tileSet, bool $removeDuplicates = true) {
        $this->tileSet = $tileSet;
        $this->removeDuplicates = $removeDuplicates;
    }


    public function createTiles() : array
    {
        $generatedTileGroups = [];

        foreach ($this->tileSet as $tileDefinition) {
            $generatedTileGroups[] = self::generateTilesFromDefinition($tileDefinition, $this->removeDuplicates);
        }

        $this->tiles = array_merge([], ...$generatedTileGroups);
        return $this->tiles;
    }


    private static function generateTilesFromDefinition(TileDefinition $tileDefinition, $removeDuplicates = true) : array
    {
        $output = [];
        $output[] = new Tile($tileDefinition->image, $tileDefinition->sockets);

        if ($tileDefinition->rotate) {
            $uniqueSocketsCollections = [];

            for ($i = 1; $i < 3; $i++) {
                $rotatedSockets = self::rotateSockets($tileDefinition->sockets, $i);
                $rotation = $i * 90;

                if ($removeDuplicates) {
                    $tileAlreadyExists = array_search($rotatedSockets, $uniqueSocketsCollections);
                    if (!$tileAlreadyExists) {
                        $uniqueSocketsCollections[] = $rotatedSockets;
                        $output[] = new Tile($tileDefinition->image, $rotatedSockets, $rotation);
                    }
                } 
                else {
                    $output[] = new Tile($tileDefinition->image, $rotatedSockets, $rotation);
                }
            }
        }

        return $output;
    }


    private static function rotateSockets($sockets, $rotations = 0) : array
    {
        $rotationTransforms = [
            ['N' => 'N', 'E' => 'E', 'S' => 'S', 'W' => 'W'],
            ['N' => 'W', 'E' => 'N', 'S' => 'E', 'W' => 'S'],
            ['N' => 'S', 'E' => 'W', 'S' => 'N', 'W' => 'E'],
            ['N' => 'E', 'E' => 'S', 'S' => 'W', 'W' => 'N'],
        ];
        
        $output = [];
        
        // TODO array keys
        foreach ($sockets as $socketDirection => $socketValue) {
            $transformedDirection = $rotationTransforms[$rotations][$socketDirection];
            $output[$socketDirection] = $sockets[$transformedDirection];  
        }
        
        return $output;
    }
}
