# 📋 Changelog - Migração React + Vite

## v2.0.0 - React Migration (2026-05-05)

### ✨ Novas Funcionalidades

#### Frontend
- ✅ **React 18** como framework principal
- ✅ **Vite** como bundler (substituiu HTML direto)
- ✅ **React Router** para navegação SPA
- ✅ **Tailwind CSS** para estilos
- ✅ **Lucide React** para ícones
- ✅ **Axios** para requisições HTTP
- ✅ **Contexto de Autenticação** com React Context API

#### Design & UX
- 🎨 **Sidebar**: Azul escuro gradiente (slate-900 → slate-800)
- 🎨 **Layout**: Bege claro (slate-50) no fundo
- 🎨 **Login**: Design sóbrio com fundo em gradiente
  - Apenas campos: Email, Senha, Olho da senha, Botão Entrar
  - Centralizado com nome "SGI TI UAI"
  - Sem elementos distraentes
- 🎨 **Formulário Público**: Completamente redesenhado
  - Formulário mais bonito e intuitivo
  - QR code REMOVIDO (apenas admin verá em dashboard)
  - Tabs: "Enviar Melhoria" | "Pesquisar Ticket"
  - Design responsivo

#### Backend (API)
- 📡 `ApiAuthController` - Endpoints de autenticação
  - `POST /api/auth/login` - Autenticação
  - `POST /api/auth/logout` - Logout
  - `GET /api/auth/me` - Dados do usuário
- 📡 `ApiPublicController` - Endpoints públicos
  - `GET /api/public/departments` - Lista departamentos
  - `POST /api/public/melhorias` - Registrar melhoria
  - `POST /api/public/melhorias/consultar` - Pesquisar ticket
- 🔒 `CorsMiddleware` - Tratamento de CORS

#### Estrutura
- ✅ Reorganização completa de pastas
- ✅ Separação clara Frontend/Backend
- ✅ Componentes React reutilizáveis
- ✅ Serviços centralizados
- ✅ Contextos compartilhados

### 🔧 Configurações

#### Vite
- Build output: `dist/` (na raiz do projeto)
- Dev server: `localhost:5173`
- Proxy API: `/api` → `localhost:8000`
- Tailwind CSS integrado

#### PHP
- Suporte a API JSON
- Sessões PHP funcionando com React
- Middleware CORS configurado
- Roteador preparado para servir ambos (SPA + API)

### 📁 Arquivos Novos

```
src/                          # Frontend React
├── components/
│   ├── Layout.jsx
│   ├── Sidebar.jsx
│   └── ProtectedRoute.jsx
├── pages/
│   ├── Login.jsx
│   ├── Dashboard.jsx
│   └── PublicForm.jsx
├── context/
│   └── AuthContext.jsx
├── services/
│   └── api.js
├── styles/
│   └── global.css
├── App.jsx
└── main.jsx

app/Controllers/
├── ApiAuthController.php
├── ApiPublicController.php
└── CorsMiddleware.php

dist/                         # Build do React
└── .htaccess

Configuração:
├── vite.config.js
├── tailwind.config.js
├── postcss.config.js
├── tsconfig.json
├── tsconfig.node.json
└── package.json

Documentação:
├── QUICKSTART.md
├── DEPLOY.md
├── README_REACT.md
└── server.php
```

### 🔄 Modificações em Arquivos Existentes

#### `routes/web.php`
- Adicionadas rotas API com prefixo `/api`
- Rotas legadas mantidas para compatibilidade

#### `public/index.php`
- Integrado `CorsMiddleware`
- Suporte a requisições JSON

#### `.env`
- Adicionadas variáveis para React
- Mantidas compatibilidades PHP

### 🚀 Como Usar

#### Desenvolvimento
```bash
# Terminal 1 - React
npm install
npm run dev          # http://localhost:5173

# Terminal 2 - PHP
php -S localhost:8000  # http://localhost:8000
```

#### Produção
```bash
# Build
npm run build

# Deploy
# Copiar dist/ para web server
# Servir com Apache/Nginx/PHP Server
```

### 🔐 Autenticação

#### Fluxo
1. Usuário acessa `/login` (React)
2. Submete credenciais via `POST /api/auth/login`
3. PHP valida e cria sessão
4. React armazena dados em Context
5. Requisições subsequentes carregam user automaticamente
6. SessionCookies mantêm autenticação entre abas

### ✅ Testes Realizados

- [x] Estrutura React compilada com Vite
- [x] Roteamento com React Router
- [x] Autenticação com Context API
- [x] Comunicação PHP ↔ React via API JSON
- [x] Sessões PHP funcionando
- [x] Design responsivo
- [x] Build production gerado
- [x] CORS configurado

### 📝 Notas Importantes

1. **Dist na Raiz**: `npm run build` gera `dist/` que deve estar na raiz
2. **React Router**: Requer `.htaccess` ou configuração do servidor para funcionar
3. **Sessões PHP**: Funcionam normalmente, cookies com `httpOnly` por segurança
4. **CORS**: Configurado para localhost em dev, produção em `.env`
5. **QR Code**: Removido do formulário público, será adicionado em dashboard admin

### 🔜 Próximos Passos

- [ ] Implementar páginas protegidas (Melhorias, Dashboard, etc)
- [ ] Dashboard com gráficos e estatísticas
- [ ] Gestão de usuários/departamentos
- [ ] Sistema de notificações
- [ ] Testes automatizados
- [ ] CI/CD pipeline

### 📞 Suporte

Para dúvidas sobre a migração ou configuração, consulte:
- [QUICKSTART.md](QUICKSTART.md) - Início rápido
- [DEPLOY.md](DEPLOY.md) - Deploy em produção
- [README_REACT.md](README_REACT.md) - Documentação técnica

---

**Versão anterior**: v1.0.0 (PHP Blade Templates)
**Versão atual**: v2.0.0 (React + Vite)
**Data**: 2026-05-05
