<?php

namespace AdventOfCode\Common\Coordinates;

class Map
{
    private array $map;

    public function __construct(string $rawMap)
    {
        $this->map = array_map(function ($row) {
            return str_split($row);
        }, explode(PHP_EOL, $rawMap));
    }

    public function getMap(): array
    {
        return $this->map;
    }

    public function getValue(Location $point) : ?string
    {
        return $this->map[$point->y][$point->x] ?? null;
    }

    public function setValue(Location $point, string $value)
    {
        $this->map[$point->y][$point->x] = $value;
    }
}