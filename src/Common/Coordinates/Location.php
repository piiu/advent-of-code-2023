<?php

namespace AdventOfCode\Common\Coordinates;

class Location
{
    public int $x;
    public int $y;

    const UP = 'U';
    const DOWN = 'D';
    const LEFT = 'L';
    const RIGHT = 'R';

    const ALL_DIRECTIONS = [
        self::UP,
        self::RIGHT,
        self::DOWN,
        self::LEFT,
    ];

    const ALL_DIRECTIONS_DIAGONAL = [
        [self::UP],
        [self::UP, self::RIGHT],
        [self::RIGHT],
        [self::RIGHT, self::DOWN],
        [self::DOWN],
        [self::DOWN, self::LEFT],
        [self::LEFT],
        [self::LEFT,self::UP]
    ];

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function move(string $direction, int $amount = 1) : self
    {
        if ($direction === self::UP) {
            $this->y -= $amount;
        }
        if ($direction === self::DOWN) {
            $this->y += $amount;
        }
        if ($direction === self::LEFT) {
            $this->x -= $amount;
        }
        if ($direction === self::RIGHT) {
            $this->x += $amount;
        }
        return $this;
    }

    public function moveMultiple(array $directions) : self
    {
        foreach ($directions as $direction) {
            $this->move($direction);
        }
        return $this;
    }

    public function isEqual(self $location) : bool
    {
        return $this->x === $location->x && $this->y === $location->y && $this->z === $location->z;
    }

    public function toString() : string
    {
        return join('|', [$this->x, $this->y]);
    }
}