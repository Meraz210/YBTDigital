<?php
// Order Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models\Order.php';
require_once __DIR__ . '/../models\Product.php';
require_once __DIR__ . '/../models\Coupon.php';

class OrderController extends BaseController {
    
    private $orderModel;
    private $productModel;
    private $couponModel;
    
    public function __construct() {
        parent::__construct();
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->couponModel = new Coupon();
    }
    
    /**
     * Show cart page
     */
    public function showCart() {
        $cart = $_SESSION['cart'] ?? [];
        
        // Get product details for each item in cart
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $item) {
            $product = $this->productModel->findById($item['product_id']);
            if ($product) {
                $itemTotal = $product['price'] * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
                $total += $itemTotal;
            }
        }
        
        $data = [
            'cartItems' => $cartItems,
            'total' => $total,
            'pageTitle' => 'Shopping Cart'
        ];
        
        $this->view('cart/index', $data);
    }
    
    /**
     * Add item to cart
     */
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/products');
            return;
        }
        
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if ($quantity <= 0) {
            $quantity = 1;
        }
        
        // Validate product exists
        $product = $this->productModel->findById($productId);
        if (!$product) {
            $this->setFlashMessage('error', 'Product not found.');
            $this->redirect('/products');
            return;
        }
        
        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Check if product already in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] = $quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
        }
        
        $this->setFlashMessage('success', 'Product added to cart successfully!');
        $this->redirect('/cart');
    }
    
    /**
     * Update cart item quantity
     */
    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart');
            return;
        }
        
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);
        
        if ($quantity <= 0) {
            // Remove item from cart
            $this->removeFromCart($productId);
            $this->redirect('/cart');
            return;
        }
        
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
        }
        
        $this->redirect('/cart');
    }
    
    /**
     * Remove item from cart
     */
    public function removeFromCart($productId) {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($productId) {
                return $item['product_id'] != $productId;
            });
            
            // Re-index array
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    
    /**
     * Show checkout page
     */
    public function showCheckout() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to checkout.');
            $this->redirect('/user/login?redirect=/checkout');
            return;
        }
        
        $cart = $_SESSION['cart'] ?? [];
        
        if (empty($cart)) {
            $this->setFlashMessage('error', 'Your cart is empty.');
            $this->redirect('/products');
            return;
        }
        
        // Get product details for each item in cart
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $product = $this->productModel->findById($item['product_id']);
            if ($product) {
                $itemTotal = $product['price'] * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
                $subtotal += $itemTotal;
            }
        }
        
        // Calculate tax
        $tax = $subtotal * TAX_RATE;
        $total = $subtotal + $tax;
        
        // Check for applied coupon
        $couponCode = $_SESSION['applied_coupon'] ?? '';
        $discountAmount = 0;
        
        if (!empty($couponCode)) {
            $coupon = $this->couponModel->findByCode($couponCode);
            if ($coupon) {
                $discountAmount = $this->couponModel->calculateDiscount($coupon, $subtotal);
                $total = $subtotal - $discountAmount + $tax;
            } else {
                // Coupon is no longer valid, remove it
                unset($_SESSION['applied_coupon']);
            }
        }
        
        $data = [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discountAmount,
            'total' => $total,
            'couponCode' => $couponCode,
            'pageTitle' => 'Checkout'
        ];
        
        $this->view('checkout/index', $data);
    }
    
    /**
     * Process checkout and create order
     */
    public function processCheckout() {
        if (!$this->isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/checkout');
            return;
        }
        
        $cart = $_SESSION['cart'] ?? [];
        
        if (empty($cart)) {
            $this->setFlashMessage('error', 'Your cart is empty.');
            $this->redirect('/products');
            return;
        }
        
        // Get cart items with product details
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $product = $this->productModel->findById($item['product_id']);
            if ($product) {
                $itemTotal = $product['price'] * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
                $subtotal += $itemTotal;
            }
        }
        
        if (empty($cartItems)) {
            $this->setFlashMessage('error', 'Invalid cart items.');
            $this->redirect('/cart');
            return;
        }
        
        // Calculate totals
        $tax = $subtotal * TAX_RATE;
        $total = $subtotal + $tax;
        
        // Apply coupon if exists
        $couponCode = $_SESSION['applied_coupon'] ?? '';
        $discountAmount = 0;
        
        if (!empty($couponCode)) {
            $coupon = $this->couponModel->findByCode($couponCode);
            if ($coupon && $subtotal >= $coupon['min_amount']) {
                $discountAmount = $this->couponModel->calculateDiscount($coupon, $subtotal);
                $total = $subtotal - $discountAmount + $tax;
                
                // Increment coupon usage
                $this->couponModel->incrementUsage($couponCode);
            } else {
                // Coupon is no longer valid, remove it
                unset($_SESSION['applied_coupon']);
            }
        }
        
        // Process payment based on selected gateway
        $paymentGateway = $_POST['payment_gateway'] ?? 'stripe';
        
        // For this example, we'll simulate a successful payment
        // In a real application, you would integrate with actual payment gateways
        $transactionId = 'TXN_' . uniqid();
        
        // Create order for each product in cart (simplified for single product)
        foreach ($cartItems as $item) {
            $orderData = [
                'user_id' => $this->getCurrentUserId(),
                'product_id' => $item['product']['id'],
                'transaction_id' => $transactionId,
                'payment_gateway' => $paymentGateway,
                'amount' => $item['product']['price'],
                'tax_amount' => ($item['product']['price'] * TAX_RATE),
                'total_amount' => ($item['product']['price'] * $item['quantity']) + ($item['product']['price'] * $item['quantity'] * TAX_RATE),
                'status' => 'completed',
                'coupon_code' => $couponCode,
                'discount_amount' => $discountAmount
            ];
            
            if ($this->orderModel->create($orderData)) {
                // Payment successful
                // Clear cart
                unset($_SESSION['cart']);
                unset($_SESSION['applied_coupon']);
                
                $this->setFlashMessage('success', 'Order placed successfully!');
                $this->redirect('/orders/success?order_id=' . $transactionId);
            } else {
                $this->setFlashMessage('error', 'Failed to create order. Please try again.');
                $this->redirect('/checkout');
            }
        }
    }
    
    /**
     * Show order success page
     */
    public function showSuccess() {
        $orderId = $_GET['order_id'] ?? '';
        
        if (empty($orderId)) {
            $this->redirect('/products');
            return;
        }
        
        $data = [
            'orderId' => $orderId,
            'pageTitle' => 'Order Success'
        ];
        
        $this->view('checkout/success', $data);
    }
    
    /**
     * Show user orders page
     */
    public function showOrders() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to view your orders.');
            $this->redirect('/user/login');
            return;
        }
        
        $userId = $this->getCurrentUserId();
        $orders = $this->orderModel->getByUserId($userId);
        
        $data = [
            'orders' => $orders,
            'pageTitle' => 'My Orders'
        ];
        
        $this->view('user/orders', $data);
    }
    
    /**
     * Show admin orders page
     */
    public function adminIndex() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $status = $_GET['status'] ?? null;
        
        $orders = $this->orderModel->getForAdmin($limit, $offset, $status);
        $totalOrders = $this->orderModel->getTotalCount();
        $totalPages = ceil($totalOrders / $limit);
        
        $data = [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'status' => $status,
            'pageTitle' => 'Manage Orders'
        ];
        
        $this->view('admin/orders/index', $data);
    }
    
    /**
     * Show order details (admin)
     */
    public function showOrder($id) {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $order = $this->orderModel->findById($id);
        
        if (!$order) {
            $this->setFlashMessage('error', 'Order not found.');
            $this->redirect('/admin/orders');
            return;
        }
        
        $data = [
            'order' => $order,
            'pageTitle' => 'Order Details'
        ];
        
        $this->view('admin/orders/show', $data);
    }
    
    /**
     * Update order status (admin)
     */
    public function updateStatus() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/orders');
            return;
        }
        
        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $this->sanitize($_POST['status'] ?? '');
        
        $validStatuses = ['pending', 'completed', 'failed', 'refunded'];
        
        if (!in_array($status, $validStatuses)) {
            $this->setFlashMessage('error', 'Invalid order status.');
            $this->redirect('/admin/orders/' . $orderId);
            return;
        }
        
        if ($this->orderModel->updateStatus($orderId, $status)) {
            $this->setFlashMessage('success', 'Order status updated successfully!');
        } else {
            $this->setFlashMessage('error', 'Failed to update order status.');
        }
        
        $this->redirect('/admin/orders/' . $orderId);
    }
    
    /**
     * Apply coupon to cart
     */
    public function applyCoupon() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart');
            return;
        }
        
        $couponCode = $this->sanitize($_POST['coupon_code'] ?? '');
        
        if (empty($couponCode)) {
            $this->setFlashMessage('error', 'Please enter a coupon code.');
            $this->redirect('/checkout');
            return;
        }
        
        // Calculate cart total for validation
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $product = $this->productModel->findById($item['product_id']);
            if ($product) {
                $subtotal += $product['price'] * $item['quantity'];
            }
        }
        
        $validationResult = $this->couponModel->validateForUsage($couponCode, $subtotal);
        
        if ($validationResult['valid']) {
            $_SESSION['applied_coupon'] = $couponCode;
            $this->setFlashMessage('success', 'Coupon applied successfully!');
        } else {
            $this->setFlashMessage('error', $validationResult['message']);
        }
        
        $this->redirect('/checkout');
    }
    
    /**
     * Remove coupon from cart
     */
    public function removeCoupon() {
        unset($_SESSION['applied_coupon']);
        $this->setFlashMessage('success', 'Coupon removed successfully!');
        $this->redirect('/checkout');
    }
    
    /**
     * Show download page for purchased products
     */
    public function showDownloads() {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to access your downloads.');
            $this->redirect('/user/login');
            return;
        }
        
        $userId = $this->getCurrentUserId();
        $orders = $this->orderModel->getByUserId($userId);
        
        // Filter only completed orders
        $completedOrders = array_filter($orders, function($order) {
            return $order['status'] === 'completed';
        });
        
        $data = [
            'orders' => $completedOrders,
            'pageTitle' => 'My Downloads'
        ];
        
        $this->view('user/downloads', $data);
    }
    
    /**
     * Process product download
     */
    public function download($orderId) {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to download.');
            $this->redirect('/user/login');
            return;
        }
        
        $order = $this->orderModel->findById($orderId);
        
        if (!$order) {
            $this->setFlashMessage('error', 'Order not found.');
            $this->redirect('/user/downloads');
            return;
        }
        
        // Check if this user owns this order
        if ($order['user_id'] != $this->getCurrentUserId()) {
            $this->setFlashMessage('error', 'Unauthorized access.');
            $this->redirect('/user/downloads');
            return;
        }
        
        // Check if order is completed
        if ($order['status'] !== 'completed') {
            $this->setFlashMessage('error', 'Order must be completed to download product.');
            $this->redirect('/user/downloads');
            return;
        }
        
        // Check if product file exists
        if (empty($order['product_file']) || !file_exists(PRODUCTS_DIR . $order['product_file'])) {
            $this->setFlashMessage('error', 'Product file not found.');
            $this->redirect('/user/downloads');
            return;
        }
        
        // Serve the file for download
        $filePath = PRODUCTS_DIR . $order['product_file'];
        $fileName = basename($order['product_file']);
        
        // Set headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        
        // Read and output the file
        readfile($filePath);
        
        // Optionally, log the download or update download count
        exit;
    }
}