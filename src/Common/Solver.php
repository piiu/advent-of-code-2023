<?php

namespace AdventOfCode\Common;

abstract class Solver
{
    protected string $input;
    protected ?string $part1 = null;
    protected ?string $part2 = null;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public abstract function solve();

    public function results()
    {
        $this->solve();
        echo('Part 1: ' . $this->part1 . PHP_EOL);
        echo('Part 2: ' . $this->part2 . PHP_EOL);
    }
}