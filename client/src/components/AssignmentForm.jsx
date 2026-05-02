import React, { useState } from 'react';

const initialForm = {
  equipment_id: '',
  user_id: '',
  assigned_at: '',
  due_at: '',
  notes: '',
};

export default function AssignmentForm({ onAssign, isLoading }) {
  const [form, setForm] = useState(initialForm);

  function handleChange(event) {
    const { name, value } = event.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  }

  async function handleSubmit(event) {
    event.preventDefault();
    await onAssign(form);
    setForm(initialForm);
  }

  return (
    <form className="card" onSubmit={handleSubmit}>
      <h3>Assign Equipment</h3>

      <label>Equipment ID</label>
      <input name="equipment_id" value={form.equipment_id} onChange={handleChange} required />

      <label>User ID</label>
      <input name="user_id" value={form.user_id} onChange={handleChange} required />

      <label>Assigned At</label>
      <input type="date" name="assigned_at" value={form.assigned_at} onChange={handleChange} required />

      <label>Due At</label>
      <input type="date" name="due_at" value={form.due_at} onChange={handleChange} />

      <label>Notes</label>
      <textarea name="notes" value={form.notes} onChange={handleChange} />

      <button type="submit" disabled={isLoading}>
        {isLoading ? 'Assigning...' : 'Assign'}
      </button>
    </form>
  );
}
