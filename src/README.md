# SGI TI UAI - Frontend React + Vite

## Instalação

```bash
npm install
```

## Desenvolvimento

```bash
npm run dev
```

A aplicação estará disponível em `http://localhost:5173`

## Build

```bash
npm run build
```

A distribuição será criada em `dist/`

## Estrutura do Projeto

```
src/
├── components/       # Componentes React reutilizáveis
├── pages/           # Páginas da aplicação
├── services/        # Serviços de API
├── context/         # Contextos React (autenticação, etc)
├── hooks/           # Custom hooks
├── styles/          # Estilos globais e CSS
├── App.jsx          # Componente raiz
└── main.jsx         # Ponto de entrada
```

## Configuração de Cores

- **Sidebar**: Azul escuro (from-slate-900 to-slate-800)
- **Fundo Principal**: Bege claro
- **Primária**: Azul (#3b82f6)
- **Login**: Design sóbrio com fundo em gradiente

## Recursos

- ✅ Autenticação com sessões PHP
- ✅ Layout responsivo
- ✅ Roteamento com React Router
- ✅ Requisições HTTP com Axios
- ✅ Tailwind CSS para estilização
- ✅ Ícones Lucide React
