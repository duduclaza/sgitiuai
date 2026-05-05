import React, { createContext, useState, useEffect, useCallback } from 'react';
import axios from 'axios';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [errors, setErrors] = useState({});

  // Verificar autenticação ao carregar
  useEffect(() => {
    const checkAuth = async () => {
      try {
        const response = await axios.get('/api/auth/me', { 
          withCredentials: true 
        });
        setUser(response.data.data);
      } catch (err) {
        setUser(null);
      } finally {
        setIsLoading(false);
      }
    };

    checkAuth();
  }, []);

  const login = useCallback(async (email, password) => {
    setErrors({});
    try {
      const response = await axios.post('/api/auth/login', 
        { email, password },
        { withCredentials: true }
      );
      setUser(response.data.data);
      return { success: true };
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Erro ao fazer login';
      setErrors({ general: errorMessage });
      return { success: false, error: errorMessage };
    }
  }, []);

  const logout = useCallback(async () => {
    try {
      await axios.post('/api/auth/logout', {}, { 
        withCredentials: true 
      });
      setUser(null);
      return { success: true };
    } catch (err) {
      console.error('Erro ao fazer logout:', err);
      return { success: false };
    }
  }, []);

  const value = {
    user,
    isLoading,
    isAuthenticated: !!user,
    errors,
    login,
    logout,
  };

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  const context = React.useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth deve ser usado dentro de um AuthProvider');
  }
  return context;
};

export default AuthContext;
