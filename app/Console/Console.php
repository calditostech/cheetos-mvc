<?php

namespace App\Console;

use App\Console\Commands\MakeController;
use App\Console\Commands\MakeModel;
use App\Console\Commands\CommandHelpers;

class Console {
    protected array $commands = [];

    public function __construct() {
        $this->commands = [
            'cheetos:controller' => MakeController::class,
            'cheetos:model' => MakeModel::class,
        ];
    }

    public function run(array $argv) {
        $command = $argv[1] ?? null;
        $name = $argv[2] ?? null;

        if (!$command || !isset($this->commands[$command])) {
            CommandHelpers::errorMessage("Comando inválido.");
            return;
        }

        $commandClass = new $this->commands[$command]();
        $commandClass->handle($name);
    }
}
