# YBT Digital - Digital Product Selling Website

A complete, production-ready digital product selling website built with PHP, MySQL, and JavaScript. The platform features both user frontend and admin backend with comprehensive functionality for selling digital products.

## Features

### User Side (Frontend)
- User authentication (Signup, Login, Forgot Password)
- Product browsing with filtering and search
- Product detail pages with screenshots and descriptions
- Shopping cart functionality
- Secure checkout with multiple payment gateways
- Order management and download access
- Rating and review system
- Responsive design for all devices

### Admin Side (Backend)
- Secure admin authentication
- Product management (Add/Edit/Delete)
- Order management with status updates
- User management with role control
- Coupon system for discounts
- Sales reports and analytics
- Payment gateway configuration
- Content management

## Tech Stack

- **Frontend**: PHP, HTML, CSS (MDBootstrap UI Kit), JavaScript
- **Backend**: PHP (procedural, no framework), MySQL
- **Payment Gateways**: Stripe, Razorpay, PayPal (configurable)
- **Security**: Prepared statements, input validation, session management

## Installation

1. Clone or copy the project to your web server directory
2. Create a MySQL database for the project
3. Import the database schema from `database/schema.sql`
4. Update database credentials in `.env` or `config/config.php`
5. Set up your web server to point to the project directory
6. Ensure the following directories are writable:
   - `/uploads/`
   - `/uploads/products/`

## Project Structure

```
YBTDigital/
├── app/
│   ├── controllers/      # MVC Controllers
│   └── models/          # MVC Models
├── assets/
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── images/         # Images
├── config/             # Configuration files
├── database/           # Database schema
├── resources/
│   └── views/         # MVC Views
├── uploads/           # User uploaded files
├── api/               # API endpoints
├── cart/              # Cart functionality
├── checkout/          # Checkout functionality
├── products/          # Product pages
└── user/              # User pages
```

## Security Features

- SQL injection prevention with prepared statements
- XSS protection with input sanitization
- Secure session management
- File upload validation
- Access control for admin areas
- Password hashing with PHP's password_hash function

## Payment Integration

The system supports multiple payment gateways:
- Stripe
- Razorpay
- PayPal

Admins can configure these through the admin panel.

## MVC Architecture

The application follows a Model-View-Controller pattern:

- **Models**: Handle database operations and business logic
- **Views**: Handle presentation and user interface
- **Controllers**: Handle request routing and coordination

## Customization

The platform is designed to be easily customizable:
- UI components can be modified in the views
- Business logic is contained in the models
- Controllers manage the flow between models and views

## Support

For support, please contact the development team or refer to the documentation.