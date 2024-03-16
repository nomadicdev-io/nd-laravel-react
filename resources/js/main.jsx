import React from 'react'
import ReactDOM from 'react-dom/client'
import App from '@/App.jsx'
import { BrowserRouter } from 'react-router-dom'

import.meta.glob([
    '../images/**',
]);

ReactDOM.createRoot(document.getElementById('pgs-app-id')).render(
    <BrowserRouter>
        <App />
    </BrowserRouter>
)
