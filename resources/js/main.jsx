import React from 'react'
import ReactDOM from 'react-dom/client'
import App from '@/App.jsx'
import { BrowserRouter } from 'react-router-dom'

ReactDOM.createRoot(document.getElementById('pgs-app-id')).render(
    <BrowserRouter basename={import.meta.env.VITE_PUBLIC_APP_BASE_URL}>
        <App />
    </BrowserRouter>
)
