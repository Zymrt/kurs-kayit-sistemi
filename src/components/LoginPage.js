// src/components/LoginPage.js

import React, { useState } from 'react';
import './LoginPage.css';

// Component artık onNavigateToRegister prop'unu alıyor
const LoginPage = ({ onLogin, onNavigateToRegister }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (event) => {
    event.preventDefault();
    if (email && password) {
      onLogin();
    } else {
      alert('Lütfen tüm alanları doldurun.');
    }
  };

  // "Kayıt Olun" linkine tıklandığında App.js'teki fonksiyonu çağır
  const handleNavigate = (e) => {
    e.preventDefault();
    onNavigateToRegister();
  }

  return (
    <div className="login-page">
      <div className="login-header">
        <img src="https://mezitli.bel.tr/wp-content/uploads/elementor/thumbs/ataturkbanner-p5cqm43v2khi30o2dx2vv9xpqyvj4ef97idtx88vr8.png" alt="Atatürk ve Türk Bayrağı" className="ataturk-logo" />
        <img src="https://mezitli.bel.tr/wp-content/uploads/2020/07/mezbellogo-1.png" alt="Mezitli Belediyesi" className="header-logo" />
      </div>
      <div className="login-container">
        {/* ...form içeriği aynı... */}
        <h2>Kurs Kayıt Sistemine Giriş</h2>
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label>E-posta</label>
            <input type="email" placeholder="E-postanızı girin" value={email} onChange={(e) => setEmail(e.target.value)} required />
          </div>
          <div className="form-group">
            <label>Şifre</label>
            <input type="password" placeholder="Şifrenizi girin" value={password} onChange={(e) => setPassword(e.target.value)} required />
          </div>
          <button type="submit" className="login-button">Giriş Yap</button>
        </form>
        {/* BU KISMI GÜNCELLEYİN */}
        <p className="register-link">
          Hesabınız yok mu? <a href="#" onClick={handleNavigate}>Kayıt Olun</a>
        </p>
      </div>
    </div>
  );
};

export default LoginPage;