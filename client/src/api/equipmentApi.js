import { http } from './http';

export async function getEquipments(page = 1) {
  const response = await http.get(`/equipments?page=${page}`);
  return response.data;
}

export async function createEquipment(payload) {
  const response = await http.post('/equipments', payload);
  return response.data;
}

export async function updateEquipment(id, payload) {
  const response = await http.put(`/equipments/${id}`, payload);
  return response.data;
}

export async function deleteEquipment(id) {
  const response = await http.delete(`/equipments/${id}`);
  return response.data;
}
