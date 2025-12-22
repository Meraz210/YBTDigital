<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YBT Digital - Premium Digital Products</title>
    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="assets/css/theme.css" rel="stylesheet">
    <link href="assets/css/mobile.css" rel="stylesheet">
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
            transition: background-color 0.3s, color 0.3s;
        }
        
        body.dark-mode {
            background-color: var(--dark-bg);
            color: var(--text-light);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            padding: 5rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 20px 20px;
        }
        
        .dark-mode .hero-section {
            background: linear-gradient(135deg, var(--secondary-color), #5d5bcf);
        }
        
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        
        .nav-link {
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--primary-color);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .mobile-bottom-nav-item {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            color: white;
        }
        
        .mobile-bottom-nav-item.active {
            font-weight: bold;
        }
        
        .mobile-bottom-nav-icon {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }
        
        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }
            
            .mobile-bottom-nav {
                display: flex;
            }
            
            .hero-section {
                padding: 3rem 0;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-bottom-nav {
                display: none;
            }
        }
        
        .testimonial-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .dark-mode .testimonial-card {
            background-color: #343a40;
        }
        
        .theme-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light desktop-nav">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-store me-2"></i>YBT Digital
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products/index.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="user/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user/signup.php"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link theme-toggle" id="themeToggle" href="#"><i class="fas fa-moon me-1"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <a href="index.php" class="mobile-bottom-nav-item active">
            <i class="fas fa-home mobile-bottom-nav-icon"></i>
            <span>Home</span>
        </a>
        <a href="products/index.php" class="mobile-bottom-nav-item">
            <i class="fas fa-shopping-bag mobile-bottom-nav-icon"></i>
            <span>Products</span>
        </a>
        <a href="#" class="mobile-bottom-nav-item">
            <i class="fas fa-shopping-cart mobile-bottom-nav-icon"></i>
            <span>Cart</span>
        </a>
        <a href="user/profile.php" class="mobile-bottom-nav-item">
            <i class="fas fa-user mobile-bottom-nav-icon"></i>
            <span>Profile</span>
        </a>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold text-white mb-4">Premium Digital Products</h1>
                    <p class="lead text-white mb-4">Discover our collection of high-quality digital products designed to enhance your business and personal projects.</p>
                    <a href="products/index.php" class="btn btn-light btn-lg">Explore Products <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="card bg-light shadow-lg">
                        <div class="card-body p-4">
                            <h5 class="card-title">Featured Products</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Web Templates</li>
                                <li class="list-group-item">Mobile App UI Kits</li>
                                <li class="list-group-item">Graphics & Icons</li>
                                <li class="list-group-item">Development Tools</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Featured Products</h2>
                <p class="text-muted">Popular digital products loved by our customers</p>
            </div>
            <div class="row" id="productsContainer">
                <!-- Products will be loaded here -->
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light dark-mode:bg-gray-800">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">What Our Customers Say</h2>
                <p class="text-muted">Hear from satisfied customers</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">John Doe</h6>
                                    <small class="text-muted">Digital Marketer</small>
                                </div>
                            </div>
                            <p class="card-text">"The digital products from YBT Digital have transformed my workflow. High quality and exactly what I needed!"</p>
                            <div class="d-flex">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Jane Smith</h6>
                                    <small class="text-muted">Web Developer</small>
                                </div>
                            </div>
                            <p class="card-text">"I've purchased several templates from YBT Digital and they've all exceeded my expectations. Great value for money!"</p>
                            <div class="d-flex">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0">Robert Johnson</h6>
                                    <small class="text-muted">Business Owner</small>
                                </div>
                            </div>
                            <p class="card-text">"Fast downloads, excellent quality, and responsive customer support. YBT Digital is my go-to for digital products!"</p>
                            <div class="d-flex">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to common questions</p>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-question-circle text-primary me-2"></i>How do I download my purchased products?</h5>
                            <p class="card-text">After completing your purchase, you'll be redirected to a download page. You can also access your downloads from your account dashboard.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-question-circle text-primary me-2"></i>Are there any usage restrictions?</h5>
                            <p class="card-text">Our products come with a license that allows for personal and commercial use. Some products may have specific usage terms which are detailed in the product description.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-question-circle text-primary me-2"></i>Can I get a refund?</h5>
                            <p class="card-text">We offer a 30-day money-back guarantee on all our digital products. If you're not satisfied, contact our support team for assistance.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-question-circle text-primary me-2"></i>Do you offer technical support?</h5>
                            <p class="card-text">Yes, we provide technical support for all our products. You can reach out to our support team through the contact form or email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-store me-2"></i>YBT Digital</h5>
                    <p>Your trusted source for premium digital products. We provide high-quality templates, tools, and resources for developers and designers.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="products/index.php" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Account</h5>
                    <ul class="list-unstyled">
                        <li><a href="user/login.php" class="text-light text-decoration-none">Login</a></li>
                        <li><a href="user/signup.php" class="text-light text-decoration-none">Sign Up</a></li>
                        <li><a href="user/profile.php" class="text-light text-decoration-none">Profile</a></li>
                        <li><a href="user/orders.php" class="text-light text-decoration-none">Orders</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> support@ybtdigital.com</li>
                        <li><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Business St, City, Country</li>
                    </ul>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-light btn-floating me-2" role="button">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-floating me-2" role="button">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-floating me-2" role="button">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-floating" role="button">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 YBT Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- MDB Bootstrap JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
    
    <script>
        // Dark mode toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('i');
        
        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Set the initial theme
        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
        
        // Toggle theme function
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        });
        
        // Simulate loading products
        document.addEventListener('DOMContentLoaded', function() {
            const productsContainer = document.getElementById('productsContainer');
            
            // Sample product data
            const products = [
                {
                    id: 1,
                    name: 'Premium Web Template',
                    description: 'Modern responsive web template with multiple page layouts',
                    price: '$49.99',
                    image: 'https://via.placeholder.com/300x200/4361ee/ffffff?text=Web+Template'
                },
                {
                    id: 2,
                    name: 'Mobile UI Kit',
                    description: 'Complete UI kit for mobile app development',
                    price: '$39.99',
                    image: 'https://via.placeholder.com/300x200/3f37c9/ffffff?text=Mobile+UI'
                },
                {
                    id: 3,
                    name: 'Icon Pack',
                    description: 'Set of 500+ vector icons for your projects',
                    price: '$29.99',
                    image: 'https://via.placeholder.com/300x200/4cc9f0/ffffff?text=Icon+Pack'
                },
                {
                    id: 4,
                    name: 'Development Tool',
                    description: 'Essential tools for web developers',
                    price: '$59.99',
                    image: 'https://via.placeholder.com/300x200/f72585/ffffff?text=Dev+Tool'
                }
            ];
            
            // Generate product cards
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'col-lg-3 col-md-6 mb-4';
                productCard.innerHTML = `
                    <div class="product-card card h-100">
                        <img src="${product.image}" class="card-img-top product-image" alt="${product.name}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text flex-grow-1">${product.description}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary mb-0">${product.price}</span>
                                    <a href="products/detail.php?id=${product.id}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productsContainer.appendChild(productCard);
            });
        });
    </script>
</body>
</html>