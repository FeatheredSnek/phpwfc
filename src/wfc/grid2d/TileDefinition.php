<?php

namespace WFC\Grid2D;

use Exception;

class TileDefinition 
{
    public string $image;
    public array $sockets;
    public bool $rotate;
    public int $socketType;

    public const STRING_SOCKET = 0;
    public const ARRAY_SOCKET = 1;
    public const DELIMITED_SOCKET = 2;
    public const UNKNOWN_SOCKET = 3;

    public const DELIMITER = '-';


    public function __construct(string $image, array $sockets, bool $rotate = false) {
        $this->image = $image;
        $this->rotate = $rotate;

        $this->socketType = self::determineSocketType($sockets);

        if ($this->socketType === self::DELIMITED_SOCKET) {
            $explodedSockets = array_map(function ($socketValues) {
                return explode('-', $socketValues);
            }, $sockets);
            $this->sockets = $explodedSockets;
        } else {
            $this->sockets = $sockets;
        }
        
    }


    private static function determineSocketType(array $sockets) : int
    {
        if (empty($sockets)) {
            throw new Exception('no sockets provided');
        }

        $socketTypes = array_map(function ($socket) {
            if (is_array($socket)) {
                return self::ARRAY_SOCKET;
            }
            elseif (is_string($socket) && str_contains($socket, self::DELIMITER)) {
                return self::DELIMITED_SOCKET;
            }
            elseif (is_string($socket)) {
                return self::STRING_SOCKET;
            }
            else {
                return self::UNKNOWN_SOCKET;
            }
        }, $sockets);

        if (count(array_unique($socketTypes)) != 1) {
            throw new Exception('invalid sockets -- different types of sockets present in tile definition set');
        }

        return reset($socketTypes);
    }
}
