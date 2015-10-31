<?php
namespace Jamlee\Coroutine;

/**
 * Created by PhpStorm.
 * User: jamlee
 * Date: 2015/10/31
 * Time: 11:13
 */

class Log {

    public static function init(&$foreground_colors,&$background_colors) {
        // Set up shell colors
        $foreground_colors['black'] = '0;30';
        $foreground_colors['dark_gray'] = '1;30';
        $foreground_colors['blue'] = '0;34';
        $foreground_colors['light_blue'] = '1;34';
        $foreground_colors['green'] = '0;32';
        $foreground_colors['light_green'] = '1;32';
        $foreground_colors['cyan'] = '0;36';
        $foreground_colors['light_cyan'] = '1;36';
        $foreground_colors['red'] = '0;31';
        $foreground_colors['light_red'] = '1;31';
        $foreground_colors['purple'] = '0;35';
        $foreground_colors['light_purple'] = '1;35';
        $foreground_colors['brown'] = '0;33';
        $foreground_colors['yellow'] = '1;33';
        $foreground_colors['light_gray'] = '0;37';
        $foreground_colors['white'] = '1;37';
        $background_colors['black'] = '40';
        $background_colors['red'] = '41';
        $background_colors['green'] = '42';
        $background_colors['yellow'] = '43';
        $background_colors['blue'] = '44';
        $background_colors['magenta'] = '45';
        $background_colors['cyan'] = '46';
        $background_colors['light_gray'] = '47';
    }

    // Returns colored string
    public static function getColoredString($string, $foreground_color = null, $background_color = null) {
        $foreground_colors = array();
        $background_colors = array();
        self::init($foreground_colors, $background_colors);
        $colored_string = "";
        // Check if given foreground color found
        if (isset($foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($background_colors[$background_color])) {
            $colored_string .= "\033[" . $background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";
        return $colored_string;
    }

    // Returns all foreground color names
    public static function getForegroundColors() {
        $foreground_colors = array();
        $background_colors = array();
        self::init($foreground_colors, $background_colors);
        return array_keys($foreground_colors);
    }

    // Returns all background color names
    public static function getBackgroundColors() {
        $foreground_colors = array();
        $background_colors = array();
        self::init($foreground_colors, $background_colors);
        return array_keys($background_colors);
    }

    public static function __callStatic($name, $arguments)
    {
        $foreground_colors = array();
        $background_colors = array();
        self::init($foreground_colors, $background_colors);
        if(!Scheduler::$debug)
            return;
        switch($name) {
            case 'info':
                echo self::getColoredString($arguments[0], $foreground_colors['green']);
                break;
            case 'warn':
                echo self::getColoredString($arguments[0], $foreground_colors['yellow']);
                break;
            case 'error':
                echo self::getColoredString($arguments[0], $foreground_colors['red']);
                break;
        }
    }
}