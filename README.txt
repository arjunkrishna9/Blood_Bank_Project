Blood Bank & Donor Management System (PHP & MySQL)
==================================================

1. Create MySQL Database
------------------------
- Create a database named: blood_bank_db
  (or any name you like, but then update includes/config.php accordingly)

2. Import Database Schema
-------------------------
- Import file: database/schema.sql
- Then import file: database/seed.sql
  (This will insert dummy admin, donors, pages and settings.)

3. Configure Database Connection
--------------------------------
- Open includes/config.php
- Update DB_HOST, DB_NAME, DB_USER, DB_PASS as per your local XAMPP/WAMP configuration.
- Update $base_url according to your project folder path.
  Example for XAMPP on Windows:
  $base_url = 'http://localhost/blood_bank_donor_system';

4. Admin Login
--------------
- URL: http://localhost/blood_bank_donor_system/admin/login.php
- Username: admin
- Password: admin123

5. Donor Login (Dummy Data)
---------------------------
- You already have 8 dummy donors seeded.
- Email examples:
  donor1@example.com
  donor2@example.com
  ...
  donor8@example.com
- Password for all donors: donor123

6. Frontend URLs
----------------
- Home / Landing Page: http://localhost/blood_bank_donor_system/index.php
- About: http://localhost/blood_bank_donor_system/about.php
- Contact: http://localhost/blood_bank_donor_system/contact.php
- Donor List: http://localhost/blood_bank_donor_system/donor-list.php
- Search Donor: http://localhost/blood_bank_donor_system/search-donor.php

7. Features Covered
-------------------
- Professional landing page design with hero section and quick search.
- Admin Dashboard with sidebar and stats cards.
- Blood Group management (Add/Delete).
- Donor management (View, Hide/Show, Delete).
- Request Received by Donor (Admin view and individual donor view).
- Contact Us queries (frontend form + admin listing).
- Manage Pages (About page content from database).
- Update Contact Info (email, phone, address used on Contact page).
- Donor module:
  - Register, Login, Logout
  - Manage Profile
  - Change Password
  - View Requests Received

8. Notes
--------
- This project is built in pure PHP (no framework) for academic use.
- Passwords are stored using MD5 hashing for simplicity (you can upgrade to password_hash for production).
- Design uses Bootstrap 5 CDN and a custom stylesheet at assets/css/style.css.
