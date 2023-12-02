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
            $sets = [];
            $gamePossible = true;
            foreach (explode('; ', $setList) as $rawSet) {
                $set = [];
                foreach (explode(', ', $rawSet) as $cubeDef) {
                    [$number, $color] = explode(' ', $cubeDef);
                    $set[$color] = (int)$number;
                }
                if (($set['red'] ?? 0) > 12 || ($set['green'] ?? 0) > 13 || ($set['blue'] ?? 0) > 14) {
                    $gamePossible = false;
                }
                $sets[] = $set;
            }

            if ($gamePossible) {
                $this->part1 += $gameNumber;
            }

            $this->part2 += max(array_column($sets, 'red'))
                * max(array_column($sets, 'green'))
                * max(array_column($sets, 'blue'));
        }
    }
}