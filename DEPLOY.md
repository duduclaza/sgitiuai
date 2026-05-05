# Instruções de Deploy React + Vite + PHP

## Desenvolvimento

### 1. Instalar dependências

```bash
npm install
composer install
```

### 2. Iniciar o servidor de desenvolvimento

Terminal 1 - React (Vite):
```bash
npm run dev
```
Disponível em: `http://localhost:5173`

Terminal 2 - PHP:
```bash
php -S localhost:8000
```

### 3. Acessar a aplicação

- Frontend: `http://localhost:5173`
- API: `http://localhost:8000/api`

---

## Produção

### 1. Build do React

```bash
npm run build
```

Isso gera os arquivos em `dist/`

### 2. Estrutura de Deploy

A estrutura final deve ser:

```
/var/www/sgiiduai/
├── dist/                    # Arquivos do React (gerados pelo build)
│   ├── index.html
│   ├── .htaccess
│   ├── js/
│   ├── assets/
│   └── ...
├── app/                     # Controllers PHP
├── public/                  # Ponto de entrada do servidor
├── routes/                  # Rotas PHP
├── vendor/                  # Composer packages
├── .env                     # Configuração de ambiente
└── ...
```

### 3. Configurar o servidor web

#### Apache (recomendado)

1. Criar um Virtual Host:

```apache
<VirtualHost *:80>
    ServerName sgi.tiuai.com.br
    DocumentRoot /var/www/sgiiduai/dist

    <Directory /var/www/sgiiduai/dist>
        AllowOverride All
        Require all granted
        
        # Rewrite rules para React Router
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} -f
        RewriteRule ^ - [QSA,L]
        RewriteCond %{REQUEST_FILENAME} -d
        RewriteRule ^ - [QSA,L]
        RewriteRule ^api/ - [QSA,L]
        RewriteRule ^ index.html [QSA,L]
    </Directory>

    # Proxy para API PHP
    <Location /api>
        ProxyPass http://localhost:8001/api
        ProxyPassReverse http://localhost:8001/api
    </Location>

    ErrorLog ${APACHE_LOG_DIR}/sgi-error.log
    CustomLog ${APACHE_LOG_DIR}/sgi-access.log combined
</VirtualHost>
```

2. Ativar módulos necessários:

```bash
sudo a2enmod rewrite
sudo a2enmod proxy
sudo a2enmod proxy_http
sudo systemctl restart apache2
```

#### Nginx

```nginx
server {
    listen 80;
    server_name sgi.tiuai.com.br;
    root /var/www/sgiiduai/dist;

    # React Router - serve o index.html para todas as rotas não-estáticas
    location / {
        try_files $uri $uri/ /index.html;
    }

    # API Proxy
    location /api {
        proxy_pass http://localhost:8001/api;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }

    # Compressão GZIP
    gzip on;
    gzip_types text/html text/plain text/xml text/css text/javascript application/javascript application/json;
}
```

### 4. Variáveis de Ambiente

Criar/atualizar `.env.production`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sgi.tiuai.com.br
API_URL=https://sgi.tiuai.com.br/api
```

### 5. Permiissions

```bash
chmod -R 755 /var/www/sgiiduai
chmod -R 775 /var/www/sgiiduai/storage
```

### 6. HTTPS/SSL

Use Let's Encrypt:

```bash
sudo certbot certonly --apache -d sgi.tiuai.com.br
```

---

## Fluxo de Requisições

### Frontend (React)
1. Usuário acessa `https://sgi.tiuai.com.br`
2. Servidor entrega `dist/index.html`
3. React carrega e verifica autenticação via `/api/auth/me`
4. Se não autenticado, redireciona para `/login`

### Requisições de API
1. React faz requisição para `/api/auth/login`
2. Nginx/Apache redireciona para `http://localhost:8001/api/auth/login`
3. PHP processa a requisição
4. Resposta retorna em JSON

---

## Troubleshooting

**React Router não funciona (404 em refresh)**
- Certifique-se que o `.htaccess` está em `dist/`
- Apache: Ative `mod_rewrite`
- Nginx: Use `try_files` conforme acima

**CORS errors nas requisições**
- Adicione headers CORS no PHP:
```php
header('Access-Control-Allow-Origin: ' . $_ENV['APP_URL']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
```

**Sessões PHP não funcionam com React**
- Configure `httpOnly` nos cookies de sessão
- Envie `withCredentials: true` nas requisições Axios
