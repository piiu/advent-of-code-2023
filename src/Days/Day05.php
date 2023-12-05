<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day05 extends Solver
{
    public function solve()
    {
        $lines = explode(PHP_EOL, $this->input);
        $seeds = explode(' ', str_replace('seeds: ', '', array_shift($lines)));

        $seedRanges = [];
        $currentBatch = [];
        foreach ($seeds as $seed) {
            $currentBatch[] = $seed;
            if (count($currentBatch) === 2) {
                $seedRanges[] = [$currentBatch[0], $currentBatch[0] + $currentBatch[1] - 1];
                $currentBatch = [];
            }
        }

        array_shift($lines);
        foreach (explode(PHP_EOL . PHP_EOL, implode(PHP_EOL, $lines)) as $map) {
            $conversionMap = [];
            $map = explode(PHP_EOL, $map);
            array_shift($map);

            foreach ($map as $conversion) {
                $conversionMap[] = explode(' ', $conversion);
            }

            $seeds = array_map(function($seed) use ($conversionMap) {
                foreach ($conversionMap as $conversion) {
                    if ($seed >= $conversion[1] && $seed <= $conversion[1] + $conversion[2]) {
                        return $conversion[0] + $seed - $conversion[1];
                    }
                }
                return $seed;
            }, $seeds);

            usort($conversionMap, function($a, $b) {
                return $a[1] > $b[1] ? 1 : -1;
            });

            $newSeedRanges = [];
            foreach ($seedRanges as $seedRange) {
                $seedRangeAdded = false;
                foreach ($conversionMap as $conversion) {
                    if ($seedRange[1] < $conversion[1] || $seedRange[0] > ($conversion[1] + $conversion[2])) {
                        continue;
                    }
                    if ($seedRange[0] < $conversion[1]) {
                        $newSeedRanges[] = [$seedRange[0], $conversion[1] - 1];
                        $seedRange[0] = $conversion[1];
                    }
                    if ($seedRange[1] <= ($conversion[1] + $conversion[2])) {
                        $newSeedRanges[] = [$seedRange[0], $seedRange[1]];
                    } else {
                        $newSeedRanges[] = [$seedRange[0], $conversion[1] + $conversion[2] - 1];
                        $newSeedRanges[] = [$conversion[1] + $conversion[2], $seedRange[1]];
                    }
                    $seedRangeAdded = true;
                }
                if (!$seedRangeAdded) {
                    $newSeedRanges[] = $seedRange;
                }
            }
            $seedRanges = array_map(function ($seedRange) use ($conversionMap) {
                foreach ($conversionMap as $conversion) {
                    if ($seedRange[0] >= $conversion[1] && $seedRange[0] <= $conversion[1] + $conversion[2]) {
                        $modifier = $conversion[0] - $conversion[1];
                        return [$seedRange[0] + $modifier, $seedRange[1] + $modifier];
                    }
                }
                return $seedRange;
            }, $newSeedRanges);
        }

        $this->part1 = min($seeds);
        $this->part2 = min(array_map(function($seedRange) {
            return (int)$seedRange[0];
        }, $seedRanges));
    }
}