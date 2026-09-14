-- Seed blood groups
INSERT INTO blood_groups (name) VALUES
('A+'), ('A-'), ('B+'), ('B-'), ('AB+'), ('AB-'), ('O+'), ('O-');

-- Seed admin user (username: admin, password: admin123)
INSERT INTO admins (username, full_name, email, password_hash) VALUES
('admin', 'System Administrator', 'admin@bloodbankpro.local', '0192023a7bbd73250516f069df18b500');

-- Seed site settings
INSERT INTO site_settings (id, contact_email, contact_phone, contact_address) VALUES
(1, 'support@bloodbankpro.local', '+91-9876543210', 'Central Blood Bank, Main Road, Your City, Your State, India');

-- Seed About page
INSERT INTO pages (slug, title, content) VALUES
('about', 'About BloodBankPro', 'BloodBankPro is a centralized Blood Bank & Donor Management System built using PHP and MySQL. It connects voluntary donors with patients and hospitals through a secure and easy-to-use web portal.');

-- Seed donors (password for all: donor123)
INSERT INTO donors (full_name, email, phone, city, blood_group_id, password_hash) VALUES
('Rahul Sharma', 'donor1@example.com', '+91-9511926824', 'Mumbai', 1, '24509bdd53861f8f468a94c84526f88a'),
('Sneha Verma', 'donor2@example.com', '+91-9103976827', 'Delhi', 2, '24509bdd53861f8f468a94c84526f88a'),
('Amit Patel', 'donor3@example.com', '+91-9967077749', 'Bengaluru', 3, '24509bdd53861f8f468a94c84526f88a'),
('Priya Singh', 'donor4@example.com', '+91-9117211380', 'Chennai', 4, '24509bdd53861f8f468a94c84526f88a'),
('Vikas Kumar', 'donor5@example.com', '+91-9541805038', 'Kolkata', 5, '24509bdd53861f8f468a94c84526f88a'),
('Neha Gupta', 'donor6@example.com', '+91-9395604178', 'Pune', 6, '24509bdd53861f8f468a94c84526f88a'),
('Arjun Reddy', 'donor7@example.com', '+91-9611299738', 'Hyderabad', 7, '24509bdd53861f8f468a94c84526f88a'),
('Pooja Nair', 'donor8@example.com', '+91-9632228883', 'Ahmedabad', 8, '24509bdd53861f8f468a94c84526f88a');
