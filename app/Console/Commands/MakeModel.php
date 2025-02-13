<?php

namespace App\Console\Commands;

class MakeModel {
    public function handle($name) {
        $modelTemplate = "<?php\n\nnamespace App\Models;\n\nclass {$name} {\n    protected \$table = '$name';\n    protected \$columns = [];\n    \n    // Construtor\n    public function __construct() {\n        // Inicialize as colunas aqui\n        \$this->columns = [\n            // Adicione as colunas aqui\n        ];\n    }\n}\n";
        $filePath = __DIR__ . "/../../Models/{$name}.php";

        if (file_put_contents($filePath, $modelTemplate)) {
            CommandHelpers::successMessage("Model {$name} criada com sucesso!");
        } else {
            CommandHelpers::errorMessage("Erro ao criar o model {$name}.");
        }
    }
}
