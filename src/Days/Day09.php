<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day09 extends Solver
{
    public function solve()
    {
        $this->part1 = 0;
        foreach (explode(PHP_EOL, $this->input) as $line) {
            $numbers = [explode(' ', $line)];
            do {
                $newLine = [];
                $currentLine = end($numbers);
                foreach ($currentLine as $index => $value) {
                    if (array_key_exists($index - 1, $currentLine)) {
                        $newLine[] = $value - $currentLine[$index - 1];
                    }
                }
                $numbers[] = $newLine;
                $uniqueValues = array_count_values($newLine);
            } while (!(count($uniqueValues) === 1 && array_keys($uniqueValues)[0] === 0));

            $currentIndex = count($numbers) - 1;
            $numbers[$currentIndex][] = 0;
            $numbers[$currentIndex][-1] = 0;
            ksort($numbers[$currentIndex]);
            do {
                $currentIndex--;
                $numbers[$currentIndex][] = end($numbers[$currentIndex]) + end($numbers[$currentIndex + 1]);
                $numbers[$currentIndex][-1] = $numbers[$currentIndex][0] - $numbers[$currentIndex + 1][-1];
                ksort($numbers[$currentIndex]);
            } while (array_key_exists($currentIndex - 1, $numbers));

            $this->part1 += end($numbers[0]);
            $this->part2 += $numbers[0][-1];
        }
    }
}