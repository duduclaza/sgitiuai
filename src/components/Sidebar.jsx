import React from 'react';
import { Menu, X, LogOut, Bell } from 'lucide-react';
import { useState } from 'react';
import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';

const Sidebar = ({ isOpen, setIsOpen }) => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const menuItems = [
    { label: 'Dashboard', url: '/dashboard', icon: '📊', show: true },
    { label: 'Usuários', url: '/usuarios', icon: '👥', show: user?.perfil === 'super_admin' },
    { label: 'Departamentos', url: '/departamentos', icon: '🏢', show: user?.perfil === 'admin' },
    { label: 'Melhorias', url: '/melhorias', icon: '✨', show: ['admin', 'usuario'].includes(user?.perfil) },
    { label: 'Reuniões', url: '/reunioes', icon: '📅', show: user?.perfil === 'admin' },
    { label: 'PDCA', url: '/pdca', icon: '🔄', show: user?.perfil === 'admin' },
    { label: 'SWOT', url: '/swot', icon: '📊', show: user?.perfil === 'admin' },
    { label: '5W2H', url: '/5w2h', icon: '✓', show: user?.perfil === 'admin' },
    { label: 'Relatórios', url: '/relatorios', icon: '📈', show: ['admin', 'usuario'].includes(user?.perfil) },
    { label: 'Logs', url: '/logs-auditoria', icon: '🔐', show: user?.perfil === 'super_admin' },
  ];

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  return (
    <>
      {/* Overlay */}
      {isOpen && (
        <div 
          className="fixed inset-0 z-30 bg-slate-950/30 backdrop-blur-sm lg:hidden"
          onClick={() => setIsOpen(false)}
        />
      )}

      {/* Sidebar */}
      <aside className={`
        fixed inset-y-0 left-0 z-40 flex flex-col border-r border-slate-800 
        bg-gradient-to-b from-slate-900 to-slate-800 p-4 shadow-xl 
        transition-transform duration-300 w-64
        ${isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'}
      `}>
        {/* Header */}
        <div className="flex items-center justify-between gap-3">
          <a href="/dashboard" className="flex items-center gap-3">
            <div className="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 text-sm font-black text-white shadow-lg">
              SGI
            </div>
            <div className="min-w-0">
              <span className="block truncate text-sm font-black text-white">SGI TI UAI</span>
              <span className="block text-xs text-slate-400">Melhoria Contínua</span>
            </div>
          </a>
          <button 
            onClick={() => setIsOpen(false)}
            className="grid h-10 w-10 place-items-center rounded-lg border border-slate-700 text-slate-400 hover:bg-slate-700/50 lg:hidden"
          >
            <X size={20} />
          </button>
        </div>

        {/* Navigation */}
        <nav className="mt-8 flex-1 space-y-1">
          <p className="px-3 text-xs font-bold uppercase text-slate-500">Módulos</p>
          <div className="mt-3 space-y-1">
            {menuItems.map((item, idx) => 
              item.show ? (
                <a
                  key={idx}
                  href={item.url}
                  className="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-bold text-slate-300 transition hover:bg-slate-700/50 hover:text-white"
                >
                  <span>{item.icon}</span>
                  <span className="truncate">{item.label}</span>
                </a>
              ) : null
            )}
          </div>
        </nav>

        {/* User Info */}
        <div className="rounded-xl bg-slate-700/30 p-3 border border-slate-700">
          <p className="text-xs font-bold uppercase text-slate-500">Sessão</p>
          <p className="mt-1 truncate text-sm font-black text-white">{user?.nome}</p>
          <p className="truncate text-xs text-slate-400 capitalize">{user?.perfil}</p>
        </div>

        {/* Logout */}
        <button
          onClick={handleLogout}
          className="mt-4 flex w-full items-center justify-center gap-2 rounded-lg bg-red-600/10 px-3 py-2.5 font-bold text-red-400 transition hover:bg-red-600/20"
        >
          <LogOut size={18} />
          <span>Sair</span>
        </button>
      </aside>
    </>
  );
};

export default Sidebar;
