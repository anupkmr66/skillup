<?php
/**
 * API Controller
 * Handles AJAX requests for CRUD operations
 */
class ApiController extends Controller
{

    /**
     * Student CRUD Operations
     */
    public function createStudent()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $data = [
                'first_name' => $this->post('first_name'),
                'last_name' => $this->post('last_name'),
                'email' => $this->post('email') ?: null,
                'phone' => $this->post('phone'),
                'gender' => $this->post('gender'),
                'dob' => $this->post('dob'),
                'address' => $this->post('address'),
                'guardian_name' => $this->post('guardian_name'),
                'guardian_phone' => $this->post('guardian_phone'),
                'institute_id' => $this->post('institute_id'),
                'enrollment_date' => date('Y-m-d'),
                'status' => STATUS_ACTIVE
            ];

            // Validate
            $validation = $this->validate($data, [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'institute_id' => 'required'
            ]);

            if ($validation !== true) {
                $this->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validation]);
                return;
            }

            // Generate student ID first (needed for username)
            $studentModel = new Student();
            $generatedStudentId = $studentModel->generateStudentId();
            $data['student_id'] = $generatedStudentId;

            // Create user account FIRST
            $username = strtolower($data['first_name'] . '_' . substr($generatedStudentId, -4));
            $password = 'student@123'; // Default password

            $userData = [
                'username' => $username,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'email' => $data['email'] ?? $username . '@skillup.com',
                'role_id' => ROLE_STUDENT,
                'status' => STATUS_ACTIVE
            ];

            $db = Database::getInstance();
            $userId = $db->insert('users', $userData);

            // Now add user_id to student data
            $data['user_id'] = $userId;

            // Handle photo upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $uploadResult = $this->uploadFile($_FILES['photo'], 'students', ['jpg', 'jpeg', 'png']);
                if ($uploadResult['success']) {
                    $data['photo'] = $uploadResult['filename'];
                }
            }

            // Insert student with user_id
            $studentRecordId = $db->insert('students', $data);

            // Handle Enrollment if Course ID is provided
            $courseId = $this->post('course_id');
            $batchId = $this->post('batch_id');

            if ($courseId) {
                // Validate course
                $course = $db->fetchOne("SELECT * FROM courses WHERE id = ?", [$courseId]);

                if ($course) {
                    // Create Enrollment
                    $enrollmentData = [
                        'student_id' => $studentRecordId,
                        'course_id' => $courseId,
                        'batch_id' => $batchId ?: null,
                        'enrollment_date' => date('Y-m-d'),
                        'status' => 'ongoing'
                    ];
                    $db->insert('student_courses', $enrollmentData);

                    // Create Fee Record
                    $feeData = [
                        'student_id' => $studentRecordId,
                        'course_id' => $courseId,
                        'total_fee' => $course['fee'],
                        'discount_amount' => $this->post('discount_amount') ?: 0,
                        'paid_amount' => 0,
                        'due_amount' => $course['fee'] - ($this->post('discount_amount') ?: 0),
                        'due_date' => date('Y-m-d', strtotime('+30 days')),
                        'status' => 'unpaid'
                    ];
                    $db->insert('fees', $feeData);
                }
            }

            $this->json([
                'success' => true,
                'message' => 'Student created successfully' . ($courseId ? ' and enrolled in course' : ''),
                'data' => [
                    'student_id' => $generatedStudentId,
                    'username' => $username,
                    'password' => $password
                ]
            ]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error creating student: ' . $e->getMessage()]);
        }
    }

    /**
     * Update Student
     */
    public function updateStudent()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $studentId = $this->post('student_id');

            $data = [
                'first_name' => $this->post('first_name'),
                'last_name' => $this->post('last_name'),
                'email' => $this->post('email') ?: null,
                'phone' => $this->post('phone'),
                'gender' => $this->post('gender'),
                'dob' => $this->post('dob'),
                'address' => $this->post('address'),
                'guardian_name' => $this->post('guardian_name'),
                'guardian_phone' => $this->post('guardian_phone')
            ];

            $db = Database::getInstance();
            $db->update('students', $data, 'id = ' . $studentId);

            $this->json(['success' => true, 'message' => 'Student updated successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error updating student: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete Student
     */
    public function deleteStudent()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $studentId = $this->post('student_id');

            $db = Database::getInstance();
            // Soft delete - update status
            $db->update('students', ['status' => 'inactive'], 'id = ' . $studentId);

            $this->json(['success' => true, 'message' => 'Student deleted successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error deleting student: ' . $e->getMessage()]);
        }
    }

    /**
     * Get Student Details
     */
    public function getStudent()
    {
        $studentId = $this->post('student_id') ?? $_GET['id'] ?? null;

        if (!$studentId) {
            $this->json(['success' => false, 'message' => 'Student ID required']);
            return;
        }

        try {
            $studentModel = new Student();
            $student = $studentModel->getStudentWithDetails($studentId);

            if ($student) {
                $this->json(['success' => true, 'data' => $student]);
            } else {
                $this->json(['success' => false, 'message' => 'Student not found']);
            }

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error fetching student']);
        }
    }

    /**
     * Create Payment
     */
    public function createPayment()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $feeId = $this->post('fee_id');
            $db = Database::getInstance();

            // Get fee details to get student_id
            $fee = $db->fetchOne("SELECT * FROM fees WHERE id = ?", [$feeId]);

            if (!$fee) {
                $this->json(['success' => false, 'message' => 'Fee record not found']);
                return;
            }

            $data = [
                'student_id' => $fee['student_id'],
                'fee_id' => $feeId,
                'amount' => $this->post('amount'),
                'payment_method' => $this->post('payment_method'),
                'payment_date' => date('Y-m-d'),
                'transaction_id' => $this->post('transaction_id')
            ];

            // Generate receipt number
            $lastReceipt = $db->fetchOne("SELECT receipt_number FROM payments ORDER BY id DESC LIMIT 1");

            if ($lastReceipt) {
                $lastNumber = (int) substr($lastReceipt['receipt_number'], -6);
                $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '000001';
            }

            $data['receipt_number'] = 'REC' . date('Y') . $newNumber;

            // Insert payment
            $paymentId = $db->insert('payments', $data);

            // Update fee status
            $fee = $db->fetchOne("SELECT * FROM fees WHERE id = ?", [$data['fee_id']]);
            $newPaidAmount = $fee['paid_amount'] + $data['amount'];
            $newDueAmount = $fee['total_fee'] - ($fee['discount_amount'] ?? 0) - $newPaidAmount;

            $feeUpdate = [
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'status' => $newDueAmount <= 0 ? 'paid' : ($newPaidAmount > 0 ? 'partial' : 'unpaid')
            ];

            $db->update('fees', $feeUpdate, 'id = ' . $data['fee_id']);

            // Log Activity
            $this->logActivity(
                Session::userId(),
                "Fee Payment Received: " . $data['amount'],
                'Fees',
                "Receipt: {$data['receipt_number']} | Student ID: {$data['student_id']}"
            );

            $this->json([
                'success' => true,
                'message' => 'Payment recorded successfully',
                'receipt_number' => $data['receipt_number']
            ]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error processing payment: ' . $e->getMessage()]);
        }
    }

    /**
     * Apply Discount to Fee
     */
    public function applyDiscount()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $feeId = $this->post('fee_id');
            $discountAmount = (float) $this->post('discount_amount');
            $db = Database::getInstance();

            $fee = $db->fetchOne("SELECT * FROM fees WHERE id = ?", [$feeId]);

            if (!$fee) {
                $this->json(['success' => false, 'message' => 'Fee record not found']);
                return;
            }

            // Calculate new due amount
            // Formula: due = total - discount - paid
            $newDueAmount = $fee['total_fee'] - $discountAmount - $fee['paid_amount'];

            if ($newDueAmount < 0) {
                $this->json(['success' => false, 'message' => 'Discount cannot exceed remaining balance']);
                return;
            }

            $updateData = [
                'discount_amount' => $discountAmount,
                'due_amount' => $newDueAmount,
                'status' => $newDueAmount <= 0 ? 'paid' : ($fee['paid_amount'] > 0 ? 'partial' : 'unpaid')
            ];

            $db->update('fees', $updateData, 'id = ' . $feeId);

            // Log activity
            $this->logActivity(Session::userId(), "Applied Discount: ₹$discountAmount", 'Fees', "Fee ID: $feeId");

            $this->json(['success' => true, 'message' => 'Discount applied successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error applying discount: ' . $e->getMessage()]);
        }
    }


    /**
     * Get Fee Details
     */
    public function getFee()
    {
        $feeId = $_GET['id'] ?? null;

        if (!$feeId) {
            $this->json(['success' => false, 'message' => 'Fee ID required']);
            return;
        }

        try {
            $db = Database::getInstance();

            $fee = $db->fetchOne("
                SELECT f.*, 
                    CONCAT(s.first_name, ' ', s.last_name) as student_name,
                    c.course_name
                FROM fees f
                JOIN students s ON f.student_id = s.id
                JOIN courses c ON f.course_id = c.id
                WHERE f.id = ?
            ", [$feeId]);

            if (!$fee) {
                $this->json(['success' => false, 'message' => 'Fee not found']);
                return;
            }

            $payments = $db->fetchAll("
                SELECT * FROM payments 
                WHERE fee_id = ? 
                ORDER BY payment_date DESC
            ", [$feeId]);

            $fee['payments'] = $payments;

            $this->json(['success' => true, 'data' => $fee]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Batch Management for Institutes
     */
    public function createBatch()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $userId = Session::userId();
            $db = Database::getInstance();
            $institute = $db->fetchOne("SELECT id FROM institutes WHERE user_id = ?", [$userId]);

            if (!$institute) {
                $this->json(['success' => false, 'message' => 'Institute not found']);
                return;
            }

            $data = [
                'batch_name' => $this->post('batch_name'),
                'course_id' => $this->post('course_id'),
                'teacher_id' => !empty($this->post('teacher_id')) ? $this->post('teacher_id') : null,
                'institute_id' => $institute['id'],
                'start_date' => $this->post('start_date'),
                'end_date' => $this->post('end_date') ?: null,
                'timing' => $this->post('timing'),
                'max_students' => $this->post('max_students') ?: 30,
                'status' => 'active'
            ];

            $db->insert('batches', $data);
            $this->json(['success' => true, 'message' => 'Batch created successfully']);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateBatch()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $id = $this->post('batch_id');

            $data = [
                'batch_name' => $this->post('batch_name'),
                'course_id' => $this->post('course_id'),
                'teacher_id' => !empty($this->post('teacher_id')) ? $this->post('teacher_id') : null,
                'start_date' => $this->post('start_date'),
                'end_date' => $this->post('end_date') ?: null,
                'timing' => $this->post('timing'),
                'max_students' => $this->post('max_students'),
                'status' => $this->post('status')
            ];

            $db->update('batches', $data, "id = $id");
            $this->json(['success' => true, 'message' => 'Batch updated successfully']);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteBatch()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $id = $this->post('id');

            // Soft delete by setting status to inactive or check dependencies
            // For now, let's just delete if no students enrolled, otherwise warn
            $enrolled = $db->fetchOne("SELECT COUNT(*) as count FROM student_courses WHERE batch_id = ?", [$id]);

            if ($enrolled['count'] > 0) {
                $this->json(['success' => false, 'message' => 'Cannot delete batch with enrolled students']);
                return;
            }

            $db->query("DELETE FROM batches WHERE id = ?", [$id]);
            $this->json(['success' => true, 'message' => 'Batch deleted successfully']);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Exam Management
     */
    public function createExam()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $userId = Session::userId();
            $db = Database::getInstance();

            $data = [
                'exam_name' => $this->post('exam_name'),
                'exam_code' => $this->post('exam_code') ?: 'EX-' . date('Ymd-His'),
                'course_id' => $this->post('course_id'),
                'batch_id' => $this->post('batch_id'),
                'exam_date' => $this->post('exam_date'),
                'exam_time' => $this->post('exam_time'),
                'duration' => $this->post('duration'),
                'total_marks' => $this->post('total_marks'),
                'pass_marks' => $this->post('pass_marks'),
                'status' => 'scheduled',
                'created_by' => $userId
            ];

            $db->insert('exams', $data);
            $this->json(['success' => true, 'message' => 'Exam scheduled successfully']);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateExam()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $id = $this->post('exam_id');

            $data = [
                'exam_name' => $this->post('exam_name'),
                'exam_code' => $this->post('exam_code'),
                'course_id' => $this->post('course_id'),
                'batch_id' => $this->post('batch_id'),
                'exam_date' => $this->post('exam_date'),
                'exam_time' => $this->post('exam_time'),
                'duration' => $this->post('duration'),
                'total_marks' => $this->post('total_marks'),
                'pass_marks' => $this->post('pass_marks'),
                'status' => $this->post('status')
            ];

            $db->update('exams', $data, "id = $id");
            $this->json(['success' => true, 'message' => 'Exam updated successfully']);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteExam()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $id = $this->post('id');

            $db->query("DELETE FROM exams WHERE id = ?", [$id]);
            $this->json(['success' => true, 'message' => 'Exam deleted successfully']);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get Exam Results
     */
    public function getExamResults()
    {
        $examId = $_GET['exam_id'] ?? null;
        if (!$examId) {
            $this->json(['success' => false, 'message' => 'Exam ID required']);
            return;
        }

        try {
            $db = Database::getInstance();
            $exam = $db->fetchOne("SELECT * FROM exams WHERE id = ?", [$examId]);

            // Get students in this batch (or all students in course if null batch?)
            // Assuming exams are batch specific for now
            if ($exam['batch_id']) {
                $query = "
                    SELECT s.id, s.student_id, s.first_name, s.last_name, s.photo,
                           er.marks_obtained, er.status, er.remarks
                    FROM students s
                    JOIN student_courses sc ON s.id = sc.student_id
                    LEFT JOIN exam_results er ON s.id = er.student_id AND er.exam_id = :exam_id
                    WHERE sc.batch_id = :batch_id AND sc.status = 'ongoing'
                    ORDER BY s.first_name ASC
                ";
                $students = $db->fetchAll($query, ['batch_id' => $exam['batch_id'], 'exam_id' => $examId]);
            } else {
                // If batch_id is NULL, get all students enrolled in the course?
                // For safety/simplicity, let's assume exams are linked to batches (based on create form)
                $students = [];
            }

            $this->json(['success' => true, 'data' => $students]);
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update Exam Results
     */
    public function updateExamResults()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $examId = $this->post('exam_id');
            $marks = $this->post('marks'); // Array [student_id => marks]
            $remarks = $this->post('remarks'); // Array [student_id => remarks]
            $completed = $this->post('mark_completed') === 'true';

            $exam = $db->fetchOne("SELECT * FROM exams WHERE id = ?", [$examId]);
            $passMarks = $exam['pass_marks'];

            foreach ($marks as $studentId => $mark) {
                if ($mark === '' || $mark === null)
                    continue;

                $mark = (float) $mark;
                $status = ($mark >= $passMarks) ? 'pass' : 'fail';
                // If remark says "Absent", set status absent? Or handle separately.
                // For now, simple pass/fail based on marks.

                // Check exists
                $exists = $db->fetchOne("SELECT id FROM exam_results WHERE exam_id = ? AND student_id = ?", [$examId, $studentId]);

                $data = [
                    'exam_id' => $examId,
                    'student_id' => $studentId,
                    'marks_obtained' => $mark,
                    'status' => $status,
                    'remarks' => $remarks[$studentId] ?? null,
                    'result_date' => date('Y-m-d')
                ];

                if ($exists) {
                    $db->update('exam_results', $data, "id = " . $exists['id']);
                } else {
                    $db->insert('exam_results', $data);
                }
            }

            if ($completed) {
                $db->update('exams', ['status' => 'completed'], "id = $examId");
            }

            $this->json(['success' => true, 'message' => 'Results saved successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Create Course
     */
    public function createCourse()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $data = [
                'course_name' => $this->post('course_name'),
                'course_code' => $this->post('course_code'),
                'category' => $this->post('category'),
                'duration' => $this->post('duration'),
                'fee' => $this->post('fee'),
                'description' => $this->post('description'),
                'syllabus' => $this->post('syllabus'),
                'status' => STATUS_ACTIVE
            ];

            $validation = $this->validate($data, [
                'course_name' => 'required',
                'course_code' => 'required',
                'duration' => 'required',
                'fee' => 'required'
            ]);

            if ($validation !== true) {
                $this->json(['success' => false, 'message' => 'Validation failed']);
                return;
            }

            $db = Database::getInstance();
            $courseId = $db->insert('courses', $data);

            $this->json([
                'success' => true,
                'message' => 'Course created successfully',
                'course_id' => $courseId
            ]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error creating course']);
        }
    }

    /**
     * Enroll Student in Course
     */
    public function enrollStudent()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $data = [
                'student_id' => $this->post('student_id'),
                'course_id' => $this->post('course_id'),
                'batch_id' => $this->post('batch_id'),
                'enrollment_date' => date('Y-m-d'),
                'status' => 'ongoing'
            ];

            $db = Database::getInstance();

            // Check if already enrolled
            $existing = $db->fetchOne("
                SELECT * FROM student_courses 
                WHERE student_id = ? AND course_id = ?
            ", [$data['student_id'], $data['course_id']]);

            if ($existing) {
                $this->json(['success' => false, 'message' => 'Student already enrolled in this course']);
                return;
            }

            // Enroll student
            $enrollmentId = $db->insert('student_courses', $data);

            // Create fee record
            $course = $db->fetchOne("SELECT * FROM courses WHERE id = ?", [$data['course_id']]);

            $feeData = [
                'student_id' => $data['student_id'],
                'course_id' => $data['course_id'],
                'total_fee' => $course['fee'],
                'discount_amount' => $this->post('discount_amount') ?: 0,
                'paid_amount' => 0,
                'due_amount' => $course['fee'] - ($this->post('discount_amount') ?: 0),
                'due_date' => date('Y-m-d', strtotime('+30 days')),
                'status' => 'unpaid'
            ];

            $db->insert('fees', $feeData);

            $this->json([
                'success' => true,
                'message' => 'Student enrolled successfully'
            ]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error enrolling student']);
        }
    }

    /**
     * Submit Lead Form
     */
    public function submitLead()
    {
        if (!$this->isPost())
            return;

        // No CSRF check here as it might be from public modal - but ideally should have one. 
        // For public pages, we often skip strict Auth but should keep CSRF if possible.
        // Assuming CSRF token is passed in AJAX.
        // Check CSRF Token
        if (!CSRF::validate()) {
            $this->json(['success' => false, 'message' => 'Security token expired. Please refresh the page.']);
            return;
        }

        try {
            $data = [
                'course_id' => $this->post('course_id'),
                'name' => $this->post('name'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'city' => $this->post('city'),
                'education' => $this->post('education'),
                'message' => $this->post('message') ?: 'Interested in course',
                'status' => 'new'
            ];

            // Validation
            if (empty($data['name']) || empty($data['phone']) || empty($data['course_id'])) {
                $this->json(['success' => false, 'message' => 'Name, Phone and Course are required']);
                return;
            }

            $db = Database::getInstance();
            $db->insert('leads', $data);

            $this->json(['success' => true, 'message' => 'Thank you! We will contact you shortly.']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error submitting request: ' . $e->getMessage()]);
        }
    }

    /**
     * Upload Study Material
     */
    public function uploadMaterial()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            if (!isset($_FILES['file'])) {
                $this->json(['success' => false, 'message' => 'No file uploaded']);
                return;
            }

            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                $uploadErrors = [
                    UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive in php.ini',
                    UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive in HTML form',
                    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
                    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                    UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
                ];
                $message = $uploadErrors[$_FILES['file']['error']] ?? 'Unknown upload error';
                $this->json(['success' => false, 'message' => 'Upload Error: ' . $message]);
                return;
            }

            $uploadResult = $this->uploadFile($_FILES['file'], 'materials', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'mp4', 'avi']);

            if (!$uploadResult['success']) {
                $this->json(['success' => false, 'message' => $uploadResult['error']]);
                return;
            }

            $extension = strtolower(pathinfo($uploadResult['filename'], PATHINFO_EXTENSION));
            $fileType = 'other';
            if ($extension === 'pdf') {
                $fileType = 'pdf';
            } elseif (in_array($extension, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt'])) {
                $fileType = 'document';
            } elseif (in_array($extension, ['mp4', 'avi', 'mkv', 'mov'])) {
                $fileType = 'video';
            }

            $data = [
                'course_id' => $this->post('course_id'),
                'batch_id' => $this->post('batch_id'),
                'title' => $this->post('title'),
                'description' => $this->post('description'),
                'file_path' => $uploadResult['filename'],
                'file_type' => $fileType,
                'uploaded_by' => Session::userId()
            ];

            $db = Database::getInstance();
            $materialId = $db->insert('study_materials', $data);

            $this->json([
                'success' => true,
                'message' => 'Material uploaded successfully',
                'material_id' => $materialId
            ]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error uploading material: ' . $e->getMessage()]);
        }
    }

    /**
     * Record Attendance
     */
    public function recordAttendance()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $batchId = $this->post('batch_id');
            $date = $this->post('date');
            $students = $this->post('students'); // Array of student IDs

            $db = Database::getInstance();

            foreach ($students as $studentId => $status) {
                $data = [
                    'student_id' => $studentId,
                    'batch_id' => $batchId,
                    'attendance_date' => $date,
                    'status' => $status, // present/absent/late
                    'marked_by' => Session::userId()
                ];

                // Check if already marked
                $existing = $db->fetchOne("
                    SELECT * FROM attendance 
                    WHERE student_id = ? AND batch_id = ? AND attendance_date = ?
                ", [$studentId, $batchId, $date]);

                if ($existing) {
                    $db->update('attendance', ['status' => $status], ['id' => $existing['id']]);
                } else {
                    $db->insert('attendance', $data);
                }
            }

            $this->json(['success' => true, 'message' => 'Attendance recorded successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error recording attendance']);
        }
    }

    /**
     * Get Dashboard Stats
     */
    public function getDashboardStats()
    {
        try {
            $role = Session::userRole();
            $userId = Session::userId();
            $db = Database::getInstance();

            $stats = [];

            switch ($role) {
                case ROLE_SUPER_ADMIN:
                    $stats = [
                        'franchises' => $db->fetchOne("SELECT COUNT(*) as count FROM franchises WHERE status = 'active'")['count'],
                        'institutes' => $db->fetchOne("SELECT COUNT(*) as count FROM institutes WHERE status = 'active'")['count'],
                        'students' => $db->fetchOne("SELECT COUNT(*) as count FROM students WHERE status = 'active'")['count'],
                        'revenue' => $db->fetchOne("SELECT SUM(amount) as total FROM payments")['total'] ?? 0
                    ];
                    break;

                case ROLE_FRANCHISE_ADMIN:
                    $franchise = $db->fetchOne("SELECT * FROM franchises WHERE user_id = ?", [$userId]);
                    $stats = [
                        'institutes' => $db->fetchOne("SELECT COUNT(*) as count FROM institutes WHERE franchise_id = ?", [$franchise['id']])['count'],
                        'students' => $db->fetchOne("
                            SELECT COUNT(DISTINCT s.id) as count 
                            FROM students s
                            JOIN institutes i ON s.institute_id = i.id
                            WHERE i.franchise_id = ?
                        ", [$franchise['id']])['count']
                    ];
                    break;
            }

            $this->json(['success' => true, 'data' => $stats]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error fetching stats']);
        }
    }
    /**
     * Get Students for Batch Attendance
     */
    public function getBatchStudents()
    {
        try {
            $batchId = $_GET['batch_id'] ?? null;
            $date = $_GET['date'] ?? date('Y-m-d');

            if (!$batchId) {
                $this->json(['success' => false, 'message' => 'Batch ID required']);
                return;
            }

            $db = Database::getInstance();

            // Get students enrolled in this batch
            // Also left join attendance to see if already marked
            $students = $db->fetchAll("
                SELECT s.id, s.student_id, s.first_name, s.last_name, s.photo,
                    a.status as attendance, a.remarks
                FROM students s
                JOIN student_courses sc ON s.id = sc.student_id
                LEFT JOIN attendance a ON s.id = a.student_id AND a.batch_id = :batch_id_att AND a.attendance_date = :date
                WHERE sc.batch_id = :batch_id AND sc.status = 'ongoing'
                ORDER BY s.first_name ASC
            ", [
                'batch_id' => $batchId,
                'batch_id_att' => $batchId,
                'date' => $date
            ]);

            $this->json(['success' => true, 'data' => $students]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error fetching students: ' . $e->getMessage()]);
        }
    }

    /**
     * Get Monthly Attendance
     */
    public function getMonthlyAttendance()
    {
        try {
            $batchId = $_GET['batch_id'] ?? null;
            $month = $_GET['month'] ?? date('m');
            $year = $_GET['year'] ?? date('Y');

            if (!$batchId) {
                $this->json(['success' => false, 'message' => 'Batch ID required']);
                return;
            }

            $db = Database::getInstance();

            // Get all students in the batch
            $students = $db->fetchAll("
                SELECT s.id, s.student_id, s.first_name, s.last_name
                FROM students s
                JOIN student_courses sc ON s.id = sc.student_id
                WHERE sc.batch_id = ? AND sc.status = 'ongoing'
                ORDER BY s.first_name ASC
            ", [$batchId]);

            // Get attendance records for the month
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate));

            $records = $db->fetchAll("
                SELECT student_id, attendance_date, status, remarks
                FROM attendance
                WHERE batch_id = ? AND attendance_date BETWEEN ? AND ?
            ", [$batchId, $startDate, $endDate]);

            // Map records to student_id => [date => status]
            $attendanceMap = [];
            foreach ($records as $record) {
                $day = (int) date('d', strtotime($record['attendance_date']));
                if (!isset($attendanceMap[$record['student_id']])) {
                    $attendanceMap[$record['student_id']] = [];
                }
                $attendanceMap[$record['student_id']][$day] = [
                    'status' => $record['status'],
                    'remarks' => $record['remarks']
                ];
            }

            $this->json([
                'success' => true,
                'data' => [
                    'students' => $students,
                    'attendance' => $attendanceMap,
                    'daysInMonth' => (int) date('t', strtotime($startDate))
                ]
            ]);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Update Institute Profile
     */
    public function updateInstituteProfile()
    {
        if (!$this->isPost())
            return;

        CSRF::verify();

        try {
            $db = Database::getInstance();
            $instituteId = $this->post('institute_id');
            $userId = Session::userId();

            // Verify ownership
            $check = $db->fetchOne("SELECT id FROM institutes WHERE id = ? AND user_id = ?", [$instituteId, $userId]);
            if (!$check) {
                $this->json(['success' => false, 'message' => 'Unauthorized']);
                return;
            }

            $data = [
                'contact_person' => $this->post('contact_person'),
                'phone' => $this->post('phone'),
                'address' => $this->post('address'),
                'city' => $this->post('city'),
                'state' => $this->post('state'),
                'pincode' => $this->post('pincode')
            ];

            $db->update('institutes', $data, "id = $instituteId");
            $this->json(['success' => true, 'message' => 'Profile updated successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    /**
     * Teacher Management
     */
    public function createTeacher()
    {
        if (!$this->isPost()) {
            $this->json(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        CSRF::verify();

        try {
            $data = [
                'first_name' => $this->post('first_name'),
                'last_name' => $this->post('last_name'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'qualification' => $this->post('qualification'),
                'experience' => $this->post('experience'),
                'specialization' => $this->post('specialization'),
                'institute_id' => $this->post('institute_id'),
                'status' => 'active'
            ];

            // Validate
            $validation = $this->validate($data, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required', // Email required for login
                'phone' => 'required',
                'institute_id' => 'required'
            ]);

            if ($validation !== true) {
                $this->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validation]);
                return;
            }

            $db = Database::getInstance();
            $db->beginTransaction();

            try {
                // Check if email exists
                $existingUser = $db->fetchOne("SELECT id FROM users WHERE email = ?", [$data['email']]);
                if ($existingUser) {
                    $this->json(['success' => false, 'message' => 'Email already registered']);
                    $db->rollback();
                    return;
                }

                // Generate username: firstname_lastname (or something unique)
                $baseUsername = strtolower($data['first_name'] . '.' . $data['last_name']);
                $username = $baseUsername;
                $counter = 1;
                while ($db->fetchOne("SELECT id FROM users WHERE username = ?", [$username])) {
                    $username = $baseUsername . $counter++;
                }

                $password = 'teacher@123'; // Default password

                $userData = [
                    'username' => $username,
                    'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                    'email' => $data['email'],
                    'role_id' => ROLE_TEACHER,
                    'status' => STATUS_ACTIVE
                ];

                $userId = $db->insert('users', $userData);
                $data['user_id'] = $userId;

                // Remove email from teacher data as it's not in the table
                unset($data['email']);

                // Insert Teacher
                $db->insert('teachers', $data);

                $db->commit();

                $this->json([
                    'success' => true,
                    'message' => 'Teacher created successfully',
                    'credentials' => [
                        'username' => $username,
                        'password' => $password
                    ]
                ]);

            } catch (Exception $e) {
                $db->rollback();
                throw $e;
            }
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error creating teacher: ' . $e->getMessage()]);
        }
    }

    public function updateTeacher()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $teacherId = $this->post('teacher_id');

            $data = [
                'first_name' => $this->post('first_name'),
                'last_name' => $this->post('last_name'),
                'phone' => $this->post('phone'),
                'qualification' => $this->post('qualification'),
                'experience' => $this->post('experience'),
                'specialization' => $this->post('specialization'),
                'status' => $this->post('status')
            ];

            $db->update('teachers', $data, "id = $teacherId");

            // Also update email in users table if changed? 
            // Skipping for now to avoid complexity with unique constraints/validation

            $this->json(['success' => true, 'message' => 'Teacher updated successfully']);

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteTeacher()
    {
        if (!$this->isPost())
            return;
        CSRF::verify();

        try {
            $db = Database::getInstance();
            $teacherId = $this->post('id');

            // Get user_id to deactivate/delete user account too
            $teacher = $db->fetchOne("SELECT user_id FROM teachers WHERE id = ?", [$teacherId]);

            if ($teacher) {
                // Soft delete teacher
                $db->update('teachers', ['status' => 'inactive'], "id = $teacherId");

                // Deactivate user account
                $db->update('users', ['status' => 'inactive'], "id = " . $teacher['user_id']);

                $this->json(['success' => true, 'message' => 'Teacher deactivated successfully']);
            } else {
                $this->json(['success' => false, 'message' => 'Teacher not found']);
            }

        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
