<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day06 extends Solver
{
    public function solve()
    {
        [$times, $distances] = array_map(function($line) {
            preg_match_all('/\d+/', $line, $matches);
            return $matches[0];
        }, explode(PHP_EOL, $this->input));

        $this->part1 = array_product(array_map([$this, 'solveForTimeAndDistance'], $times, $distances));
        $this->part2 = $this->solveForTimeAndDistance(join('', $times), join('', $distances));
    }

    /*
     * x * (t-x) = d
     * -x^2 + t -d = 0
     * x = (-t +- sqrt(t^2 - 4 * d)) / -2
     * 0.01 modifier to avoid repeating the record
     */
    private function solveForTimeAndDistance($time, $distance): int
    {
        $sqrt = sqrt(pow($time, 2) - (4 * $distance));
        $minHold = ceil((-$time + $sqrt) / -2 + 0.01);
        $maxHold = floor((-$time - $sqrt) / -2 - 0.01);
        return abs($maxHold - $minHold) + 1;
    }
}