<?php

namespace AdventOfCode\Common;

class Config
{
    public static function getSessionCookie(): ?string {
        return self::getByKey('session_cookie');
    }

    private static function getByKey(string $key): ?string
    {
        $ini = parse_ini_file(__DIR__.'/../../config/app.ini');
        return $ini[$key] ?? null;
    }
}