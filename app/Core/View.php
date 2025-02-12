<?php

namespace App\Core;

class View {
    public static function render(string $view, array $data = []) {
        $file = __DIR__ . "/../../views/$view.php";

        if (file_exists($file)) {
            extract($data);
            require $file;
        } else {
            echo "Erro: View '$view' não encontrada!";
        }
    }
}

