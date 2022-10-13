<?php

namespace App\Helpers;

class Utility
{
    /**
     * Escape special characters for a LIKE query.
     *
     * @param string $value
     * @param string $char
     *
     * @return string
     */
    static function escape_like(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char.$char, $char.'%', $char.'_'],
            $value
        );
    }
}