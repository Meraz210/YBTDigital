<?php
// User Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class UserController extends BaseController {
    
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }
    
    /**
     * Show user registration page
     */
    public function showRegister() {
        $this->view('auth/signup');
    }
    
    /**
     * Show user signup page
     */
    public function showSignup() {
        $this->view('auth/signup');
    }
    
    /**
     * Handle user registration
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitize($_POST['name'] ?? '');
            $email = $this->sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Name is required';
            }
            
            if (empty($email)) {
                $errors[] = 'Email is required';
            } elseif (!$this->validateEmail($email)) {
                $errors[] = 'Invalid email format';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors[] = 'Email already exists';
            }
            
            if (empty($password)) {
                $errors[] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                // Generate email verification token
                $verificationToken = $this->generateRandomString();
                
                if ($this->userModel->create($name, $email, $password, $verificationToken)) {
                    // In a real application, you would send an email here
                    $this->setFlashMessage('success', 'Registration successful! Please check your email to verify your account.');
                    $this->redirect('/user/login');
                } else {
                    $this->setFlashMessage('error', 'Registration failed. Please try again.');
                }
            } else {
                $this->setFlashMessage('error', implode('<br>', $errors));
                $this->redirect('/user/register');
            }
        }
    }
    
    /**
     * Handle user signup
     */
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF validation
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!SecurityHelper::validateCSRFToken($csrfToken)) {
                $this->setFlashMessage('error', 'Invalid request. Please try again.');
                $this->redirect('/user/signup');
                return;
            }
            
            $name = $this->sanitize($_POST['name'] ?? '');
            $email = $this->sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            $errors = [];

            if (empty($name)) {
                $errors[] = 'Name is required';
            }

            if (empty($email)) {
                $errors[] = 'Email is required';
            } elseif (!$this->validateEmail($email)) {
                $errors[] = 'Invalid email format';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors[] = 'Email already exists';
            }

            if (empty($password)) {
                $errors[] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }

            if (empty($errors)) {
                // Generate email verification token
                $verificationToken = $this->generateRandomString();

                if ($this->userModel->create($name, $email, $password, $verificationToken)) {
                    // In a real application, you would send an email here
                    $this->setFlashMessage('success', 'Registration successful! Please check your email to verify your account.');
                    $this->redirect('/user/login');
                } else {
                    $this->setFlashMessage('error', 'Registration failed. Please try again.');
                }
            } else {
                $this->setFlashMessage('error', implode('<br>', $errors));
                $this->redirect('/user/signup');
            }
        }
    }
    
    /**
     * Show user login page
     */
    public function showLogin() {
        $this->view('auth/login');
    }
    
    /**
     * Handle user login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF validation
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!SecurityHelper::validateCSRFToken($csrfToken)) {
                $this->setFlashMessage('error', 'Invalid request. Please try again.');
                $this->redirect('/user/login');
                return;
            }
            
            $email = $this->sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $errors = [];
            
            if (empty($email)) {
                $errors[] = 'Email is required';
            }
            
            if (empty($password)) {
                $errors[] = 'Password is required';
            }
            
            if (empty($errors)) {
                $user = $this->userModel->verifyCredentials($email, $password);
                
                if ($user) {
                    if (!$user['is_active']) {
                        $this->setFlashMessage('error', 'Your account has been deactivated. Please contact support.');
                        $this->redirect('/user/login');
                        return;
                    }
                    
                    if (!$user['email_verified']) {
                        $this->setFlashMessage('error', 'Please verify your email address before logging in.');
                        $this->redirect('/user/login');
                        return;
                    }
                    
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    
                    $this->setFlashMessage('success', 'Login successful!');
                    
                    // Redirect to dashboard or previous page
                    $redirectUrl = $_POST['redirect'] ?? '/dashboard';
                    $this->redirect($redirectUrl);
                } else {
                    $this->setFlashMessage('error', 'Invalid email or password');
                    $this->redirect('/user/login');
                }
            } else {
                $this->setFlashMessage('error', implode('<br>', $errors));
                $this->redirect('/user/login');
            }
        }
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Unset all session variables
        $_SESSION = array();
        
        // Destroy the session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        $this->setFlashMessage('success', 'You have been logged out successfully.');
        $this->redirect('/user/login');
    }
    
    /**
     * Show user profile page
     */
    public function showProfile() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to access your profile.');
            $this->redirect('/user/login');
            return;
        }
        
        $userId = $this->getCurrentUserId();
        $user = $this->userModel->findById($userId);
        
        $data = [
            'user' => $user,
            'pageTitle' => 'My Profile'
        ];
        
        $this->view('user/profile', $data);
    }
    
    /**
     * Update user profile
     */
    public function updateProfile() {
        if (!$this->isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/user/profile');
            return;
        }
        
        // CSRF validation
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!SecurityHelper::validateCSRFToken($csrfToken)) {
            $this->setFlashMessage('error', 'Invalid request. Please try again.');
            $this->redirect('/user/profile');
            return;
        }
        
        $userId = $this->getCurrentUserId();
        $name = $this->sanitize($_POST['name'] ?? '');
        $email = $this->sanitize($_POST['email'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Name is required';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!$this->validateEmail($email)) {
            $errors[] = 'Invalid email format';
        } else {
            // Check if email is already taken by another user
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser && $existingUser['id'] != $userId) {
                $errors[] = 'Email is already in use';
            }
        }
        
        if (empty($errors)) {
            if ($this->userModel->updateProfile($userId, $name, $email)) {
                // Update session data
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                
                $this->setFlashMessage('success', 'Profile updated successfully!');
            } else {
                $this->setFlashMessage('error', 'Failed to update profile. Please try again.');
            }
        } else {
            $this->setFlashMessage('error', implode('<br>', $errors));
        }
        
        $this->redirect('/user/profile');
    }
    
    /**
     * Show change password page
     */
    public function showChangePassword() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to access this page.');
            $this->redirect('/user/login');
            return;
        }
        
        $data = [
            'pageTitle' => 'Change Password'
        ];
        
        $this->view('user/change_password', $data);
    }
    
    /**
     * Update user password
     */
    public function updatePassword() {
        if (!$this->isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/user/change-password');
            return;
        }
        
        // CSRF validation
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!SecurityHelper::validateCSRFToken($csrfToken)) {
            $this->setFlashMessage('error', 'Invalid request. Please try again.');
            $this->redirect('/user/change-password');
            return;
        }
        
        $userId = $this->getCurrentUserId();
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validation
        $errors = [];
        
        if (empty($currentPassword)) {
            $errors[] = 'Current password is required';
        }
        
        if (empty($newPassword)) {
            $errors[] = 'New password is required';
        } elseif (strlen($newPassword) < 6) {
            $errors[] = 'New password must be at least 6 characters';
        }
        
        if ($newPassword !== $confirmPassword) {
            $errors[] = 'New passwords do not match';
        }
        
        if (empty($errors)) {
            // Verify current password
            $user = $this->userModel->findById($userId);
            if ($user && SecurityHelper::verifyPassword($currentPassword, $user['password'])) {
                if ($this->userModel->updatePassword($userId, $newPassword)) {
                    $this->setFlashMessage('success', 'Password updated successfully!');
                } else {
                    $this->setFlashMessage('error', 'Failed to update password. Please try again.');
                }
            } else {
                $errors[] = 'Current password is incorrect';
            }
        }
        
        if (!empty($errors)) {
            $this->setFlashMessage('error', implode('<br>', $errors));
        }
        
        $this->redirect('/user/change-password');
    }
    
    /**
     * Show forgot password page
     */
    public function showForgotPassword() {
        $this->view('auth/forgot_password');
    }
    
    /**
     * Handle forgot password request
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->sanitize($_POST['email'] ?? '');
            
            if (empty($email)) {
                $this->setFlashMessage('error', 'Email is required');
                $this->redirect('/user/forgot-password');
                return;
            }
            
            $user = $this->userModel->findByEmail($email);
            
            if ($user) {
                // Generate reset token
                $resetToken = $this->generateRandomString();
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
                
                if ($this->userModel->setPasswordResetToken($email, $resetToken, $expires)) {
                    // In a real application, you would send an email with the reset link here
                    $this->setFlashMessage('success', 'Password reset link has been sent to your email.');
                } else {
                    $this->setFlashMessage('error', 'Failed to send reset link. Please try again.');
                }
            } else {
                // To prevent user enumeration, show the same message regardless of whether email exists
                $this->setFlashMessage('success', 'If your email exists in our system, a password reset link has been sent to your email.');
            }
            
            $this->redirect('/user/login');
        }
    }
    
    /**
     * Show reset password page
     */
    public function showResetPassword($token) {
        // Check if token is valid
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE reset_password_token = ? AND reset_password_expires > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $this->setFlashMessage('error', 'Invalid or expired password reset token.');
            $this->redirect('/user/login');
            return;
        }
        
        $data = [
            'token' => $token,
            'pageTitle' => 'Reset Password'
        ];
        
        $this->view('auth/reset_password', $data);
    }
    
    /**
     * Handle password reset
     */
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $this->sanitize($_POST['token'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation
            $errors = [];
            
            if (empty($token)) {
                $errors[] = 'Reset token is required';
            }
            
            if (empty($password)) {
                $errors[] = 'New password is required';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                if ($this->userModel->resetPassword($token, $password)) {
                    $this->setFlashMessage('success', 'Password has been reset successfully. You can now login with your new password.');
                    $this->redirect('/user/login');
                } else {
                    $this->setFlashMessage('error', 'Failed to reset password. Please try again.');
                    $this->redirect('/user/reset-password/' . $token);
                }
            } else {
                $this->setFlashMessage('error', implode('<br>', $errors));
                $this->redirect('/user/reset-password/' . $token);
            }
        }
    }
}