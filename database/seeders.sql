-- =============================================
-- SkillUp - Database Seeder
-- Default Data and Sample Records
-- =============================================

USE skillup;

-- ============================================
--  1. INSERT ROLES
-- ============================================
INSERT INTO roles (id, role_name, display_name, permissions) VALUES
(1, 'super_admin', 'Super Administrator', '["all"]'),
(2, 'franchise_admin', 'Franchise Administrator', '["manage_institutes", "view_students", "manage_wallet", "view_reports"]'),
(3, 'institute_admin', 'Institute Administrator', '["manage_students", "manage_fees", "manage_exams", "view_reports"]'),
(4, 'teacher', 'Teacher/Staff', '["view_students", "mark_attendance", "upload_materials", "enter_marks"]'),
(5, 'student', 'Student', '["view_profile", "view_fees", "view_results", "view_materials"]');

-- ============================================
-- 2. INSERT DEFAULT USERS
-- ============================================
-- Password for all default users: Admin@123
INSERT INTO users (id, role_id, username, email, password_hash, status) VALUES
(1, 1, 'admin', 'admin@skillup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
(2, 2, 'franchise_demo', 'franchise@skillup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
(3, 3, 'institute_demo', 'institute@skillup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
(4, 4, 'teacher_demo', 'teacher@skillup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
(5, 5, 'student_demo', 'student@skillup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active');

-- ============================================
-- 3. INSERT SAMPLE FRANCHISES
-- ============================================
INSERT INTO franchises (id, franchise_code, franchise_name, owner_name, email, phone, address, city, state, pincode, commission_rate, status, user_id) VALUES
(1, 'FR20250001', 'SkillUp Delhi North', 'Rajesh Kumar', 'rajesh@skillup-delhi.com', '9876543210', '123, Main Market, Model Town', 'New Delhi', 'Delhi', '110009', 15.00, 'active', 2),
(2, 'FR20250002', 'SkillUp Mumbai Central', 'Priya Sharma', 'priya@skillup-mumbai.com', '9876543211', '456, Station Road, Dadar', 'Mumbai', 'Maharashtra', '400028', 12.00, 'active', 2);

-- ============================================
-- 4. INSERT SAMPLE INSTITUTES
-- ============================================
INSERT INTO institutes (id, franchise_id, institute_code, institute_name, address, city, state, pincode, contact_person, phone, email, status, user_id) VALUES
(1, 1, 'INST20250001', 'SkillUp Computer Center - Model Town', '123, Main Market, Model Town', 'New Delhi', 'Delhi', '110009', 'Amit Singh', '9876543212', 'modeltown@skillup.com', 'active', 3),
(2, 1, 'INST20250002', 'SkillUp Computer Center - Rohini', '789, Sector 15, Rohini', 'New Delhi', 'Delhi', '110085', 'Neha Gupta', '9876543213', 'rohini@skillup.com', 'active', 3),
(3, 2, 'INST20250003', 'SkillUp Computer Center - Dadar', '456, Station Road, Dadar', 'Mumbai', 'Maharashtra', '400028', 'Suresh Patil', '9876543214', 'dadar@skillup.com', 'active', 3);

-- ============================================
-- 5. INSERT SAMPLE COURSES
-- ============================================
INSERT INTO courses (course_code, course_name, duration, fee, description, syllabus, category, status) VALUES
('DCA001', 'Diploma in Computer Applications (DCA)', 6, 15000.00, 'Complete computer basics with practical applications', 'MS Office, Internet, Email, Typing, Basic Programming', 'Diploma', 'active'),
('ADCA001', 'Advanced Diploma in Computer Applications (ADCA)', 12, 25000.00, 'Advanced computer skills with programming', 'Programming, Database, Web Design, Networking', 'Diploma', 'active'),
('TALLY001', 'Tally with GST', 3, 8000.00, 'Complete Tally accounting with GST', 'Accounting, Inventory, GST, Reports', 'Certification', 'active'),
('WEB001', 'Web Development', 6, 18000.00, 'Full stack web development course', 'HTML, CSS, JavaScript, PHP, MySQL', 'Professional', 'active'),
('PYTHON001', 'Python Programming', 4, 12000.00, 'Python programming from basics to advanced', 'Python Basics, OOP, Django, Data Analysis', 'Professional', 'active'),
('DTP001', 'Desktop Publishing (DTP)', 3, 10000.00, 'Graphics and page layout designing', 'Photoshop, CorelDRAW, InDesign, Illustrator', 'Professional', 'active'),
('EXCEL001', 'Advanced Excel', 2, 6000.00, 'Master Excel for data analysis', 'Formulas, Pivot Tables, Macros, VBA', 'Certification', 'active'),
('TYPING001', 'English & Hindi Typing', 2, 4000.00, 'Professional typing skills', 'English Typing, Hindi Typing, Speed Building', 'Certification', 'active');

-- ============================================
-- 6. INSERT SAMPLE BATCHES
-- ============================================
INSERT INTO batches (batch_name, course_id, institute_id, teacher_id, start_date, end_date, timing, max_students, status) VALUES
('DCA Morning Batch - Jan 2025', 1, 1, 4, '2025-01-15', '2025-07-15', '9:00 AM - 11:00 AM', 30, 'active'),
('DCA Evening Batch - Jan 2025', 1, 1, 4, '2025-01-15', '2025-07-15', '5:00 PM - 7:00 PM', 30, 'active'),
('ADCA Morning Batch - Jan 2025', 2, 1, 4, '2025-01-15', '2026-01-15', '9:00 AM - 12:00 PM', 25, 'active'),
('Web Development Batch - Jan 2025', 4, 2, 4, '2025-01-20', '2025-07-20', '2:00 PM - 5:00 PM', 20, 'active'),
('Tally Batch - Jan 2025', 3, 3, 4, '2025-01-10', '2025-04-10', '10:00 AM - 12:00 PM', 25, 'active');

-- ============================================
-- 7. INSERT SAMPLE STUDENTS
-- ============================================
INSERT INTO students (student_id, user_id, institute_id, first_name, last_name, email, phone, gender, dob, address, city, state, pincode, guardian_name, guardian_phone, guardian_relation, enrollment_date, status) VALUES
('STU20250001', 5, 1, 'Rahul', 'Verma', 'rahul.verma@email.com', '9988776655', 'male', '2005-03-15', '45, Green Park', 'New Delhi', 'Delhi', '110016', 'Mr. Suresh Verma', '9988776600', 'Father', '2025-01-10', 'active'),
('STU20250002', 5, 1, 'Priya', 'Sharma', 'priya.sharma@email.com', '9988776656', 'female', '2004-07-22', '78, Lajpat Nagar', 'New Delhi', 'Delhi', '110024', 'Mrs. Sunita Sharma', '9988776601', 'Mother', '2025-01-10', 'active'),
('STU20250003', 5, 1, 'Amit', 'Singh', 'amit.singh@email.com', '9988776657', 'male', '2003-11-08', '123, Karol Bagh', 'New Delhi', 'Delhi', '110005', 'Mr. Rajesh Singh', '9988776602', 'Father', '2025-01-11', 'active'),
('STU20250004', 5, 2, 'Sneha', 'Gupta', 'sneha.gupta@email.com', '9988776658', 'female', '2005-05-19', '56, Rohini Sector 7', 'New Delhi', 'Delhi', '110085', 'Mr. Vijay Gupta', '9988776603', 'Father', '2025-01-12', 'active'),
('STU20250005', 5, 3, 'Vikram', 'Patil', 'vikram.patil@email.com', '9988776659', 'male', '2004-09-30', '234, Dadar East', 'Mumbai', 'Maharashtra', '400014', 'Mrs. Asha Patil', '9988776604', 'Mother', '2025-01-08', 'active');

-- ============================================
-- 8. INSERT STUDENT ENROLLMENTS
-- ============================================
INSERT INTO student_courses (student_id, course_id, batch_id, enrollment_date, status) VALUES
(1, 1, 1, '2025-01-10', 'ongoing'),
(2, 1, 2, '2025-01-10', 'ongoing'),
(3, 2, 3, '2025-01-11', 'ongoing'),
(4, 4, 4, '2025-01-12', 'ongoing'),
(5, 3, 5, '2025-01-08', 'ongoing');

-- ============================================
-- 9. INSERT FEE RECORDS
-- ============================================
INSERT INTO fees (student_id, course_id, total_fee, paid_amount, due_amount, payment_mode, installments, status) VALUES
(1, 1, 15000.00, 5000.00, 10000.00, 'installment', 3, 'partial'),
(2, 1, 15000.00, 15000.00, 0.00, 'one-time', 1, 'paid'),
(3, 2, 25000.00, 10000.00, 15000.00, 'installment', 2, 'partial'),
(4, 4, 18000.00, 0.00, 18000.00, 'installment', 3, 'due'),
(5, 3, 8000.00, 8000.00, 0.00, 'one-time', 1, 'paid');

-- ============================================
-- 10. INSERT SAMPLE PAYMENTS
-- ============================================
INSERT INTO payments (receipt_number, fee_id, student_id, amount, payment_method, payment_date, received_by) VALUES
('REC20250001', 1, 1, 5000.00, 'cash', '2025-01-10', 3),
('REC20250002', 2, 2, 15000.00, 'online', '2025-01-10', 3),
('REC20250003', 3, 3, 10000.00, 'cash', '2025-01-11', 3),
('REC20250004', 5, 5, 8000.00, 'card', '2025-01-08', 3);

-- ============================================
-- 11. CREATE WALLETS FOR FRANCHISES
-- ============================================
INSERT INTO wallets (franchise_id, balance, total_earned, total_withdrawn) VALUES
(1, 4650.00, 4650.00, 0.00),
(2, 960.00, 960.00, 0.00);

-- ============================================
-- 12. INSERT WALLET TRANSACTIONS
-- ============================================
INSERT INTO wallet_transactions (wallet_id, transaction_type, amount, description, reference_id, reference_type, status) VALUES
(1, 'credit', 2250.00, 'Commission on enrollment - STU20250001', 1, 'payment', 'completed'),
(1, 'credit', 2400.00, 'Commission on enrollment - STU20250003', 3, 'payment', 'completed'),
(2, 'credit', 960.00, 'Commission on enrollment - STU20250005', 4, 'payment', 'completed');

-- ============================================
-- 13. INSERT SAMPLE EXAMS
-- ============================================
INSERT INTO exams (exam_name, exam_code, course_id, batch_id, exam_date, exam_time, duration, total_marks, pass_marks, status) VALUES
('DCA First Semester Exam', 'EXAM20250001', 1, 1, '2025-03-15', '10:00:00', 120, 100, 40, 'scheduled'),
('ADCA Mid-Term Exam', 'EXAM20250002', 2, 3, '2025-06-20', '11:00:00', 180, 200, 80, 'scheduled'),
('Tally Final Exam', 'EXAM20250003', 3, 5, '2025-04-05', '10:00:00', 90, 100, 40, 'scheduled');

-- ============================================
-- 14. INSERT SAMPLE STUDY MATERIALS
-- ============================================
INSERT INTO study_materials (course_id, batch_id, title, description, file_type, file_path, is_public, uploaded_by) VALUES
(1, 1, 'MS Word Tutorial', 'Complete MS Word guide with examples', 'pdf', 'materials/dca/ms_word_tutorial.pdf', TRUE, 4),
(1, 1, 'Excel Basics Video', 'Introduction to Microsoft Excel', 'video', 'materials/dca/excel_basics.mp4', TRUE, 4),
(2, 3, 'Programming Fundamentals', 'Introduction to programming concepts', 'pdf', 'materials/adca/programming_fundamentals.pdf', TRUE, 4),
(4, 4, 'HTML & CSS Guide', 'Web development basics', 'pdf', 'materials/web/html_css_guide.pdf', TRUE, 4),
(3, 5, 'Tally GST Manual', 'Complete Tally with GST guide', 'pdf', 'materials/tally/tally_gst_manual.pdf', TRUE, 4);

-- ============================================
-- 15. INSERT SAMPLE CERTIFICATES
-- ============================================
INSERT INTO certificates (certificate_number, student_id, course_id, issue_date, qr_code, template, status, issued_by) VALUES
('CERT20240001', 1, 1, '2024-12-20', 'QR_CERT20240001', 'default', 'active', 1);

-- ============================================
-- 16. INSERT SAMPLE SETTINGS
-- ============================================
INSERT INTO settings (setting_key, setting_value, setting_type, description) VALUES
('site_name', 'SkillUp - Computer Center Management System', 'text', 'Website name'),
('site_email', 'info@skillup.com', 'email', 'Contact email'),
('site_phone', '+91-9876543210', 'text', 'Contact phone'),
('site_address', '123, Education Hub, New Delhi - 110001', 'textarea', 'Office address'),
('commission_rate', '10', 'number', 'Default franchise commission rate (%)'),
('student_id_prefix', 'STU', 'text', 'Student ID prefix'),
('franchise_code_prefix', 'FR', 'text', 'Franchise code prefix'),
('certificate_prefix', 'CERT', 'text', 'Certificate number prefix'),
('enable_franchise', '1', 'boolean', 'Enable franchise system'),
('enable_wallet', '1', 'boolean', 'Enable wallet system');

-- ============================================
-- 17. INSERT SAMPLE ATTENDANCE (Last 5 days)
-- ============================================
INSERT INTO attendance (student_id, batch_id, attendance_date, status, marked_by) VALUES
-- Student 1 (Last 5 days)
(1, 1, '2025-01-20', 'present', 4),
(1, 1, '2025-01-21', 'present', 4),
(1, 1, '2025-01-22', 'absent', 4),
(1, 1, '2025-01-23', 'present', 4),
(1, 1, '2025-01-24', 'present', 4),
-- Student 2
(2, 2, '2025-01-20', 'present', 4),
(2, 2, '2025-01-21', 'present', 4),
(2, 2, '2025-01-22', 'present', 4),
(2, 2, '2025-01-23', 'late', 4),
(2, 2, '2025-01-24', 'present', 4);

-- ============================================
-- SUCCESS MESSAGE
-- ============================================
SELECT '✅ Database seeded successfully!' AS Status;
SELECT 'Default Login Credentials:' AS Info;
SELECT 'Username: admin | Password: Admin@123' AS 'Super Admin';
SELECT 'Username: franchise_demo | Password: Admin@123' AS 'Franchise Admin';
SELECT 'Username: institute_demo | Password: Admin@123' AS 'Institute Admin';
SELECT 'Username: teacher_demo | Password: Admin@123' AS 'Teacher';
SELECT 'Username: student_demo | Password: Admin@123' AS 'Student';
