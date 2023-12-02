<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day02 extends Solver
{
    public function solve()
    {
        $this->part1 = $this->part2 = 0;
        foreach (explode(PHP_EOL, $this->input) as $line) {
            [$game, $setList] = explode(': ', $line);
            $gameNumber = (int)ltrim($game, 'Game ');
            $sets = array_map(function($rawSet) {
                $set = [];
                foreach (explode(', ', $rawSet) as $cubeDef) {
                    [$number, $color] = explode(' ', $cubeDef);
                    $set[$color] = (int)$number;
                }
                return $set;
            }, explode('; ', $setList));

            if (max(array_column($sets, 'red')) <= 12
                && max(array_column($sets, 'green')) <= 13
                && max(array_column($sets, 'blue')) <= 14
            ) {
                $this->part1 += $gameNumber;
            }

            $this->part2 += max(array_column($sets, 'red'))
                * max(array_column($sets, 'green'))
                * max(array_column($sets, 'blue'));
        }
    }
}