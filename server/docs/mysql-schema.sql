-- Equipment Tracker MySQL schema (reference only).
-- In Laravel projects, use migrations in server/laravel-api/database/migrations.

CREATE TABLE IF NOT EXISTS equipments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asset_tag VARCHAR(100) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  serial_number VARCHAR(255) NULL,
  status ENUM('available','assigned','maintenance','retired') NOT NULL DEFAULT 'available',
  location VARCHAR(255) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS assignments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  equipment_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  assigned_at DATE NOT NULL,
  due_at DATE NULL,
  returned_at DATE NULL,
  notes TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_assignments_equipment_active (equipment_id, returned_at),
  INDEX idx_assignments_due_active (due_at, returned_at),
  CONSTRAINT fk_assignments_equipment
    FOREIGN KEY (equipment_id) REFERENCES equipments(id) ON DELETE CASCADE,
  CONSTRAINT fk_assignments_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
