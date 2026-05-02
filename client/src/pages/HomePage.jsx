import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { logout } from '../api/authApi';
import {
  createAssignment,
  getAssignments,
  getDashboardStats,
  markAssignmentReturned,
} from '../api/assignmentApi';
import { createEquipment, deleteEquipment, getEquipments } from '../api/equipmentApi';
import AssignmentForm from '../components/AssignmentForm';
import DashboardCards from '../components/DashboardCards';
import EquipmentForm from '../components/EquipmentForm';
import EquipmentTable from '../components/EquipmentTable';

export default function HomePage() {
  const navigate = useNavigate();
  const [stats, setStats] = useState({});
  const [equipments, setEquipments] = useState([]);
  const [assignments, setAssignments] = useState([]);
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function loadAll() {
    setLoading(true);
    setError('');
    try {
      const [statsRes, equipmentRes, assignmentRes] = await Promise.all([
        getDashboardStats(),
        getEquipments(1),
        getAssignments(1),
      ]);

      setStats(statsRes.data || {});
      setEquipments((equipmentRes.data || []).map((item) => item));
      setAssignments((assignmentRes.data || []).map((item) => item));
    } catch (err) {
      setError(err?.response?.data?.message || 'Failed to load dashboard data');
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      navigate('/login');
      return;
    }

    loadAll();
  }, []);

  async function handleCreateEquipment(payload) {
    setMessage('');
    setError('');
    try {
      await createEquipment(payload);
      setMessage('Equipment created');
      await loadAll();
    } catch (err) {
      setError(err?.response?.data?.message || 'Failed to create equipment');
    }
  }

  async function handleDeleteEquipment(id) {
    setMessage('');
    setError('');
    try {
      await deleteEquipment(id);
      setMessage('Equipment deleted');
      await loadAll();
    } catch (err) {
      setError(err?.response?.data?.message || 'Failed to delete equipment');
    }
  }

  async function handleAssign(payload) {
    setMessage('');
    setError('');
    try {
      await createAssignment(payload);
      setMessage('Assignment created');
      await loadAll();
    } catch (err) {
      setError(err?.response?.data?.message || 'Failed to assign equipment');
    }
  }

  async function handleReturn(assignmentId) {
    setMessage('');
    setError('');
    try {
      // Client lets server pick current date when returned_at is omitted.
      await markAssignmentReturned(assignmentId, {});
      setMessage('Equipment returned');
      await loadAll();
    } catch (err) {
      setError(err?.response?.data?.message || 'Failed to return assignment');
    }
  }

  async function handleLogout() {
    try {
      await logout();
    } catch (_err) {
      // Ignore server errors on logout and clear token locally.
    } finally {
      localStorage.removeItem('auth_token');
      navigate('/login');
    }
  }

  return (
    <main className="page">
      <header className="topbar">
        <div>
          <h1>Equipment Tracker</h1>
          <p className="muted">Client app talking to Laravel API server</p>
        </div>
        <button onClick={handleLogout} type="button">Logout</button>
      </header>

      {message && <p className="success">{message}</p>}
      {error && <p className="error">{error}</p>}

      {loading ? <p className="muted">Loading...</p> : <DashboardCards stats={stats} />}

      <section className="two-col">
        <EquipmentForm onSubmit={handleCreateEquipment} isLoading={loading} />
        <AssignmentForm onAssign={handleAssign} isLoading={loading} />
      </section>

      <EquipmentTable equipments={equipments} onDelete={handleDeleteEquipment} />

      <section className="card">
        <h3>Assignments</h3>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Equipment</th>
              <th>User</th>
              <th>Assigned</th>
              <th>Due</th>
              <th>Returned</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            {assignments.map((assignment) => (
              <tr key={assignment.id}>
                <td>{assignment.id}</td>
                <td>{assignment.equipment?.name || '-'}</td>
                <td>{assignment.user?.name || '-'}</td>
                <td>{assignment.assigned_at || '-'}</td>
                <td>{assignment.due_at || '-'}</td>
                <td>{assignment.returned_at || 'Not yet'}</td>
                <td>
                  {!assignment.returned_at ? (
                    <button type="button" onClick={() => handleReturn(assignment.id)}>
                      Mark Returned
                    </button>
                  ) : (
                    <span className="muted">Done</span>
                  )}
                </td>
              </tr>
            ))}
            {assignments.length === 0 && (
              <tr>
                <td colSpan="7">No assignments yet.</td>
              </tr>
            )}
          </tbody>
        </table>
      </section>
    </main>
  );
}
