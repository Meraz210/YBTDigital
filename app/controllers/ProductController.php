<?php
// Product Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models\Review.php';

class ProductController extends BaseController {
    
    private $productModel;
    private $reviewModel;
    
    public function __construct() {
        parent::__construct();
        $this->productModel = new Product();
        $this->reviewModel = new Review();
    }
    
    /**
     * Show product listing page
     */
    public function index() {
        $page = (int)($_GET['page'] ?? 1);
        $limit = 12; // Products per page
        $offset = ($page - 1) * $limit;
        
        $search = $_GET['search'] ?? '';
        $categoryId = (int)($_GET['category'] ?? 0);
        
        // Get products based on filters
        if (!empty($search)) {
            $products = $this->productModel->search($search);
            $totalProducts = count($products);
        } elseif ($categoryId > 0) {
            $products = $this->productModel->getByCategory($categoryId);
            $totalProducts = count($products);
        } else {
            $products = $this->productModel->getAllActive();
            $totalProducts = count($products);
        }
        
        // Calculate pagination
        $totalPages = ceil($totalProducts / $limit);
        
        // Get only the products for current page
        $products = array_slice($products, $offset, $limit);
        
        // Get average ratings for each product
        foreach ($products as &$product) {
            $rating = $this->reviewModel->getAverageRating($product['id']);
            $product['avg_rating'] = $rating['average'];
            $product['total_reviews'] = $rating['total'];
        }
        
        $data = [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'categoryId' => $categoryId,
            'pageTitle' => 'Products'
        ];
        
        $this->view('products/index', $data);
    }
    
    /**
     * Show product detail page
     */
    public function show($id) {
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            $this->setFlashMessage('error', 'Product not found.');
            $this->redirect('/products');
            return;
        }
        
        // Get average rating
        $rating = $this->reviewModel->getAverageRating($id);
        $product['avg_rating'] = $rating['average'];
        $product['total_reviews'] = $rating['total'];
        
