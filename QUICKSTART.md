# 🚀 Guia Rápido - SGI TI UAI

## Instalação & Setup Inicial

### Pré-requisitos
- Node.js 16+ e npm
- PHP 8.0+
- Composer
- MySQL 5.7+

### 1️⃣ Clone e Configure

```bash
cd sgiiduai
npm install
composer install
cp .env.example .env
```

### 2️⃣ Configure o banco de dados

```bash
# .env
DB_HOST=localhost
DB_DATABASE=sgiuai
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

```bash
# Rodar migrations
php database/migrate.php
```

---

## 💻 Desenvolvimento Local

### Terminal 1 - Frontend React (Vite)

```bash
npm run dev
```

Acesse: **http://localhost:5173**

### Terminal 2 - Backend PHP

```bash
php -S localhost:8000 public/index.php
```

API disponível em: **http://localhost:8000/api**

---

## 🎯 Build para Produção

### 1. Build do React
```bash
npm run build
```

Isso gera a pasta `dist/` com os arquivos prontos.

### 2. Servir localmente (testar build)

```bash
php server.php -S localhost:8000
```

Acesse: **http://localhost:8000**

---

## 📦 Estrutura Final de Produção

```
/var/www/sgiiduai/
├── app/              # Backend PHP
├── dist/             # Frontend React (do build)
├── routes/
├── vendor/
├── public/
├── index.html        # React entry point
├── .env              # Variáveis de ambiente
└── server.php        # Roteador combinado
```

---

## 🔐 Credenciais de Teste

Default Super Admin (do .env):
- **Email**: du.claza@gmail.com
- **Senha**: Pipoca@123

---

## 📱 Páginas Principais

### Públicas
- `/melhoria-publica` - Formulário para enviar melhorias
- `/login` - Login do sistema

### Autenticadas
- `/dashboard` - Painel principal
- `/melhorias` - Gestão de melhorias
- `/usuarios` - Gestão de usuários (admin)
- `/departamentos` - Departamentos (admin)
- E mais...

---

## 🎨 Customizações de Design

### Cores
- Editar em `src/styles/global.css`
- Tailwind config em `tailwind.config.js`

### Sidebar
- Componente: `src/components/Sidebar.jsx`
- Cores: `from-slate-900 to-slate-800` (azul escuro)

### Login
- Página: `src/pages/Login.jsx`
- Design sóbrio com gradiente

---

## 🐛 Troubleshooting

| Problema | Solução |
|----------|---------|
| Porta 5173 já em uso | Mudar: `npm run dev -- --port 3000` |
| Conexão recusada na API | Verificar: `php -S localhost:8000` rodando |
| Node modules corrompido | `rm -rf node_modules && npm install` |
| Sessão não persiste | Verificar cookies em DevTools (F12) |

---

## 📚 Links Úteis

- [Documentação Vite](https://vitejs.dev)
- [React Docs](https://react.dev)
- [Tailwind CSS](https://tailwindcss.com)
- [Lucide Icons](https://lucide.dev)

---

✅ **Pronto!** Sua aplicação está configurada e pronta para desenvolvimento.
