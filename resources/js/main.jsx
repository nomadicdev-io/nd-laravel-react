import React from 'react'
import ReactDOM from 'react-dom/client'
import App from '@/App.jsx'
import i18n from "i18next";
import { initReactI18next } from "react-i18next";

i18n
  .use(initReactI18next)
  .init({
    lng: 'en', 
    interpolation: {
      escapeValue: false
    },
  });

ReactDOM.createRoot(document.getElementById('pgs-app-id')).render(
    <App />
)
