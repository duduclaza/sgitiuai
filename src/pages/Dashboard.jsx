import React from 'react';
import Layout from '../components/Layout';
import { TrendingUp, AlertCircle, CheckCircle } from 'lucide-react';

const Dashboard = () => {
  const stats = [
    { label: 'Total de Melhorias', value: '24', icon: TrendingUp, color: 'bg-blue-600' },
    { label: 'Em Análise', value: '8', icon: AlertCircle, color: 'bg-yellow-600' },
    { label: 'Concluídas', value: '12', icon: CheckCircle, color: 'bg-emerald-600' },
  ];

  return (
    <Layout title="Dashboard">
      <div className="space-y-6">
        {/* Stats */}
        <div className="grid gap-4 md:grid-cols-3">
          {stats.map((stat, idx) => (
            <div key={idx} className="rounded-lg bg-white p-6 shadow-sm border border-slate-200">
              <div className="flex items-start justify-between">
                <div>
                  <p className="text-sm text-slate-500">{stat.label}</p>
                  <p className="mt-2 text-3xl font-black text-slate-900">{stat.value}</p>
                </div>
                <div className={`grid h-12 w-12 place-items-center rounded-lg ${stat.color} text-white`}>
                  <stat.icon size={24} />
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Welcome Message */}
        <div className="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 p-8 text-white shadow-lg">
          <h2 className="text-2xl font-black">Bem-vindo ao SGI TI UAI</h2>
          <p className="mt-2 text-blue-100">
            Sistema de Gestão de Melhorias Contínuas. Aqui você pode registrar, acompanhar e analisar todas as melhorias sugeridas.
          </p>
        </div>

        {/* Coming Soon */}
        <div className="rounded-lg bg-white p-6 shadow-sm border border-slate-200">
          <h3 className="text-lg font-bold text-slate-900">Próximas Melhorias</h3>
          <p className="mt-2 text-slate-600">
            Em breve você verá aqui as melhorias mais recentes, análises e relatórios.
          </p>
        </div>
      </div>
    </Layout>
  );
};

export default Dashboard;
