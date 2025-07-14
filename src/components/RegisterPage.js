// src/components/RegisterPage.js

import React, { useState } from 'react';
import './RegisterPage.css'; // Stil dosyasını birazdan oluşturacağız

const RegisterPage = ({ onNavigateToLogin, onRegister }) => {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (name && email && password) {
      // Gerçek uygulamada burada API'ye kayıt isteği atılır.
      // Biz şimdilik başarılı bir şekilde kayıt olduğunu varsayıp
      // direkt kurslar sayfasına yönlendireceğiz.
      alert('Başarıyla kayıt olundu! Kurs sayfasına yönlendiriliyorsunuz.');
      onRegister(); // Bu fonksiyon App.js'ten gelecek ve bizi kurslar sayfasına atacak.
    } else {
      alert('Lütfen tüm alanları doldurun.');
    }
  };

  const handleGoToLogin = (e) => {
    e.preventDefault(); // a etiketinin sayfa yenilemesini engelle
    onNavigateToLogin();
  };

  return (
    <div className="register-page">
      <div className="register-container">
        <h2>Yeni Hesap Oluştur</h2>
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label>Ad Soyad</label>
            <input type="text" placeholder="Adınızı ve soyadınızı girin" value={name} onChange={(e) => setName(e.target.value)} required />
          </div>
          <div className="form-group">
            <label>E-posta</label>
            <input type="email" placeholder="E-postanızı girin" value={email} onChange={(e) => setEmail(e.target.value)} required />
          </div>
          <div className="form-group">
            <label>Şifre</label>
            <input type="password" placeholder="Şifrenizi oluşturun" value={password} onChange={(e) => setPassword(e.target.value)} required />
          </div>
          <button type="submit" className="register-button">
            Kayıt Ol
          </button>
        </form>
        <p className="login-link">
          Zaten hesabınız var mı? <a href="#" onClick={handleGoToLogin}>Giriş Yap</a>
        </p>
      </div>
    </div>
  );
};

export default RegisterPage;