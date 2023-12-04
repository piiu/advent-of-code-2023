<?php

namespace AdventOfCode;


use AdventOfCode\Common\Config;
use AdventOfCode\Common\InputDownloader;
use AdventOfCode\Common\Solver;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $options = getopt("d:");
    $day = array_pop($options) ?? null;

    if (!$day) {
        throw new \Exception("Invalid day");
    }

    $className = "AdventOfCode\Days\Day" . str_pad($day, 2, '0', STR_PAD_LEFT);
    if (!class_exists($className)) {
        throw new \Exception("Missing solver for day $day");
    }

    $inputFile = __DIR__ . "/../input/" . str_pad($day, 2, '0', STR_PAD_LEFT);
    if (file_exists($inputFile)) {
        $input = file_get_contents($inputFile);
    } elseif (!$cookie = Config::getSessionCookie()) {
        throw new \Exception("No session cookie configured - add input file manually");
    } else {
        $inputDownloader = new InputDownloader($cookie);
        $input = $inputDownloader->getInput($day);
        if (empty($input)) {
            throw new \Exception("Input not available (yet)");
        }
        file_put_contents($inputFile, $input);
    }

    /** @var Solver $solver */
    $solver = new $className($input);
    $solver->results();
} catch (\Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}

