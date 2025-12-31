<?php
// Admin Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models\User.php';
require_once __DIR__ . '/../models\Order.php';
require_once __DIR__ . '/../models\Product.php';
require_once __DIR__ . '/../models\Coupon.php';

class AdminController extends BaseController {
    
    private $userModel;
    private $orderModel;
    private $productModel;
    private $couponModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->couponModel = new Coupon();
    }
    
    /**
     * Show admin dashboard
     */
    public function dashboard() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        // Get statistics
        $totalUsers = $this->userModel->getTotalCount();
        $totalProducts = $this->productModel->getTotalCount('all');
        $totalOrders = $this->orderModel->getTotalCount();
        $totalRevenue = $this->getTotalRevenue();
        
        // Get recent orders
        $recentOrders = $this->orderModel->getForAdmin(5, 0);
        
        // Get monthly sales
        $monthlySales = $this->orderModel->getMonthlySales();
        
        // Get top selling products
        $topSellingProducts = $this->orderModel->getTopSellingProducts(5);
        
        $data = [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
            'monthlySales' => $monthlySales,
            'topSellingProducts' => $topSellingProducts,
            'pageTitle' => 'Admin Dashboard'
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    /**
     * Show admin login page
     */
    public function showLogin() {
        $this->view('admin/login');
    }
    
    /**
     * Handle admin login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                
                if ($user && in_array($user['role'], ['admin', 'super_admin'])) {
                    if (!$user['is_active']) {
                        $this->setFlashMessage('error', 'Your admin account has been deactivated. Please contact the super admin.');
                        $this->redirect('/admin/login');
                        return;
                    }
                    
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    
                    $this->setFlashMessage('success', 'Admin login successful!');
                    $this->redirect('/admin/dashboard');
                } else {
                    $this->setFlashMessage('error', 'Invalid admin credentials');
                    $this->redirect('/admin/login');
                }
            } else {
                $this->setFlashMessage('error', implode('<br>', $errors));
                $this->redirect('/admin/login');
            }
        }
    }
    
    /**
     * Show admin users page
     */
    public function showUsers() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $users = $this->userModel->getAll($limit, $offset);
        $totalUsers = $this->userModel->getTotalCount();
        $totalPages = ceil($totalUsers / $limit);
        
        $data = [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => 'Manage Users'
        ];
        
        $this->view('admin/users/index', $data);
    }
    
    /**
     * Toggle user active status
     */
    public function toggleUserStatus() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
            return;
        }
        
        $userId = (int)($_POST['user_id'] ?? 0);
        $status = (bool)($_POST['status'] ?? false);
        
        if ($this->userModel->toggleActiveStatus($userId, $status)) {
            $message = $status ? 'User activated successfully!' : 'User deactivated successfully!';
            $this->setFlashMessage('success', $message);
        } else {
            $this->setFlashMessage('error', 'Failed to update user status.');
        }
        
        $this->redirect('/admin/users');
    }
    
    /**
     * Show admin coupons page
     */
    public function showCoupons() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $coupons = $this->couponModel->getAll($limit, $offset);
        $totalCoupons = $this->couponModel->getTotalCount();
        $totalPages = ceil($totalCoupons / $limit);
        
        $data = [
            'coupons' => $coupons,
            'totalCoupons' => $totalCoupons,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => 'Manage Coupons'
        ];
        
        $this->view('admin/coupons/index', $data);
    }
    
    /**
     * Show add coupon form
     */
    public function showAddCoupon() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $data = [
            'pageTitle' => 'Add New Coupon'
        ];
        
        $this->view('admin/coupons/create', $data);
    }
    
    /**
     * Handle adding a new coupon
     */
    public function addCoupon() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/coupons');
            return;
        }
        
        $code = $this->sanitize($_POST['code'] ?? '');
        $type = $this->sanitize($_POST['type'] ?? 'percentage');
        $value = (float)($_POST['value'] ?? 0);
        $minAmount = (float)($_POST['min_amount'] ?? 0);
        $usageLimit = (int)($_POST['usage_limit'] ?? null);
        $expiresAt = $this->sanitize($_POST['expires_at'] ?? null);
        $isActive = (int)($_POST['is_active'] ?? 0);
        
        // Validation
        $errors = [];
        
        if (empty($code)) {
            $errors[] = 'Coupon code is required';
        } elseif (strlen($code) < 3) {
            $errors[] = 'Coupon code must be at least 3 characters';
        }
        
        if (!in_array($type, ['percentage', 'fixed'])) {
            $errors[] = 'Invalid coupon type';
        }
        
        if ($value <= 0) {
            $errors[] = 'Coupon value must be greater than 0';
        }
        
        if ($minAmount < 0) {
            $errors[] = 'Minimum amount cannot be negative';
        }
        
        if (!empty($expiresAt)) {
            $date = date_create_from_format('Y-m-d', $expiresAt);
            if (!$date || $date->format('Y-m-d') !== $expiresAt) {
                $errors[] = 'Invalid expiration date format';
            }
        }
        
        if (empty($errors)) {
            // Check if coupon code already exists
            $existingCoupon = $this->couponModel->findByCode($code);
            if ($existingCoupon) {
                $errors[] = 'Coupon code already exists';
            }
        }
        
        if (empty($errors)) {
            $couponData = [
                'code' => strtoupper($code),
                'type' => $type,
                'value' => $value,
                'min_amount' => $minAmount,
                'usage_limit' => $usageLimit,
                'expires_at' => $expiresAt,
                'is_active' => $isActive
            ];
            
            if ($this->couponModel->create($couponData)) {
                $this->setFlashMessage('success', 'Coupon created successfully!');
                $this->redirect('/admin/coupons');
            } else {
                $this->setFlashMessage('error', 'Failed to create coupon. Please try again.');
                $this->redirect('/admin/coupons/add');
            }
        } else {
            $this->setFlashMessage('error', implode('<br>', $errors));
            $this->redirect('/admin/coupons/add');
        }
    }
    
    /**
     * Show edit coupon form
     */
    public function showEditCoupon($id) {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $coupon = $this->couponModel->findById($id);
        
        if (!$coupon) {
            $this->setFlashMessage('error', 'Coupon not found.');
            $this->redirect('/admin/coupons');
            return;
        }
        
        $data = [
            'coupon' => $coupon,
            'pageTitle' => 'Edit Coupon'
        ];
        
        $this->view('admin/coupons/edit', $data);
    }
    
    /**
     * Handle updating a coupon
     */
    public function updateCoupon($id) {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/coupons');
            return;
        }
        
        $coupon = $this->couponModel->findById($id);
        
        if (!$coupon) {
            $this->setFlashMessage('error', 'Coupon not found.');
            $this->redirect('/admin/coupons');
            return;
        }
        
        $code = $this->sanitize($_POST['code'] ?? '');
        $type = $this->sanitize($_POST['type'] ?? 'percentage');
        $value = (float)($_POST['value'] ?? 0);
        $minAmount = (float)($_POST['min_amount'] ?? 0);
        $usageLimit = (int)($_POST['usage_limit'] ?? null);
        $expiresAt = $this->sanitize($_POST['expires_at'] ?? null);
        $isActive = (int)($_POST['is_active'] ?? 0);
        
        // Validation
        $errors = [];
        
        if (empty($code)) {
            $errors[] = 'Coupon code is required';
        } elseif (strlen($code) < 3) {
            $errors[] = 'Coupon code must be at least 3 characters';
        }
        
        if (!in_array($type, ['percentage', 'fixed'])) {
            $errors[] = 'Invalid coupon type';
        }
        
        if ($value <= 0) {
            $errors[] = 'Coupon value must be greater than 0';
        }
        
        if ($minAmount < 0) {
            $errors[] = 'Minimum amount cannot be negative';
        }
        
        if (!empty($expiresAt)) {
            $date = date_create_from_format('Y-m-d', $expiresAt);
            if (!$date || $date->format('Y-m-d') !== $expiresAt) {
                $errors[] = 'Invalid expiration date format';
            }
        }
        
        if (empty($errors)) {
            // Check if coupon code already exists (excluding current coupon)
            $existingCoupon = $this->connection->query("SELECT id FROM coupons WHERE code = '" . $this->connection->real_escape_string(strtoupper($code)) . "' AND id != $id LIMIT 1");
            if ($existingCoupon->num_rows > 0) {
                $errors[] = 'Coupon code already exists';
            }
        }
        
        if (empty($errors)) {
            $couponData = [
                'code' => strtoupper($code),
                'type' => $type,
                'value' => $value,
                'min_amount' => $minAmount,
                'usage_limit' => $usageLimit,
                'expires_at' => $expiresAt,
                'is_active' => $isActive
            ];
            
            if ($this->couponModel->update($id, $couponData)) {
                $this->setFlashMessage('success', 'Coupon updated successfully!');
                $this->redirect('/admin/coupons');
            } else {
                $this->setFlashMessage('error', 'Failed to update coupon. Please try again.');
                $this->redirect('/admin/coupons/edit/' . $id);
            }
        } else {
            $this->setFlashMessage('error', implode('<br>', $errors));
            $this->redirect('/admin/coupons/edit/' . $id);
        }
    }
    
    /**
     * Delete a coupon
     */
    public function deleteCoupon($id) {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/coupons');
            return;
        }
        
        $coupon = $this->couponModel->findById($id);
        
        if (!$coupon) {
            $this->setFlashMessage('error', 'Coupon not found.');
            $this->redirect('/admin/coupons');
            return;
        }
        
        if ($this->couponModel->delete($id)) {
            $this->setFlashMessage('success', 'Coupon deleted successfully!');
        } else {
            $this->setFlashMessage('error', 'Failed to delete coupon. Please try again.');
        }
        
        $this->redirect('/admin/coupons');
    }
    
    /**
     * Show settings page
     */
    public function showSettings() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $data = [
            'pageTitle' => 'System Settings'
        ];
        
        $this->view('admin/settings', $data);
    }
    
    /**
     * Get total revenue
     */
    private function getTotalRevenue() {
        $result = $this->connection->query("SELECT SUM(total_amount) as total_revenue FROM orders WHERE status = 'completed'");
        $row = $result->fetch_assoc();
        
        return $row['total_revenue'] ? $row['total_revenue'] : 0;
    }
    
    /**
     * Show payment gateways configuration
     */
    public function showPaymentGateways() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $result = $this->connection->query("SELECT * FROM payment_gateways ORDER BY name");
        $gateways = $result->fetch_all(MYSQLI_ASSOC);
        
        $data = [
            'gateways' => $gateways,
            'pageTitle' => 'Payment Gateways'
        ];
        
        $this->view('admin/payment_gateways', $data);
    }
    
    /**
     * Update payment gateway configuration
     */
    public function updatePaymentGateway() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings/payment-gateways');
            return;
        }
        
        $gatewayName = $this->sanitize($_POST['gateway_name'] ?? '');
        $config = $_POST['config'] ?? [];
        $isActive = (int)($_POST['is_active'] ?? 0);
        
        // Validate gateway name
        $validGateways = ['stripe', 'razorpay', 'paypal'];
        if (!in_array($gatewayName, $validGateways)) {
            $this->setFlashMessage('error', 'Invalid payment gateway');
            $this->redirect('/admin/settings/payment-gateways');
            return;
        }
        
        // Prepare config JSON
        $configJson = json_encode($config);
        
        $stmt = $this->connection->prepare("UPDATE payment_gateways SET config = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP WHERE name = ?");
        $stmt->bind_param("sss", $configJson, $isActive, $gatewayName);
        
        if ($stmt->execute()) {
            $this->setFlashMessage('success', 'Payment gateway configuration updated successfully!');
        } else {
            $this->setFlashMessage('error', 'Failed to update payment gateway configuration.');
        }
        
        $this->redirect('/admin/settings/payment-gateways');
    }
}