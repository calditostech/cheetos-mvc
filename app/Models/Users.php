<?php

namespace App\Models;

class Users {
    protected $table = 'Users';
    protected $columns = [];
    
    // Construtor
    public function __construct() {
        // Inicialize as colunas aqui
        $this->columns = [
            // Adicione as colunas aqui
        ];
    }
}
