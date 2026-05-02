import React from 'react';

function Card({ title, value }) {
  return (
    <div className="card">
      <h3>{title}</h3>
      <p className="big-number">{value}</p>
    </div>
  );
}

export default function DashboardCards({ stats }) {
  return (
    <section className="cards-grid">
      <Card title="Total Equipment" value={stats.total ?? 0} />
      <Card title="Available" value={stats.available ?? 0} />
      <Card title="Assigned" value={stats.assigned ?? 0} />
      <Card title="Overdue" value={stats.overdue ?? 0} />
    </section>
  );
}