        // Get related products
        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id);
        
        // Get product reviews
        $reviews = $this->reviewModel->getByProduct($id, 5, 0); // Get first 5 reviews
        
        // Check if current user has reviewed this product
        $userHasReviewed = false;
        $userReview = null;
        
        if ($this->isLoggedIn()) {
            $userId = $this->getCurrentUserId();
            $userHasReviewed = $this->reviewModel->hasUserReviewedProduct($userId, $id);
            if ($userHasReviewed) {
                $userReview = $this->reviewModel->getByUserAndProduct($userId, $id);
            }
        }
        
        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'userHasReviewed' => $userHasReviewed,
            'userReview' => $userReview,
            'pageTitle' => $product['name']
        ];
        
        $this->view('products/show', $data);
    }
    
    /**
     * Show admin product listing
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
        
        $products = $this->productModel->getAll($limit, $offset, 'all');
        $totalProducts = $this->productModel->getTotalCount('all');
        $totalPages = ceil($totalProducts / $limit);
        
        $data = [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => 'Manage Products'
        ];
        
        $this->view('admin/products/index', $data);
    }
    
    /**
     * Show add product form
     */
    public function showAdd() {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $data = [
            'pageTitle' => 'Add New Product'
        ];
        
        $this->view('admin/products/create', $data);
    }
    
    /**
     * Handle adding a new product
     */
    public function add() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
            return;
        }
        
        // Process form data
        $name = $this->sanitize($_POST['name'] ?? '');
        $description = $this->sanitize($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $status = $this->sanitize($_POST['status'] ?? 'draft');
        $downloadLimit = (int)($_POST['download_limit'] ?? 5);
        
        // Validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Product name is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Product description is required';
        }
        
        if ($price <= 0) {
            $errors[] = 'Product price must be greater than 0';
        }
        
        if ($categoryId <= 0) {
            $errors[] = 'Category is required';
        }
        
        if (empty($errors)) {
            // Handle file uploads
            $image = '';
            $file = '';
            $screenshots = [];
            
            // Process product image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $this->uploadFile($_FILES['image'], 'images');
            }
            
            // Process product file
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $this->uploadFile($_FILES['file'], 'products');
            }
            
            // Process screenshots
            if (isset($_FILES['screenshots'])) {
                $screenshots = $this->uploadMultipleFiles($_FILES['screenshots'], 'screenshots');
            }
            
            $productData = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $categoryId,
                'image' => $image,
                'screenshots' => $screenshots,
                'file_path' => $file,
                'download_limit' => $downloadLimit,
                'status' => $status
            ];
            
            if ($this->productModel->create($productData)) {
                $this->setFlashMessage('success', 'Product created successfully!');
                $this->redirect('/admin/products');
            } else {
                $this->setFlashMessage('error', 'Failed to create product. Please try again.');
                $this->redirect('/admin/products/add');
            }
        } else {
            $this->setFlashMessage('error', implode('<br>', $errors));
            $this->redirect('/admin/products/add');
        }
    }
    
    /**
     * Show edit product form
     */
    public function showEdit($id) {
        if (!$this->isAdmin()) {
            $this->setFlashMessage('error', 'Access denied. Admin access required.');
            $this->redirect('/user/login');
            return;
        }
        
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            $this->setFlashMessage('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        
        $data = [
            'product' => $product,
            'pageTitle' => 'Edit Product'
        ];
        
        $this->view('admin/products/edit', $data);
    }
    
    /**
     * Handle updating a product
     */
    public function update($id) {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
            return;
        }
        
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            $this->setFlashMessage('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        
        // Process form data
        $name = $this->sanitize($_POST['name'] ?? '');
        $description = $this->sanitize($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $status = $this->sanitize($_POST['status'] ?? 'draft');
        $downloadLimit = (int)($_POST['download_limit'] ?? 5);
        
        // Validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Product name is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Product description is required';
        }
        
        if ($price <= 0) {
            $errors[] = 'Product price must be greater than 0';
        }
        
        if ($categoryId <= 0) {
            $errors[] = 'Category is required';
        }
        
        if (empty($errors)) {
            // Handle file uploads
            $image = $product['image']; // Keep existing image if not updated
            $file = $product['file_path']; // Keep existing file if not updated
            $screenshots = json_decode($product['screenshots'], true) ?: []; // Keep existing screenshots if not updated
            
            // Process product image if provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Delete old image if it exists
                if (!empty($product['image']) && file_exists(PRODUCTS_DIR . $product['image'])) {
                    unlink(PRODUCTS_DIR . $product['image']);
                }
                $image = $this->uploadFile($_FILES['image'], 'images');
            }
            
            // Process product file if provided
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                // Delete old file if it exists
                if (!empty($product['file_path']) && file_exists(PRODUCTS_DIR . $product['file_path'])) {
                    unlink(PRODUCTS_DIR . $product['file_path']);
                }
                $file = $this->uploadFile($_FILES['file'], 'products');
            }
            
            // Process screenshots if provided
            if (isset($_FILES['screenshots']) && !empty($_FILES['screenshots']['name'][0])) {
                // Delete old screenshots if they exist
                $oldScreenshots = json_decode($product['screenshots'], true) ?: [];
                foreach ($oldScreenshots as $oldScreenshot) {
                    if (file_exists(PRODUCTS_DIR . $oldScreenshot)) {
                        unlink(PRODUCTS_DIR . $oldScreenshot);
                    }
                }
                
                $newScreenshots = $this->uploadMultipleFiles($_FILES['screenshots'], 'screenshots');
                $screenshots = $newScreenshots;
            }
            
            $productData = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $categoryId,
                'image' => $image,
                'screenshots' => $screenshots,
                'file_path' => $file,
                'download_limit' => $downloadLimit,
                'status' => $status
            ];
            
            if ($this->productModel->update($id, $productData)) {
                $this->setFlashMessage('success', 'Product updated successfully!');
                $this->redirect('/admin/products');
            } else {
                $this->setFlashMessage('error', 'Failed to update product. Please try again.');
                $this->redirect('/admin/products/edit/' . $id);
            }
        } else {
            $this->setFlashMessage('error', implode('<br>', $errors));
            $this->redirect('/admin/products/edit/' . $id);
        }
    }
    
    /**
     * Delete a product
     */
    public function delete($id) {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
            return;
        }
        
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            $this->setFlashMessage('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        
        // Delete associated files
        if (!empty($product['image']) && file_exists(PRODUCTS_DIR . $product['image'])) {
            unlink(PRODUCTS_DIR . $product['image']);
        }
        
        if (!empty($product['file_path']) && file_exists(PRODUCTS_DIR . $product['file_path'])) {
            unlink(PRODUCTS_DIR . $product['file_path']);
        }
        
        $screenshots = json_decode($product['screenshots'], true) ?: [];
        foreach ($screenshots as $screenshot) {
            if (file_exists(PRODUCTS_DIR . $screenshot)) {
                unlink(PRODUCTS_DIR . $screenshot);
            }
        }
        
        if ($this->productModel->delete($id)) {
            $this->setFlashMessage('success', 'Product deleted successfully!');
        } else {
            $this->setFlashMessage('error', 'Failed to delete product. Please try again.');
        }
        
        $this->redirect('/admin/products');
    }
    
    /**
     * Upload a single file
     */
    private function uploadFile($file, $type) {
        $allowedTypes = ['images' => ['jpg', 'jpeg', 'png', 'gif', 'svg'], 
                         'products' => ['zip', 'rar', 'pdf', 'doc', 'docx', 'txt'],
                         'screenshots' => ['jpg', 'jpeg', 'png', 'gif']];
        
        $targetDir = PRODUCTS_DIR;
        
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedTypes[$type])) {
            throw new Exception("File type not allowed for $type");
        }
        
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new Exception("File size exceeds maximum allowed size");
        }
        
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $targetDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName;
        }
        
        throw new Exception("Failed to upload file");
    }
    
    /**
     * Upload multiple files
     */
    private function uploadMultipleFiles($files, $type) {
        $uploadedFiles = [];
        
        $fileCount = count($files['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $file = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ];
                
                try {
                    $uploadedFile = $this->uploadFile($file, $type);
                    $uploadedFiles[] = $uploadedFile;
                } catch (Exception $e) {
                    // Log error but continue with other files
                    error_log("File upload failed: " . $e->getMessage());
                }
            }
        }
        
        return $uploadedFiles;
    }
    
    /**
     * Get products API endpoint for AJAX requests
     */
    public function apiGetProducts() {
        header('Content-Type: application/json');
        
        $search = $_GET['search'] ?? '';
        $categoryId = (int)($_GET['category'] ?? 0);
        $limit = (int)($_GET['limit'] ?? 10);
        $offset = (int)($_GET['offset'] ?? 0);
        
        $filters = [];
        if ($categoryId > 0) {
            $filters['category_id'] = $categoryId;
        }
        
        $products = $this->productModel->getWithFilters($filters);
        $totalProducts = count($products);
        
        // Apply offset and limit
        $products = array_slice($products, $offset, $limit);
        
        // Get average ratings for each product
        foreach ($products as &$product) {
            $rating = $this->reviewModel->getAverageRating($product['id']);
            $product['avg_rating'] = $rating['average'];
            $product['total_reviews'] = $rating['total'];
        }
        
        echo json_encode([
            'products' => $products,
            'total' => $totalProducts,
            'limit' => $limit,
            'offset' => $offset
        ]);
    }
}