<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Console\Console;

$console = new Console();
$console->run($argv);
