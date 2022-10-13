<?php

namespace App\Helpers;

class Formatter
{

    public static function getXPForLevel($level)
    {
        $points = 0;
        $output = 0;
        for ($lvl = 1; $lvl <= $level; $lvl++) {
            $points += floor($lvl + 300.0 * pow(2.0, $lvl / 7.0));
            if ($lvl >= $level) {
                return $output;
            }
            $output = (int)floor($points / 4);
        }
        return 0;
    }

    public static function formatRsAmount($amount)
    {
        switch ($amount) {
            case $amount < 10000:
                return $amount;
                break;
            case $amount < 1000000:
                return floor($amount / 1000) . 'K';
                break;
            case $amount <= 2147483647:
                return floor($amount / 1000000) . 'M';
                break;
        }
    }

    public static function shorten($str, $start, $end)
    {
        if ($end > strlen($str)) {
            return $str;
        }
        return substr($str, $start, $end) . '...';
    }

    public static function getTense($str)
    {
        $tenseArray = [
            'kick' => 'kicked',
            'ban' => 'banned',
            'unban' => 'un-banned',
            'ipban' => 'ipbanned',
            'unipban' => 'un-ipbanned',
            'mute' => 'muted',
            'unmute' => 'un-muted',
            'macban' => 'mac-banned',
            'unmacban' => 'un-macbanned',
        ];
        $str = strtolower($str);
        return (array_key_exists($str, $tenseArray)) ? $tenseArray[$str] : $str;
    }

    public static function getReverseAction($str)
    {
        $str = strtolower($str);
        $actionArray = [
            'ban' => 'unban',
            'ip-ban' => 'unipban',
            'mute' => 'unmute',
            'mac-ban' => 'unmacban',
        ];
        return (array_key_exists($str, $actionArray)) ? $actionArray[$str] : $str;
    }
}