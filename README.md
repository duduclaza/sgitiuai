# Sistema de Melhoria Contínua

Sistema PHP MVC para gestão de melhorias contínuas em uma única empresa, com dashboard, usuários, departamentos, melhorias, reuniões, PDCA, SWOT, 5W2H, comentários, anexos, notificações, relatórios, auditoria e agente de IA preparado para API futura.

## Requisitos

- PHP 8.2 ou superior
- Composer
- MariaDB remoto ou local
- Extensão PDO MySQL habilitada

## Instalação

```bash
composer install
cp .env.example .env
```

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Edite o `.env` com os dados do MariaDB:

```env
DB_HOST=seu-host
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Crie o banco no MariaDB antes de executar as migrations:

```sql
CREATE DATABASE seu_banco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Migrations

Executar migrations pendentes:

```bash
php database/migrate.php
```

Desfazer a última migration:

```bash
php database/migrate.php rollback
```

Recriar todo o schema:

```bash
php database/migrate.php reset
```

As migrations ficam em `database/migrations`, têm classe PHP com métodos `up(PDO $pdo)` e `down(PDO $pdo)`, usam PDO, transações no migrator, chaves estrangeiras e índices.

## Usuário Inicial

Após rodar as migrations, acesse com:

- E-mail: `admin@melhoria.local`
- Senha: `admin123`

Altere a senha no primeiro acesso.

## Rodar Localmente

```bash
php -S 127.0.0.1:8000 -t public
```

Acesse:

```text
http://127.0.0.1:8000
```

Se usar outra porta, atualize `APP_URL` no `.env`.

## Produção

URL configurada para produção:

```env
APP_URL=https://sgi.tiuai.com.br
APP_ENV=production
APP_DEBUG=false
```

No servidor, a raiz pública do domínio deve apontar para a pasta `public`.

### Produção na Hostinger

Se a hospedagem compartilhada não permitir apontar o domínio para a pasta `public`, use o projeto na raiz do domínio ou em `public_html`.

Este projeto já está preparado para esse cenário:

- `index.php` principal na raiz do projeto
- `.htaccess` na raiz com rewrite para o sistema
- bloqueio de acesso direto a `app`, `config`, `database`, `routes`, `storage`, `vendor` e `views`
- assets públicos em `/assets`
- storage protegido, com anexos servidos apenas pelo controller

Na Hostinger, envie a estrutura do projeto para a pasta do domínio, mantendo o arquivo `.env` na raiz. Depois rode:

```bash
composer install --no-dev --optimize-autoloader
php database/migrate.php
```

O domínio de produção configurado é:

```text
https://sgi.tiuai.com.br
```

## Estrutura

```text
/app
  /Controllers
  /Core
  /Helpers
  /Middlewares
  /Models
  /Services
/config
/database
  /migrations
/public
  /assets
/routes
/storage
  /logs
  /uploads
/views
```

## Módulos

- Dashboard com cards, indicadores e gráficos
- Usuários com perfis, status e permissões
- Departamentos
- Melhorias com status, prioridade, prazo, causa raiz e ganho estimado
- Reuniões
- PDCA vinculado à melhoria
- SWOT vinculado à melhoria
- 5W2H vinculado à melhoria
- Comentários e histórico
- Anexos em `storage/uploads`
- Notificações internas
- Relatórios PDF e CSV/Excel
- Logs de auditoria
- Analista de Melhoria Contínua

## Agente de IA

Configure no `.env` quando tiver uma API disponível:

```env
AI_API_KEY=sua_chave
AI_API_URL=https://sua-api.exemplo
```

Sem essas variáveis, o sistema usa respostas locais simuladas para estruturar PDCA, SWOT, 5W2H, causa raiz e próximos passos.

## Segurança

- Senhas com `password_hash`
- Login com `password_verify`
- PDO com prepared statements
- Middlewares de autenticação e perfis
- CSRF em formulários
- Escape HTML nas views
- Sessões HTTP-only com SameSite
- Validação de upload por extensão, tamanho e MIME
- Logs de auditoria para ações importantes

## Criar Nova Migration

Crie um arquivo em `database/migrations`, por exemplo:

```php
<?php

class CreateNovaTabela
{
    public function up(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE exemplo (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY)');
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS exemplo');
    }
}

return CreateNovaTabela::class;
```

Depois execute:

```bash
php database/migrate.php
```
