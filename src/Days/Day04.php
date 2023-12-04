<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day04 extends Solver
{
    private array $cards = [];

    public function solve()
    {
        foreach (explode(PHP_EOL, $this->input) as $line) {
            preg_match('/Card\s+(\w+):\s+((?:\s*\w+)+)\s+\|\s+((?:\s*\w+)+)/', $line, $result);
            $this->cards[$result[1]] = count(array_intersect(preg_split('/\s+/', $result[2]), preg_split('/\s+/', $result[3])));
        }

        $this->part1 = array_sum(array_map(function($matches) {
            return $matches === 0 ? 0 : pow(2, $matches - 1);
        }, $this->cards));

        $this->part2 = array_sum(array_map([$this, 'getCardsReceived'], array_keys($this->cards)));
    }

    private function getCardsReceived($number, $count = 0) {
        if ($this->cards[$number] > 0) {
            foreach (range($number + 1, $number + $this->cards[$number]) as $receivedCard) {
                $count += $this->getCardsReceived($receivedCard);
            }
        }
        return $count + 1;
    }
}