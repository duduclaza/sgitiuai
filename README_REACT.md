# SGI TI UAI - Sistema de Gestão de Melhorias Contínuas

Um sistema moderno de gestão de melhorias contínuas com interface React e backend PHP.

## 🏗️ Arquitetura

```
┌─────────────────────────────────────────────────┐
│                  React Frontend                  │
│  (Vite + React + Tailwind + React Router)       │
└────────────────┬────────────────────────────────┘
                 │ API Calls (JSON)
                 ↓
┌─────────────────────────────────────────────────┐
│                  PHP Backend                     │
│  (Controllers + Models + Router + Database)      │
└──────────────────────────────────────────────────┘
```

## 🚀 Quick Start

### Desenvolvimento

```bash
# 1. Instalar dependências
npm install
composer install

# 2. Terminal 1 - React Dev Server
npm run dev
# http://localhost:5173

# 3. Terminal 2 - PHP Built-in Server
php -S localhost:8000

# 4. Acessar
# http://localhost:5173
```

### Produção

```bash
# Build do React
npm run build

# Servir com PHP
php -S 0.0.0.0:8000

# Ou usar Apache/Nginx (veja DEPLOY.md)
```

## 📁 Estrutura do Projeto

```
sgiiduai/
├── src/                          # Frontend React
│   ├── components/               # Componentes React
│   │   ├── Layout.jsx           # Layout principal
│   │   ├── Sidebar.jsx          # Menu lateral
│   │   └── ProtectedRoute.jsx   # Proteção de rotas
│   ├── pages/                   # Páginas da aplicação
│   │   ├── Login.jsx            # Página de login
│   │   ├── Dashboard.jsx        # Dashboard
│   │   └── PublicForm.jsx       # Formulário público
│   ├── context/                 # Contextos React
│   │   └── AuthContext.jsx      # Autenticação
│   ├── services/                # Serviços
│   │   └── api.js              # Cliente Axios
│   ├── styles/                  # Estilos CSS
│   │   └── global.css          # CSS global
│   ├── App.jsx                  # Componente raiz
│   └── main.jsx                 # Ponto de entrada
│
├── app/                          # Backend PHP
│   ├── Controllers/             # Controllers
│   │   ├── ApiAuthController.php
│   │   ├── ApiPublicController.php
│   │   └── ...outros controllers
│   ├── Models/                  # Models
│   ├── Core/                    # Classes core
│   ├── Middlewares/             # Middlewares
│   └── Services/                # Serviços PHP
│
├── routes/                       # Definição de rotas
│   └── web.php                  # Todas as rotas (API + Legacy)
│
├── database/                     # Migrations
│
├── dist/                         # Build do React (gerado)
│   ├── index.html               # HTML principal
│   ├── js/                      # JavaScript bundled
│   ├── assets/                  # Imagens, fonts, etc
│   └── .htaccess                # Rewrite rules (Apache)
│
├── package.json                 # Dependências Node
├── vite.config.js               # Configuração Vite
├── tailwind.config.js           # Tailwind CSS
├── composer.json                # Dependências PHP
├── .env                         # Variáveis de ambiente
└── DEPLOY.md                    # Instruções de deploy
```

## 🎨 Design & Cores

- **Sidebar**: Azul escuro gradiente (slate-900 → slate-800)
- **Fundo Principal**: Bege claro (slate-50)
- **Primária**: Azul (#3b82f6)
- **Login**: Design sóbrio com fundo em gradiente escuro

## 🔐 Autenticação

- Tipo: **Session-based** (PHP Sessions + Cookies)
- Fluxo:
  1. React envia `POST /api/auth/login` com email/password
  2. PHP verifica credenciais e cria sessão
  3. React armazena user context
  4. Requisições subsequentes carregam user automaticamente

## 📡 API Endpoints

### Autenticação
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout
- `GET /api/auth/me` - Dados do usuário logado

### Públicos
- `GET /api/public/departments` - Lista departamentos
- `POST /api/public/melhorias` - Registrar melhoria
- `POST /api/public/melhorias/consultar` - Consultar ticket

## 🛠️ Ferramentas & Tecnologias

### Frontend
- **React 18** - UI library
- **Vite** - Build tool
- **React Router** - Roteamento
- **Tailwind CSS** - Estilos
- **Axios** - HTTP client
- **Lucide React** - Ícones

### Backend
- **PHP 8+** - Server-side
- **MySQL** - Database
- **Composer** - Package manager

## 📝 Notas Importantes

### Frontend (React)

1. **Autenticação com PHP Sessions**
   - As sessões são mantidas via cookies
   - `withCredentials: true` nas requisições Axios
   - URL da API deve apontar para o mesmo domínio em produção

2. **Formulário Público**
   - ✅ Sem QR code (apenas admin vê em dashboard)
   - ✅ Design melhorado e responsivo
   - ✅ Tabs para enviar/pesquisar

3. **Build para Produção**
   - `npm run build` cria arquivos em `dist/`
   - `dist/` deve estar na raiz do web server
   - Apache `.htaccess` redireciona rotas para `index.html`

### Backend (PHP)

1. **Rotas API**
   - Prefixadas com `/api`
   - Retornam JSON
   - Suportam sessões PHP

2. **Middlewares**
   - `auth` - Requer autenticação
   - `role:*` - Verifica papel do usuário

## 🔄 Fluxo de Desenvolvimento

### Para adicionar nova página:

1. Criar componente em `src/pages/`
2. Adicionar rota em `src/App.jsx`
3. Usar `<Layout>` para envolver o conteúdo
4. Fazer requisições via `api.js`

### Para adicionar novo endpoint API:

1. Criar Controller em `app/Controllers/Api*.php`
2. Adicionar rotas em `routes/web.php` com prefixo `/api`
3. Retornar JSON via `$this->json()`
4. Chamar do React com `axios.get('/api/...')`

## 📚 Documentação

- [DEPLOY.md](DEPLOY.md) - Instruções detalhadas de deploy
- [src/README.md](src/README.md) - Documentação do frontend

## ⚙️ Configuração de Ambiente

Criar arquivo `.env`:

```env
APP_NAME="Sistema de Melhoria Contínua"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sgiuai
DB_USERNAME=root
DB_PASSWORD=

SESSION_NAME=sgi_session
```

## 🐛 Troubleshooting

**React não carrega após build**
- Verificar se `dist/` tem `.htaccess`
- Confirmar que Apache tem `mod_rewrite` ativado
- Testar em `http://localhost:5173` se estiver em dev

**API retorna 401 Unauthorized**
- Verificar se está logado (`/api/auth/me`)
- Confirmar que cookies estão sendo enviados (`withCredentials`)
- Verificar sessão PHP em `php -r "print_r($_SESSION);"`

**CORS errors**
- Em desenvolvimento: Vite proxy está configurado
- Em produção: Use mesmo domínio ou configure CORS headers

## 📞 Contato & Suporte

Sistema desenvolvido para TI UAI com suporte contínuo.

---

**Última atualização**: 2026-05-05
