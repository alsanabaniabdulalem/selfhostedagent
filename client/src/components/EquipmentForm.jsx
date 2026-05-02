import React, { useState } from 'react';

const defaultForm = {
  asset_tag: '',
  name: '',
  category: '',
  serial_number: '',
  status: 'available',
  location: '',
};

export default function EquipmentForm({ onSubmit, isLoading }) {
  const [form, setForm] = useState(defaultForm);

  function handleChange(event) {
    const { name, value } = event.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  }

  async function handleSubmit(event) {
    event.preventDefault();
    await onSubmit(form);
    setForm(defaultForm);
  }

  return (
    <form className="card" onSubmit={handleSubmit}>
      <h3>Add Equipment</h3>
      <label>Asset Tag</label>
      <input name="asset_tag" value={form.asset_tag} onChange={handleChange} required />

      <label>Name</label>
      <input name="name" value={form.name} onChange={handleChange} required />

      <label>Category</label>
      <input name="category" value={form.category} onChange={handleChange} required />

      <label>Serial Number</label>
      <input name="serial_number" value={form.serial_number} onChange={handleChange} />

      <label>Status</label>
      <select name="status" value={form.status} onChange={handleChange}>
        <option value="available">available</option>
        <option value="assigned">assigned</option>
        <option value="maintenance">maintenance</option>
        <option value="retired">retired</option>
      </select>

      <label>Location</label>
      <input name="location" value={form.location} onChange={handleChange} />

      <button type="submit" disabled={isLoading}>
        {isLoading ? 'Saving...' : 'Create Equipment'}
      </button>
    </form>
  );
}
