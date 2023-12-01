<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day01 extends Solver
{
    const NUMBERS = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9
    ];
    public function solve()
    {
        $this->part1 = $this->part2 = 0;
        foreach (explode(PHP_EOL, $this->input) as $line) {
            preg_match_all('/\d/', $line, $numerics);
            $this->part1 += (int)(reset($numerics[0]).end($numerics[0]));

            preg_match_all('/(?=(\d|'.implode('|', array_keys(self::NUMBERS)).'))/', $line, $numbers);
            $numbers = array_map(function($number) {
                return self::NUMBERS[$number] ?? $number;
            }, $numbers[1]);
            $this->part2 += (int)(reset($numbers).end($numbers));
        }
    }
}