-- Insert Admin Account
-- Email: admin@syh.com
-- Password: password123
INSERT INTO users (full_name, email, phone, password_hash, is_admin, is_active, created_at, updated_at) 
VALUES ('Admin SYH', 'admin@syh.com', '081234567890', '$2y$10$vpAF3cjhhqw0/d62HzwUoObADmRouqFeC/m0B5cfzbKDSk7Da64Hm', 1, 1, NOW(), NOW());

-- Insert Customer Account
-- Email: customer@email.com
-- Password: password123
INSERT INTO users (full_name, email, phone, password_hash, is_active, created_at, updated_at) 
VALUES ('John Doe', 'customer@email.com', '082345678901', '$2y$10$vpAF3cjhhqw0/d62HzwUoObADmRouqFeC/m0B5cfzbKDSk7Da64Hm', 1, NOW(), NOW());
