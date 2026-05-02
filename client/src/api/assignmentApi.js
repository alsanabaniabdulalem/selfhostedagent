import { http } from './http';

export async function getAssignments(page = 1) {
  const response = await http.get(`/assignments?page=${page}`);
  return response.data;
}

export async function createAssignment(payload) {
  const response = await http.post('/assignments', payload);
  return response.data;
}

export async function markAssignmentReturned(id, payload = {}) {
  const response = await http.patch(`/assignments/${id}/return`, payload);
  return response.data;
}

export async function getDashboardStats() {
  const response = await http.get('/dashboard/stats');
  return response.data;
}
