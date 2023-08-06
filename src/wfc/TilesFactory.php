<?php

namespace WFC;

final class TilesFactory
{
    private array $tiles = [];
    private array $tileSet = [];
    private bool $removeDuplicates = true;
    
    private const ROTATION_UNITARY = 0;
    private const ROTATION_ARRAY = 1;

    private const ROTATION_TRANSFORMS = [
        ['N' => 'N', 'E' => 'E', 'S' => 'S', 'W' => 'W'],
        ['N' => 'W', 'E' => 'N', 'S' => 'E', 'W' => 'S'],
        ['N' => 'S', 'E' => 'W', 'S' => 'N', 'W' => 'E'],
        ['N' => 'E', 'E' => 'S', 'S' => 'W', 'W' => 'N'],
    ];

    private const DIRECTION_TYPES = [
        'N' => 'plain',
        'E' => 'plain',
        'S' => 'reversed',
        'W' => 'reversed',
    ];


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

            for ($i = 1; $i < 4; $i++) {
                $rotationMode = 
                    $tileDefinition->socketType === TileDefinition::ARRAY_SOCKET || $tileDefinition->socketType === TileDefinition::DELIMITED_SOCKET 
                        ? self::ROTATION_ARRAY
                        : self::ROTATION_UNITARY;
                $rotatedSockets = self::rotateSockets($tileDefinition->sockets, $i, $rotationMode);
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


    private static function rotateSockets(array $sockets, int $rotations, int $rotationMode = 0) : array
    {
        $output = [];
        
        foreach (array_keys($sockets) as $socketDirection) {
            $transformedDirection = self::ROTATION_TRANSFORMS[$rotations][$socketDirection];
            $output[$socketDirection] = $sockets[$transformedDirection];

            if ($rotationMode === self::ROTATION_ARRAY) {
                if (self::DIRECTION_TYPES[$socketDirection] != self::DIRECTION_TYPES[$transformedDirection]) {
                    $output[$socketDirection] = array_reverse($output[$socketDirection]);
                }
            }
        }
        
        return $output;
    }
}
