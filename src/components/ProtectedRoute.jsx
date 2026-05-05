import React from 'react';
import { useAuth } from '../context/AuthContext';
import { Navigate } from 'react-router-dom';

const ProtectedRoute = ({ component: Component, requiredRole = null, ...rest }) => {
  const { isAuthenticated, user, isLoading } = useAuth();

  if (isLoading) {
    return (
      <div className="flex h-screen w-full items-center justify-center bg-slate-100 font-mono">
        <div className="flex items-center gap-3 border-l-4 border-slate-800 bg-white px-6 py-4 shadow-sm">
          <div className="h-4 w-4 animate-spin border-2 border-slate-800 border-t-transparent"></div>
          <span className="text-xs font-semibold uppercase tracking-widest text-slate-800">Carregando sistema...</span>
        </div>
      </div>
    );
  }

  if (!isAuthenticated) {
    return <Navigate to="/login" replace />;
  }

  if (requiredRole && user?.perfil !== requiredRole) {
    return <Navigate to="/dashboard" replace />;
  }

  return <Component {...rest} />;
};

export default ProtectedRoute;
