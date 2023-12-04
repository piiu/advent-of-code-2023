<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Coordinates\Location;
use AdventOfCode\Common\Coordinates\Map;
use AdventOfCode\Common\Solver;

class Day03 extends Solver
{
    const SPACE = '.';
    public function solve()
    {
        $map = new Map($this->input);
        $numbers = [];
        foreach ($map->getMap() as $y => $row) {
            $currentNumber = null;
            $nextToSymbols = [];
            foreach ($row as $x => $value) {
                if ($value === self::SPACE || !is_numeric($value)) {
                    if ($currentNumber && !empty($nextToSymbols)) {
                        $numbers[] = [
                            'number' => (int)$currentNumber,
                            'nextToSymbols' => array_unique($nextToSymbols)
                        ];
                    }
                    $currentNumber = null;
                    $nextToSymbols = [];
                    continue;
                }
                $currentNumber = $currentNumber ? $currentNumber.$value : $value;
                    $location = new Location($x, $y);
                    foreach (Location::ALL_DIRECTIONS_DIAGONAL as $directions) {
                        $testLocation = (clone $location)->moveMultiple($directions);
                        $testValue = $map->getValue($testLocation);
                        if ($testValue && $testValue !== self::SPACE && !is_numeric($testValue)) {
                            $nextToSymbols[] = $testValue . '-' . $testLocation->toString();
                        }
                    }
            }
            if ($currentNumber && !empty($nextToSymbols)) {
                $numbers[] = [
                    'number' => (int)$currentNumber,
                    'nextToSymbols' => array_unique($nextToSymbols)
                ];
            }
        }
        $this->part1 = array_sum(array_column($numbers, 'number'));

        $gears = [];
        foreach ($numbers as $number) {
            foreach ($number['nextToSymbols'] as $symbol) {
                if ($symbol[0] === '*') {
                    if (empty($gears[$symbol])) {
                        $gears[$symbol] = [$number['number']];
                    } else {
                        $gears[$symbol][] = $number['number'];
                    }
                }
            }
        }

        $this->part2 = array_sum(array_map('array_product', array_filter($gears, function($numbers) {
            return count($numbers) === 2;
        })));
    }
}