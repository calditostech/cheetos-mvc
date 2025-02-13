<?php

namespace App\Console\Commands;

class CommandHelpers {
    public static function successMessage($message) {
        $dog = "
          / \\__
        (    @\\___
        /         O
       /   (_____)
/_____/    U
        ";
        echo "\e[32m$message\n$dog\e[0m";
    }

    public static function errorMessage($message) {
        $sadDog = "
         __      _
        o'')}____//
         `_/      )
         (_(_/-(_/
        ";
        echo "\e[31m$message\n$sadDog\e[0m";
    }
}
