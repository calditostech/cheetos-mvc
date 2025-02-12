# Cheetos MVC

Cheetos MVC é um mini framework MVC (Model-View-Controller) em PHP, projetado para ser simples de utilizar. Com ele, você pode rapidamente começar a desenvolver suas aplicações web usando as práticas recomendadas de separação de responsabilidades.

## Instalação

Para começar a usar o Cheetos MVC, siga estas etapas:

1. **Clone o repositório do Git:**
```
git clone https://github.com/seu-usuario/cheetos-mvc.git
cd cheetos-mvc
composer install
```
2. **Configuração NGINX**
```
server {
    listen 80;
    server_name seu-dominio.com;
    root /caminho/para/cheetos-mvc/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
3. **Configuração APACHE**
```
<VirtualHost *:80>
    ServerAdmin webmaster@seu-dominio.com
    ServerName seu-dominio.com
    DocumentRoot "/caminho/para/cheetos-mvc/public"

    <Directory "/caminho/para/cheetos-mvc/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://localhost"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

4. **Estrutura do Projeto**
```
cheetos-mvc/
├── app/
│   ├── Controllers/
│   │   └── HomeController.php      # Controladores da aplicação
│   └── Core/
│       ├── View.php                # Classe View para renderização de templates
│       └── Router.php              # Classe Router para gerenciamento de rotas
├── public/
│   ├── index.php                   # Arquivo de entrada principal
│   ├── css/
│   │   └── styles.css              # Arquivo de estilos CSS
│   └── img/
│       ├── logo.png                # Logotipo
│       └── gear.png                # Imagem de engrenagem para animação
├── routes/
│   └── web.php                     # Definição de rotas da aplicação
├── views/
│   ├── home.php                    # View da página inicial
│   └── user.php                    # View de usuário
├── composer.json                   # Configuração do Composer
└── vendor/                         # Dependências instaladas via Composer
```

5. **Rotas**
```
use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();

$router->get('/', [new HomeController(), 'index']);
$router->get('home', [new HomeController(), 'index']);
$router->get('user/{id}', [new HomeController(), 'showUser']);

return $router;
```

6. **Controller**
```
namespace App\Controllers;

use App\Core\View;

class HomeController {
    public function index() {
        View::render('home', ['nome' => 'Ricardo']);
    }

    public function showUser($id) {
        View::render('user', ['id' => $id]);
    }
}
```

7. **Para Rodar**
```
http://localhost:8080/home
```
Esse README fornece uma visão geral do projeto, instruções de instalação, configuração do servidor web, estrutura do projeto e exemplos de uso. Você pode ajustar conforme necessário para atender às suas necessidades específicas. Se precisar de mais alguma coisa, estou à disposição! 🚀

