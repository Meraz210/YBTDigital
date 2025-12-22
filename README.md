# YBT Digital - Digital Product Selling Website

## Project Overview
YBT Digital is a comprehensive digital product selling website built with PHP, MySQL, and MDB Bootstrap UI. The platform includes both user-facing and admin-facing functionalities for selling digital products.

## Features Implemented

### User Side
- **Authentication System**: Complete signup/login functionality with password security
- **Responsive Design**: Mobile-first approach with bottom navigation for mobile and desktop navigation for larger screens
- **Product Management**: Product listing with filtering and search capabilities
- **Product Details**: Detailed product pages with screenshots and features
- **Shopping Cart**: Full cart functionality with add/remove/update operations
- **Checkout Process**: Secure checkout with payment form and order summary
- **Order Management**: User can view and download purchased products
- **Profile Management**: Users can update their profile information and password

### Admin Side
- **Admin Dashboard**: Overview with statistics and recent activity
- **Product Management**: Add, edit, and manage digital products
- **Order Management**: View and manage all orders
- **User Management**: View and manage user accounts
- **Security**: Role-based access control

### Technical Features
- **Dark/Light Mode**: Toggle between themes with persistent preference
- **Mobile Navigation**: Native-style mobile app experience with bottom navigation
- **Responsive Design**: Adapts to all screen sizes (mobile, tablet, desktop)
- **Payment Integration**: Mock payment processing with support for Stripe, PayPal, and Razorpay
- **Database**: Complete schema for all entities

## Directory Structure
```
YBT Digital/
├── admin/                 # Admin panel files
├── assets/                # CSS, JS, and image assets
│   ├── css/              # Stylesheets (theme.css, mobile.css)
│   ├── js/               # JavaScript files
│   └── images/           # Image assets
├── cart/                 # Shopping cart functionality
├── checkout/             # Checkout process
├── database/             # Database schema
├── includes/             # Common includes (db.php)
├── payment/              # Payment processing
├── products/             # Product listing and detail pages
├── user/                 # User profile and authentication
├── uploads/              # Product files storage
├── config.php            # Application configuration
├── index.php             # Main landing page
└── README.md             # This file
```

## Database Schema
The database includes tables for:
- Users
- Products
- Orders
- Admins
- Coupons
- Support tickets

## Setup Instructions

1. **Database Setup**:
   - Create a MySQL database named `ybt_digital`
   - Import the schema from `database/schema.sql`

2. **Configuration**:
   - Create a `.env` file based on `.env.example`
   - Set your database credentials and API keys in the `.env` file
   - The application will automatically use environment variables

3. **Payment Gateway**:
   - Set your API keys in the `.env` file for production use

4. **File Permissions**:
   - Ensure the `uploads/` directory is writable by the web server

## Admin Access
- Default admin login: admin@ybtdigital.com / admin123
- Access admin panel at `/admin/login.php`

## Key Features
- Responsive design for all device sizes
- Dark/light mode toggle
- Mobile-optimized navigation
- Secure user authentication
- Shopping cart functionality
- Order management
- Product management
- Payment processing integration

## Technologies Used
- PHP 7.x+
- MySQL
- MDB Bootstrap UI Kit
- JavaScript
- HTML5/CSS3
- Font Awesome Icons

## Security Features
- Password hashing with PHP's password_hash()
- SQL injection prevention with prepared statements
- Session management
- Input validation and sanitization

## Mobile Experience
- Native-style UI with bottom navigation
- Touch-friendly elements
- Responsive grid layouts
- Optimized for thumb-friendly navigation

This website provides a complete solution for selling digital products with a focus on user experience, responsive design, and security.