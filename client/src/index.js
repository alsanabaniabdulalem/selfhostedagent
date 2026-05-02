import React from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import App from './App';
import './styles.css';

const container = document.getElementById('root');
const root = createRoot(container);

root.render(
  <React.StrictMode>
    {/* Router keeps client routes independent from API routes. */}
    <BrowserRouter>
      <App />
    </BrowserRouter>
  </React.StrictMode>
);
