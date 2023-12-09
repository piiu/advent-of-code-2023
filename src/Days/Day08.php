<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day08 extends Solver
{
    public function solve()
    {
        [$rawSequence, $lines] = explode(PHP_EOL.PHP_EOL, $this->input);
        $sequence = str_split(str_replace(['L', 'R'], [0, 1], $rawSequence));

        $elements = [];
        foreach (explode(PHP_EOL, $lines) as $line) {
            [$index, $instruction] = explode(' = ', $line);
            $elements[$index] = explode(', ', trim($instruction, '()'));
        }

        $startingPoints = array_filter(array_keys($elements), function ($element) {
            return $element[-1] === 'A';
        });

        $results = [];
        foreach ($startingPoints as $startingPoint) {
            $step = 0;
            $currentElement = $startingPoint;
            while ($currentElement[-1] !== 'Z') {
                $currentElement = $elements[$currentElement][$sequence[$step % count($sequence)]];
                $step++;
            }
            $results[$startingPoint] = $step;
        }


        $this->part1 = $results['AAA'];

        $this->part2 = 1;
        foreach ($results as $result) {
            $this->part2 = (int)gmp_lcm($this->part2, $result);
        }
    }
}