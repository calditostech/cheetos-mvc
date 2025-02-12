<?php

namespace App\Core;

class Response {
    public static function redirect(string $url) {
        header("Location: $url");
        exit;
    }
}
