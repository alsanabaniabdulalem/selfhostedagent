import { http } from './http';

export async function login(email, password) {
  const response = await http.post('/login', { email, password });
  return response.data;
}

export async function logout() {
  const response = await http.post('/logout');
  return response.data;
}
