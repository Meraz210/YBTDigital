<?php
// Main Router File

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers\ProductController.php';
require_once __DIR__ . '/app/controllers\OrderController.php';
require_once __DIR__ . '/app/controllers\AdminController.php';

// Get the requested URL path
$request = $_SERVER['REQUEST_URI'];

// Remove the base URL from the request
$request = str_replace(BASE_URL, '', $request);

// Parse the request
$parts = explode('?', $request, 2);
$path = $parts[0];
$query = $parts[1] ?? '';

// Parse query string into $_GET
parse_str($query, $_GET);

// Route handling
try {
    // Home page
    if ($path === '/' || $path === '') {
        // Ensure database connection is loaded
        require_once __DIR__ . '/config/database.php';
        
        // Load necessary models
        require_once __DIR__ . '/app/models/Product.php';
        require_once __DIR__ . '/app/models/Review.php';
        require_once __DIR__ . '/app/models/Category.php';
        
        $productModel = new Product();
        $reviewModel = new Review();
        $categoryModel = new Category();
        
        // Get featured products (latest active products)
        $featuredProducts = $productModel->getAll(6, 0, 'active');
        
        // Get popular products (based on number of orders)
        $popularProducts = $productModel->getPopular(4);
        
        // Get average ratings for each product
        foreach ($featuredProducts as &$product) {
            $rating = $reviewModel->getAverageRating($product['id']);
            $product['avg_rating'] = $rating['average'];
            $product['total_reviews'] = $rating['total'];
        }
        
        foreach ($popularProducts as &$product) {
            $rating = $reviewModel->getAverageRating($product['id']);
            $product['avg_rating'] = $rating['average'];
            $product['total_reviews'] = $rating['total'];
        }
        
        // Get some statistics for the stats section
        $totalProducts = $productModel->getTotalCount();
        $categories = $categoryModel->getAll();
        
        // Include the home page
        include __DIR__ . '/resources/views/home/index.php';
    }
    // User routes
    elseif (preg_match('#^/user/register$#', $path) || preg_match('#^/user/signup$#', $path)) {
        $userController = new UserController();
        $userController->showSignup();
    }
    elseif ((preg_match('#^/user/register$#', $path) || preg_match('#^/user/signup$#', $path)) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->signup();
    }
    elseif (preg_match('#^/user/login$#', $path)) {
        $userController = new UserController();
        $userController->showLogin();
    }
    elseif (preg_match('#^/user/login$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->login();
    }
    elseif (preg_match('#^/user/logout$#', $path)) {
        $userController = new UserController();
        $userController->logout();
    }
    elseif (preg_match('#^/user/profile$#', $path)) {
        $userController = new UserController();
        $userController->showProfile();
    }
    elseif (preg_match('#^/user/profile$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->updateProfile();
    }
    elseif (preg_match('#^/user/change-password$#', $path)) {
        $userController = new UserController();
        $userController->showChangePassword();
    }
    elseif (preg_match('#^/user/change-password$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->updatePassword();
    }
    elseif (preg_match('#^/user/forgot-password$#', $path)) {
        $userController = new UserController();
        $userController->showForgotPassword();
    }
    elseif (preg_match('#^/user/forgot-password$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->forgotPassword();
    }
    elseif (preg_match('#^/user/reset-password/([^/]+)$#', $path, $matches)) {
        $token = $matches[1];
        $userController = new UserController();
        $userController->showResetPassword($token);
    }
    elseif (preg_match('#^/user/reset-password$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->resetPassword();
    }
    // Product routes
    elseif (preg_match('#^/products$#', $path)) {
        $productController = new ProductController();
        $productController->index();
    }
    elseif (preg_match('#^/products/(\d+)$#', $path, $matches)) {
        $id = $matches[1];
        $productController = new ProductController();
        $productController->show($id);
    }
    // Cart routes
    elseif (preg_match('#^/cart$#', $path)) {
        $orderController = new OrderController();
        $orderController->showCart();
    }
    elseif (preg_match('#^/cart/add$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderController = new OrderController();
        $orderController->addToCart();
    }
    elseif (preg_match('#^/cart/update$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderController = new OrderController();
        $orderController->updateCart();
    }
    elseif (preg_match('#^/cart/remove/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $matches[1];
        $orderController = new OrderController();
        $orderController->removeFromCart($productId);
        header("Location: " . BASE_URL . "/cart");
        exit();
    }
    // Checkout routes
    elseif (preg_match('#^/checkout$#', $path)) {
        $orderController = new OrderController();
        $orderController->showCheckout();
    }
    elseif (preg_match('#^/checkout/process$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderController = new OrderController();
        $orderController->processCheckout();
    }
    elseif (preg_match('#^/checkout/success$#', $path)) {
        $orderController = new OrderController();
        $orderController->showSuccess();
    }
    elseif (preg_match('#^/orders$#', $path)) {
        $orderController = new OrderController();
        $orderController->showOrders();
    }
    elseif (preg_match('#^/orders/downloads$#', $path)) {
        $orderController = new OrderController();
        $orderController->showDownloads();
    }
    elseif (preg_match('#^/orders/download/(\d+)$#', $path, $matches)) {
        $orderId = $matches[1];
        $orderController = new OrderController();
        $orderController->download($orderId);
    }
    // Admin routes
    elseif (preg_match('#^/admin/login$#', $path)) {
        $adminController = new AdminController();
        $adminController->showLogin();
    }
    elseif (preg_match('#^/admin/login$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminController = new AdminController();
        $adminController->login();
    }
    elseif (preg_match('#^/admin/dashboard$#', $path)) {
        $adminController = new AdminController();
        $adminController->dashboard();
    }
    elseif (preg_match('#^/admin/users$#', $path)) {
        $adminController = new AdminController();
        $adminController->showUsers();
    }
    elseif (preg_match('#^/admin/users/toggle-status$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminController = new AdminController();
        $adminController->toggleUserStatus();
    }
    elseif (preg_match('#^/admin/products$#', $path)) {
        $productController = new ProductController();
        $productController->adminIndex();
    }
    elseif (preg_match('#^/admin/products/add$#', $path)) {
        $productController = new ProductController();
        $productController->showAdd();
    }
    elseif (preg_match('#^/admin/products/add$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $productController = new ProductController();
        $productController->add();
    }
    elseif (preg_match('#^/admin/products/edit/(\d+)$#', $path, $matches)) {
        $id = $matches[1];
        $productController = new ProductController();
        $productController->showEdit($id);
    }
    elseif (preg_match('#^/admin/products/edit/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $matches[1];
        $productController = new ProductController();
        $productController->update($id);
    }
    elseif (preg_match('#^/admin/products/delete/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $matches[1];
        $productController = new ProductController();
        $productController->delete($id);
    }
    elseif (preg_match('#^/admin/orders$#', $path)) {
        $orderController = new OrderController();
        $orderController->adminIndex();
    }
    elseif (preg_match('#^/admin/orders/(\d+)$#', $path, $matches)) {
        $id = $matches[1];
        $orderController = new OrderController();
        $orderController->showOrder($id);
    }
    elseif (preg_match('#^/admin/orders/update-status$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderController = new OrderController();
        $orderController->updateStatus();
    }
    elseif (preg_match('#^/admin/coupons$#', $path)) {
        $adminController = new AdminController();
        $adminController->showCoupons();
    }
    elseif (preg_match('#^/admin/coupons/add$#', $path)) {
        $adminController = new AdminController();
        $adminController->showAddCoupon();
    }
    elseif (preg_match('#^/admin/coupons/add$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminController = new AdminController();
        $adminController->addCoupon();
    }
    elseif (preg_match('#^/admin/coupons/edit/(\d+)$#', $path, $matches)) {
        $id = $matches[1];
        $adminController = new AdminController();
        $adminController->showEditCoupon($id);
    }
    elseif (preg_match('#^/admin/coupons/edit/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $matches[1];
        $adminController = new AdminController();
        $adminController->updateCoupon($id);
    }
    elseif (preg_match('#^/admin/coupons/delete/(\d+)$#', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $matches[1];
        $adminController = new AdminController();
        $adminController->deleteCoupon($id);
    }
    elseif (preg_match('#^/admin/settings$#', $path)) {
        $adminController = new AdminController();
        $adminController->showSettings();
    }
    elseif (preg_match('#^/admin/settings/payment-gateways$#', $path)) {
        $adminController = new AdminController();
        $adminController->showPaymentGateways();
    }
    elseif (preg_match('#^/admin/settings/payment-gateways$#', $path) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminController = new AdminController();
        $adminController->updatePaymentGateway();
    }
    // API routes
    elseif (preg_match('#^/api/products$#', $path)) {
        $productController = new ProductController();
        $productController->apiGetProducts();
    }
    // Other pages
    elseif (preg_match('#^/about$#', $path)) {
        include __DIR__ . '/resources/views/pages/about.php';
    }
    elseif (preg_match('#^/contact$#', $path)) {
        include __DIR__ . '/resources/views/pages/contact.php';
    }
    else {
        // 404 Page not found
        http_response_code(404);
        include __DIR__ . '/resources/views/errors/404.php';
    }
} catch (Exception $e) {
    // Log the error
    error_log("Routing error: " . $e->getMessage());
    
    // Show error page
    http_response_code(500);
    include __DIR__ . '/resources/views/errors/500.php';
}