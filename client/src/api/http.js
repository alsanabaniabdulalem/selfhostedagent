import axios from 'axios';

const baseURL = process.env.REACT_APP_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Single Axios client shared by all API modules.
export const http = axios.create({
  baseURL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Attach bearer token for every request when user is logged in.
http.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});
