<?php

// Função para verificar e criar diretórios, se necessário
function ensureDirectory($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

// Função para detectar o sistema operacional
function isWindows() {
    return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
}

// Pegar o nome do projeto a partir dos argumentos da linha de comando
$projectName = $argv[1] ?? 'cheetos-mvc';

// Definir o repositório e diretório de instalação
$repoUrl = "https://github.com/seu-usuario/cheetos-mvc.git";
$dir = $projectName;

// Clonar o repositório
exec("git clone $repoUrl $dir");
chdir($dir);

// Instalar dependências do Composer
exec("composer install");

// Caminhos de configuração
$nginxAvailable = "/etc/nginx/sites-available";
$nginxEnabled = "/etc/nginx/sites-enabled";
$apacheAvailable = "/etc/apache2/sites-available";

// Garantir que os diretórios existam
ensureDirectory($nginxAvailable);
ensureDirectory($nginxEnabled);
ensureDirectory($apacheAvailable);

// Criar configuração NGINX
$nginxConfig = "
server {
    listen 80;
    server_name seu-dominio.com;
    root " . getcwd() . "/public;

    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
";
file_put_contents("$nginxAvailable/$projectName", $nginxConfig);
if (isWindows()) {
    exec("mklink /J $nginxEnabled/$projectName $nginxAvailable/$projectName");
} else {
    exec("ln -s $nginxAvailable/$projectName $nginxEnabled/");
    exec("sudo service nginx restart");
}

// Criar configuração APACHE
$apacheConfig = "
<VirtualHost *:80>
    ServerAdmin webmaster@seu-dominio.com
    ServerName seu-dominio.com
    DocumentRoot \"" . getcwd() . "/public\"

    <Directory \"" . getcwd() . "/public\">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler \"proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://localhost\"
    </FilesMatch>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
";
file_put_contents("$apacheAvailable/$projectName.conf", $apacheConfig);
if (!isWindows()) {
    exec("sudo a2ensite $projectName");
    exec("sudo service apache2 restart");
}

// Exibir desenho ASCII e texto
echo "Instalação do Cheetos MVC concluída com sucesso!\n";
echo "
      / \\__
    (    @\\___
    /         O
   /   (_____)
/_____/     U

   _____ _            _           
  / ____| |          | |          
 | |    | | ___   ___| | _____ _ __ 
 | |    | |/ _ \\ / __| |/ / _ \\ '__|
 | |____| | (_) | (__|   <  __/ |
  \\_____|_|\\___/ \\___|_|\\_\\___|_|
                                  
";
