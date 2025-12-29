<?php
/**
 * Authentication Controller
 * Handles login, logout, and authentication
 */
class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        // Redirect if already authenticated
        if (Session::isAuthenticated()) {
            $this->redirectToDashboard();
            return;
        }

        $this->view('auth/login', [], null);
    }

    /**
     * Process login
     */
    public function login()
    {
        if ($this->isPost()) {
            CSRF::verify();

            $username = $this->post('username');
            $password = $this->post('password');

            // Validate
            $validation = $this->validate($_POST, [
                'username' => 'required',
                'password' => 'required'
            ]);

            if ($validation !== true) {
                flashError('Please fill all required fields');
                $this->redirect('login');
                return;
            }

            // Authenticate
            $result = $this->userModel->authenticate($username, $password);

            if ($result['success']) {
                // Set session
                Session::setUser(
                    $result['user']['id'],
                    $result['user']['role_id'],
                    [
                        'username' => $result['user']['username'],
                        'email' => $result['user']['email'],
                        'role_name' => $result['role']
                    ]
                );

                // Log activity
                $this->logActivity($result['user']['id'], 'User logged in', 'Authentication');

                flashSuccess('Welcome back, ' . $result['user']['username']);

                // Redirect to intended URL or dashboard
                $intendedUrl = Session::get('intended_url');
                if ($intendedUrl) {
                    Session::remove('intended_url');
                    header('Location: ' . $intendedUrl);
                } else {
                    $this->redirectToDashboard();
                }
                return;
            } else {
                // Increment failed attempts
                $attempts = Session::get('login_attempts') ?? 0;
                Session::set('login_attempts', $attempts + 1);

                flashError($result['message']);
                $this->redirect('login');
            }
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Log activity before destroying session
        if (Session::isAuthenticated()) {
            $this->logActivity(Session::userId(), 'User logged out', 'Authentication');
        }

        Session::destroy();
        flashSuccess('You have been logged out');
        $this->redirect('login');
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    private function redirectToDashboard()
    {
        $role = Session::userRole();

        switch ($role) {
            case ROLE_SUPER_ADMIN:
                $this->redirect('admin/dashboard');
                break;
            case ROLE_FRANCHISE_ADMIN:
                $this->redirect('franchise/dashboard');
                break;
            case ROLE_INSTITUTE_ADMIN:
                $this->redirect('institute/dashboard');
                break;
            case ROLE_TEACHER:
                $this->redirect('teacher/dashboard');
                break;
            case ROLE_STUDENT:
                $this->redirect('student/dashboard');
                break;
            default:
                $this->redirect('/');
        }
    }


    /**
     * Show Forgot Password Form
     */
    public function showForgotPassword()
    {
        $this->view('auth/forgot_password');
    }

    /**
     * Handle Forgot Password Submission
     */
    public function sendResetLink()
    {
        if ($this->isPost()) {
            CSRF::verify();
            $email = $this->post('email');

            $db = Database::getInstance();
            $user = $db->fetchOne("SELECT id, username FROM users WHERE email = ?", [$email]);

            if ($user) {
                // Generate Token
                $token = bin2hex(random_bytes(32));

                // Save to DB using MySQL time to avoid timezone mismatch
                $db->query(
                    "UPDATE users SET reset_token = ?, reset_expires_at = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?",
                    [$token, $user['id']]
                );

                // Simulate Email Sending (Since we are on localhost)
                $resetLink = url("reset-password?token=$token");

                // Log for debugging/testing
                error_log("Password Reset Link for $email: $resetLink");

                // Show link to user (For Demo Purposes)
                flashSuccess("A password reset link has been sent to your email. <br><strong><a href='$resetLink'>Click here to reset (Demo Link)</a></strong>");
            } else {
                // Determine if we should reveal that email doesn't exist (Security vs UX)
                // For this internal system, it's usually fine to say "Email not found"
                flashError("No account found with that email address.");
            }

            $this->redirect('forgot-password');
        }
    }

    /**
     * Show Reset Password Form
     */
    public function showResetPassword()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            flashError('Invalid password reset link.');
            $this->redirect('login');
            return;
        }

        // Verify Token
        $db = Database::getInstance();
        $user = $db->fetchOne("SELECT id FROM users WHERE reset_token = ? AND reset_expires_at > NOW()", [$token]);

        if (!$user) {
            flashError('This password reset link is invalid or has expired.');
            $this->redirect('login');
            return;
        }

        $this->view('auth/reset_password', ['token' => $token]);
    }

    /**
     * Handle Reset Password Submission
     */
    public function resetPassword()
    {
        if ($this->isPost()) {
            CSRF::verify();
            $token = $this->post('token');
            $password = $this->post('password');
            $confirm = $this->post('confirm_password');

            if ($password !== $confirm) {
                flashError('Passwords do not match.');
                header("Location: " . url("reset-password?token=$token"));
                return;
            }

            if (strlen($password) < 6) {
                flashError('Password must be at least 6 characters.');
                header("Location: " . url("reset-password?token=$token"));
                return;
            }

            $db = Database::getInstance();
            $user = $db->fetchOne("SELECT id FROM users WHERE reset_token = ? AND reset_expires_at > NOW()", [$token]);

            if ($user) {
                // Update Password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $db->update('users', [
                    'password_hash' => $hashedPassword,
                    'reset_token' => null,
                    'reset_expires_at' => null
                ], "id = {$user['id']}");

                // Reset failed attempts
                Session::remove('login_attempts');

                flashSuccess('Your password has been reset successfully. You can now login.');
                $this->redirect('login');
            } else {
                flashError('Invalid or expired token.');
                $this->redirect('login');
            }
        }
    }
}
