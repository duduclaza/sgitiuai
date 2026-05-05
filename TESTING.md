# 🧪 Guia de Teste - SGI TI UAI React

Siga este guia para validar que a migração React + Vite funcionou corretamente.

---

## ✅ Checklist de Instalação

- [ ] Node.js 16+ instalado (`node -v`)
- [ ] npm instalado (`npm -v`)
- [ ] PHP 8+ instalado (`php -v`)
- [ ] Composer instalado (`composer -v`)
- [ ] MySQL/MariaDB rodando

---

## 🚀 Teste 1: Setup Inicial

```bash
cd sgiiduai
npm install
composer install
cp .env.example .env
```

### Validar
- ✅ Sem erros na instalação
- ✅ Pasta `node_modules/` criada
- ✅ Pasta `vendor/` criada

---

## 🚀 Teste 2: Ambiente de Desenvolvimento

### Terminal 1: React Dev Server

```bash
npm run dev
```

#### Validar
- ✅ Mensagem: "Local: http://localhost:5173"
- ✅ Acesse http://localhost:5173
- ✅ Página de login carrega
- ✅ Design sóbrio e centralizado com "SGI TI UAI"

### Terminal 2: PHP API Server

```bash
php -S localhost:8000 public/index.php
```

#### Validar
- ✅ Mensagem: "Listening on http://localhost:8000"
- ✅ `curl http://localhost:8000/api/auth/me` retorna JSON com erro 401 (esperado)

---

## 🚀 Teste 3: Autenticação

### Teste de Login Inválido

1. Acesse http://localhost:5173
2. Tente login com email/senha inválidos
3. #### Validar
   - ✅ Mensagem de erro aparece
   - ✅ Sem erro no console (F12)
   - ✅ Permanece na página de login

### Teste de Login Válido

1. Acesse http://localhost:5173
2. Login com credenciais do `.env`:
   - Email: du.claza@gmail.com (ou admin do BD)
   - Senha: Pipoca@123 (ou senha do BD)

#### Validar
- ✅ Redireciona para `/dashboard`
- ✅ Sidebar com nome de usuário aparece
- ✅ Menu com módulos carrega
- ✅ Botão "Sair" funciona

---

## 🚀 Teste 4: Design & Layout

### Sidebar
- ✅ Cor azul escuro (slate-900 → slate-800)
- ✅ Logo "SGI" redondo no topo
- ✅ Nome "SGI TI UAI" com subtítulo
- ✅ Menu com ícones e labels
- ✅ Sessão do usuário no rodapé
- ✅ Botão sair em vermelho
- ✅ Responsivo (colapsa em mobile)

### Login
- ✅ Centralizado na tela
- ✅ Design sóbrio com fundo em gradiente escuro
- ✅ Logo quadrado com "SGI" em azul
- ✅ Apenas 3 campos: Email, Senha, Botão Entrar
- ✅ Olho da senha funciona (mostra/esconde)
- ✅ Sem elementos distraentes

### Dashboard
- ✅ Cards com estatísticas
- ✅ Header com título
- ✅ Menu lateral à esquerda
- ✅ Fundo bege claro (slate-50)
- ✅ Tipografia legível

---

## 🚀 Teste 5: Formulário Público

### Acessar Formulário Público

1. Em outra aba, acesse: http://localhost:5173/melhoria-publica
2. #### Validar
   - ✅ Carrega sem autenticação
   - ✅ Design bonito e responsivo
   - ✅ Fundo em gradiente escuro
   - ✅ Logo "SGI" no topo

### Tabs do Formulário

1. Clique em "Enviar Melhoria"
   - ✅ Mostra formulário
   - ✅ Campos: Título, Nome, Departamento, Prioridade
   - ✅ Textareas para descrição

2. Clique em "Pesquisar Ticket"
   - ✅ Mostra campo de pesquisa
   - ✅ Placeholder com formato "MEL-2026-000001"

### Validar
- ✅ **Sem QR code** (correto! Será apenas para admin)
- ✅ Formulário responsivo
- ✅ Inputs com estilo bonito

---

## 🚀 Teste 6: Responsividade

### Desktop (1920x1080)
- ✅ Sidebar visível
- ✅ Conteúdo bem distribuído
- ✅ Texto legível

### Tablet (768x1024)
- ✅ Sidebar pode ficar oculta
- ✅ Botão hamburger aparece
- ✅ Conteúdo adaptado

### Mobile (375x667)
- ✅ Sidebar colapsível
- ✅ Menu acessível
- ✅ Toque funciona
- ✅ Sem overflow horizontal

---

## 🚀 Teste 7: Build para Produção

### Build do React

```bash
npm run build
```

#### Validar
- ✅ Sem erros
- ✅ Pasta `dist/` criada
- ✅ Arquivos em `dist/js/`, `dist/assets/`
- ✅ `dist/index.html` existe

### Servir Build Localmente

```bash
php server.php -S localhost:8000
```

#### Validar
- ✅ Acesse http://localhost:8000
- ✅ Carrega a página (sem React Dev Server)
- ✅ Login funciona
- ✅ Dashboard carrega após login

---

## 🚀 Teste 8: API Endpoints

### GET /api/auth/me

```bash
curl -b "PHPSESSID=seu_session_id" http://localhost:8000/api/auth/me
```

#### Esperado
```json
{
  "data": {
    "id": 1,
    "nome": "Super Admin",
    "email": "admin@example.com",
    "perfil": "super_admin",
    "status": "ativo"
  }
}
```

### POST /api/auth/login

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"senha"}'
```

#### Esperado (sucesso)
```json
{
  "data": {
    "id": 1,
    "nome": "Super Admin",
    "email": "admin@example.com",
    "perfil": "super_admin",
    "status": "ativo"
  }
}
```

### GET /api/public/departments

```bash
curl http://localhost:8000/api/public/departments
```

#### Esperado
```json
{
  "data": [
    {"id": 1, "nome": "TI", ...},
    {"id": 2, "nome": "RH", ...}
  ]
}
```

---

## 🐛 Troubleshooting

| Problema | Solução |
|----------|---------|
| "Cannot find module 'react'" | `npm install` |
| Porta 5173 já em uso | `npm run dev -- --port 3000` |
| Erro ao conectar API | Verificar se `php -S localhost:8000` está rodando |
| Sessão não persiste | Verificar cookies em DevTools → Application |
| Login não funciona | Verificar credenciais no BD |
| Build falha | `rm -rf dist && npm run build` |

---

## 📊 Performance

Usar DevTools (F12) para verificar:

- **Network**: Arquivos CSS/JS carregam rápido
- **Console**: Sem erros ou warnings
- **Application**: Cookies de sessão presentes

---

## ✅ Conclusão

Se todos os testes acima passaram, a migração foi bem-sucedida! 🎉

Próximos passos:
1. Implementar páginas protegidas
2. Conectar formulário público à API
3. Criar dashboard com dados reais
4. Deploy em produção

---

📝 **Data**: 2026-05-05
📧 **Contato**: Suporte TI UAI
