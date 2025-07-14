// src/App.js

import React, { useState } from 'react';
import LoginPage from './components/LoginPage';
import RegisterPage from './components/RegisterPage'; // Yeni sayfayı import et
import CourseListPage from './components/CourseListPage';
import './App.css';

function App() {
  // 'login', 'register', 'dashboard' durumlarını tutacak state
  const [view, setView] = useState('login');

  // Giriş yapıldığında dashboard'a yönlendir
  const handleLogin = () => {
    setView('dashboard');
  };

  // Kayıt olunduğunda dashboard'a yönlendir
  const handleRegister = () => {
    setView('dashboard');
  };

  // Çıkış yapıldığında login ekranına dön
  const handleLogout = () => {
    setView('login');
  };

  // Hangi sayfanın gösterileceğini render et
  let content;
  if (view === 'login') {
    content = <LoginPage onLogin={handleLogin} onNavigateToRegister={() => setView('register')} />;
  } else if (view === 'register') {
    content = <RegisterPage onRegister={handleRegister} onNavigateToLogin={() => setView('login')} />;
  } else {
    content = <CourseListPage onLogout={handleLogout} />;
  }

  return (
    <div className="app-container">
      {content}
    </div>
  );
}

export default App;