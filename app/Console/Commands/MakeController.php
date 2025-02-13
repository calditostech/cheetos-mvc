<?php

namespace App\Console\Commands;

class MakeController {
    public function handle($name) {
        $controllerTemplate = "<?php\n\nnamespace App\Controllers;\n\nclass {$name}Controller {\n\n    public function index() {\n        // Listar todos os registros\n    }\n\n    public function show(\$id) {\n        // Exibir um registro específico\n    }\n\n    public function create() {\n        // Exibir o formulário de criação\n    }\n\n    public function store() {\n        // Salvar um novo registro\n    }\n\n    public function edit(\$id) {\n        // Exibir o formulário de edição\n    }\n\n    public function update(\$id) {\n        // Atualizar um registro específico\n    }\n\n    public function destroy(\$id) {\n        // Excluir um registro específico\n    }\n\n}\n";
        $filePath = __DIR__ . "/../../Controllers/{$name}Controller.php";

        if (file_put_contents($filePath, $controllerTemplate)) {
            CommandHelpers::successMessage("Controller {$name} criada com sucesso!");
        } else {
            CommandHelpers::errorMessage("Erro ao criar o controller {$name}.");
        }
    }
}
