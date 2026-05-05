import React, { useState } from 'react';
import { Eye, EyeOff, Send, Search } from 'lucide-react';

const PublicForm = () => {
  const [activeTab, setActiveTab] = useState('form');
  const [formData, setFormData] = useState({
    titulo: '',
    departamento_id: '',
    responsavel_nome: '',
    prioridade: 'Média',
    descricao_problema: '',
    melhoria_sugerida: '',
    causa_raiz: '',
    observacoes: ''
  });
  const [searchTicket, setSearchTicket] = useState('');
  const [isLoading, setIsLoading] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsLoading(true);
    try {
      // API call will be implemented
      console.log('Form submitted:', formData);
    } finally {
      setIsLoading(false);
    }
  };

  const handleSearch = async (e) => {
    e.preventDefault();
    setIsLoading(true);
    try {
      // API call will be implemented
      console.log('Searching for:', searchTicket);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 px-4 py-8">
      {/* Background decoration */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <div className="absolute top-1/4 -right-96 h-96 w-96 rounded-full bg-blue-600/5 blur-3xl"></div>
        <div className="absolute bottom-1/4 -left-96 h-96 w-96 rounded-full bg-blue-600/5 blur-3xl"></div>
      </div>

      <div className="relative mx-auto max-w-4xl">
        {/* Header */}
        <div className="mb-8 text-center">
          <div className="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 text-2xl font-black text-white shadow-lg">
            SGI
          </div>
          <h1 className="text-4xl font-black text-white">SGI TI UAI</h1>
          <p className="mt-2 text-lg text-slate-300">Registre suas sugestões de melhoria</p>
        </div>

        {/* Main Card */}
        <div className="rounded-2xl bg-white/10 p-8 shadow-2xl backdrop-blur-2xl border border-white/20">
          {/* Tabs */}
          <div className="mb-8 grid grid-cols-2 gap-3 rounded-lg bg-white/5 p-1 border border-white/10">
            <button
              onClick={() => setActiveTab('form')}
              className={`rounded-lg px-4 py-3 font-bold transition ${
                activeTab === 'form'
                  ? 'bg-blue-600 text-white shadow-lg'
                  : 'text-slate-300 hover:text-white'
              }`}
            >
              <Send size={18} className="mb-1 inline mr-2" />
              Enviar Melhoria
            </button>
            <button
              onClick={() => setActiveTab('search')}
              className={`rounded-lg px-4 py-3 font-bold transition ${
                activeTab === 'search'
                  ? 'bg-blue-600 text-white shadow-lg'
                  : 'text-slate-300 hover:text-white'
              }`}
            >
              <Search size={18} className="mb-1 inline mr-2" />
              Pesquisar Ticket
            </button>
          </div>

          {/* Form Tab */}
          {activeTab === 'form' && (
            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid gap-5 lg:grid-cols-2">
                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Título *
                  </label>
                  <input
                    type="text"
                    name="titulo"
                    value={formData.titulo}
                    onChange={handleChange}
                    required
                    placeholder="Ex.: Melhorar conferência de pedidos"
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                  />
                </div>

                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Seu Nome *
                  </label>
                  <input
                    type="text"
                    name="responsavel_nome"
                    value={formData.responsavel_nome}
                    onChange={handleChange}
                    required
                    placeholder="Seu nome completo"
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                  />
                </div>

                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Departamento
                  </label>
                  <select
                    name="departamento_id"
                    value={formData.departamento_id}
                    onChange={handleChange}
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                  >
                    <option value="">Selecione um departamento</option>
                    <option value="1">Departamento 1</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Prioridade
                  </label>
                  <select
                    name="prioridade"
                    value={formData.prioridade}
                    onChange={handleChange}
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                  >
                    <option value="Baixa">Baixa</option>
                    <option value="Média">Média</option>
                    <option value="Alta">Alta</option>
                    <option value="Crítica">Crítica</option>
                  </select>
                </div>
              </div>

              <div className="grid gap-5 lg:grid-cols-2">
                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Descrição do Problema *
                  </label>
                  <textarea
                    name="descricao_problema"
                    value={formData.descricao_problema}
                    onChange={handleChange}
                    required
                    placeholder="O que está acontecendo e qual o impacto?"
                    rows="5"
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20 resize-none"
                  />
                </div>

                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Melhoria Sugerida
                  </label>
                  <textarea
                    name="melhoria_sugerida"
                    value={formData.melhoria_sugerida}
                    onChange={handleChange}
                    placeholder="Qual mudança você sugere?"
                    rows="5"
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20 resize-none"
                  />
                </div>
              </div>

              <div className="grid gap-5 lg:grid-cols-2">
                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Causa Raiz
                  </label>
                  <textarea
                    name="causa_raiz"
                    value={formData.causa_raiz}
                    onChange={handleChange}
                    placeholder="Se souber, descreva a possível causa"
                    rows="3"
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20 resize-none"
                  />
                </div>

                <div>
                  <label className="block text-sm font-bold text-slate-200 mb-2">
                    Observações
                  </label>
                  <textarea
                    name="observacoes"
                    value={formData.observacoes}
                    onChange={handleChange}
                    placeholder="Inclua detalhes que ajudem na análise"
                    rows="3"
                    className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20 resize-none"
                  />
                </div>
              </div>

              <button
                type="submit"
                disabled={isLoading}
                className="w-full flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3 font-bold text-white transition hover:from-blue-600 hover:to-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <Send size={20} />
                {isLoading ? 'Enviando...' : 'Enviar Melhoria'}
              </button>
            </form>
          )}

          {/* Search Tab */}
          {activeTab === 'search' && (
            <form onSubmit={handleSearch} className="space-y-6">
              <div>
                <label className="block text-sm font-bold text-slate-200 mb-2">
                  Número do Ticket *
                </label>
                <input
                  type="text"
                  value={searchTicket}
                  onChange={(e) => setSearchTicket(e.target.value.toUpperCase())}
                  placeholder="MEL-2026-000001"
                  required
                  className="w-full rounded-lg bg-white/10 border border-white/20 px-4 py-3 text-white placeholder-slate-400 transition focus:border-blue-400/50 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500/20 font-mono"
                />
              </div>

              <button
                type="submit"
                disabled={isLoading}
                className="w-full flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3 font-bold text-white transition hover:from-blue-600 hover:to-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <Search size={20} />
                {isLoading ? 'Pesquisando...' : 'Pesquisar'}
              </button>
            </form>
          )}
        </div>

        {/* Footer */}
        <p className="mt-8 text-center text-sm text-slate-400">
          Ambiente seguro. Seus dados são protegidos.
        </p>
      </div>
    </div>
  );
};

export default PublicForm;
