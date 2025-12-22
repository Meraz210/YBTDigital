<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

// Sample products data
$products = [
    [
        'id' => 1,
        'name' => 'Premium Web Template',
        'price' => 49.99,
        'category' => 'Web Templates',
        'sales' => 125,
        'status' => 'active',
        'image' => 'https://via.placeholder.com/100x100/4361ee/ffffff?text=Web+Template'
    ],
    [
        'id' => 2,
        'name' => 'Mobile UI Kit',
        'price' => 39.99,
        'category' => 'UI Kits',
        'sales' => 98,
        'status' => 'active',
        'image' => 'https://via.placeholder.com/100x100/3f37c9/ffffff?text=Mobile+UI'
    ],
    [
        'id' => 3,
        'name' => 'Icon Pack',
        'price' => 29.99,
        'category' => 'Graphics',
        'sales' => 210,
        'status' => 'active',
        'image' => 'https://via.placeholder.com/100x100/4cc9f0/ffffff?text=Icon+Pack'
    ],
    [
        'id' => 4,
        'name' => 'Development Tool',
        'price' => 59.99,
        'category' => 'Tools',
        'sales' => 76,
        'status' => 'inactive',
        'image' => 'https://via.placeholder.com/100x100/f72585/ffffff?text=Dev+Tool'
    ]
];

// Handle form submission for adding new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    
    // In a real implementation, you would insert into the database
    // For now, we'll just show a success message
    $success_message = "Product added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - YBT Digital Admin</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --text-light: #ffffff;
            --text-dark: #212529;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }
        
        .dashboard-container {
            min-height: 100vh;
            padding-top: 20px;
        }
        
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding-top: 80px;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            transition: all 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 999;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 60px;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            z-index: 1001;
        }
        
        .admin-logo i {
            margin-right: 10px;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="admin-logo">
        <i class="fas fa-store"></i> YBT Digital Admin
    </div>
    
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="products.php" class="active"><i class="fas fa-box"></i> Products</a>
        <a href="orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <a href="coupons.php"><i class="fas fa-gift"></i> Coupons</a>
        <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h4 class="mb-0">Products Management</h4>
            </div>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['admin_name']); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="main-content">
        <div class="container-fluid">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-box me-2"></i>Products</h3>
                <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addProductModal">
                    <i class="fas fa-plus me-2"></i>Add Product
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image"></td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo $product['sales']; ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $product['status']; ?>">
                                                <?php echo ucfirst($product['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" data-mdb-toggle="modal" data-mdb-target="#editProductModal<?php echo $product['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label">Price ($)</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="Web Templates">Web Templates</option>
                                <option value="UI Kits">UI Kits</option>
                                <option value="Graphics">Graphics</option>
                                <option value="Tools">Tools</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-4">
                            <label for="file" class="form-label">Digital File</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Product Modal for each product -->
    <?php foreach ($products as $product): ?>
        <div class="modal fade" id="editProductModal<?php echo $product['id']; ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?php echo $product['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel<?php echo $product['id']; ?>">Edit Product</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="edit_name_<?php echo $product['id']; ?>" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="edit_name_<?php echo $product['id']; ?>" name="edit_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="edit_price_<?php echo $product['id']; ?>" class="form-label">Price ($)</label>
                                    <input type="number" class="form-control" id="edit_price_<?php echo $product['id']; ?>" name="edit_price" step="0.01" value="<?php echo $product['price']; ?>" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_category_<?php echo $product['id']; ?>" class="form-label">Category</label>
                                <select class="form-control" id="edit_category_<?php echo $product['id']; ?>" name="edit_category" required>
                                    <option value="Web Templates" <?php echo ($product['category'] === 'Web Templates') ? 'selected' : ''; ?>>Web Templates</option>
                                    <option value="UI Kits" <?php echo ($product['category'] === 'UI Kits') ? 'selected' : ''; ?>>UI Kits</option>
                                    <option value="Graphics" <?php echo ($product['category'] === 'Graphics') ? 'selected' : ''; ?>>Graphics</option>
                                    <option value="Tools" <?php echo ($product['category'] === 'Tools') ? 'selected' : ''; ?>>Tools</option>
                                    <option value="Other" <?php echo ($product['category'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="edit_description_<?php echo $product['id']; ?>" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description_<?php echo $product['id']; ?>" name="edit_description" rows="4" required><?php echo htmlspecialchars($product['name']); ?> description</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="edit_image_<?php echo $product['id']; ?>" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="edit_image_<?php echo $product['id']; ?>" name="edit_image">
                                <div class="mt-2">
                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_status_<?php echo $product['id']; ?>" class="form-label">Status</label>
                                <select class="form-control" id="edit_status_<?php echo $product['id']; ?>" name="edit_status">
                                    <option value="active" <?php echo ($product['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($product['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                            <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>