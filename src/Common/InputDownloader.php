<?php

namespace AdventOfCode\Common;

class InputDownloader
{
    private ?string $cookie;

    const BASE_URL = 'https://adventofcode.com/2023';

    public function __construct(string $cookie)
    {
        $this->cookie = $cookie;
    }

    public function getInput(int $day) {
        $stream = stream_context_create([
            "http" => [
                "method" => "GET",
                "header" => "Cookie: session=$this->cookie"
            ]
        ]);
        $inputContents = file_get_contents(self::BASE_URL . "/day/$day/input", false, $stream);
        return trim($inputContents);
    }
}