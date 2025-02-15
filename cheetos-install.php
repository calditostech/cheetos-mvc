<?php

// Definir o repositório e diretório de instalação
$repoUrl = "https://github.com/calditostech/cheetos-mvc.git";
$dir = "cheetos-mvc";

// Clonar o repositório
exec("git clone $repoUrl $dir");
chdir($dir);

// Instalar dependências do Composer
exec("composer install");

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
file_put_contents("/etc/nginx/sites-available/cheetos-mvc", $nginxConfig);
exec("ln -s /etc/nginx/sites-available/cheetos-mvc /etc/nginx/sites-enabled/");
exec("service nginx restart");

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
file_put_contents("/etc/apache2/sites-available/cheetos-mvc.conf", $apacheConfig);
exec("a2ensite cheetos-mvc");
exec("service apache2 restart");

echo "Instalação do Cheetos MVC concluída com sucesso!\n";
