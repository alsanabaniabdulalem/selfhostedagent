import React from 'react';

export default function EquipmentTable({ equipments, onDelete }) {
  return (
    <div className="card">
      <h3>Equipment List</h3>
      <table>
        <thead>
          <tr>
            <th>Asset Tag</th>
            <th>Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Location</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {equipments.map((equipment) => (
            <tr key={equipment.id}>
              <td>{equipment.asset_tag}</td>
              <td>{equipment.name}</td>
              <td>{equipment.category}</td>
              <td>{equipment.status}</td>
              <td>{equipment.location || '-'}</td>
              <td>
                <button
                  className="danger"
                  onClick={() => onDelete(equipment.id)}
                  type="button"
                >
                  Delete
                </button>
              </td>
            </tr>
          ))}
          {equipments.length === 0 && (
            <tr>
              <td colSpan="6">No equipment yet.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}
