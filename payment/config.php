<?php
// Payment Gateway Configuration for YBT Digital

// Stripe Configuration
define('STRIPE_PUBLISHABLE_KEY', getenv('STRIPE_PUBLISHABLE_KEY'));
define('STRIPE_SECRET_KEY', getenv('STRIPE_SECRET_KEY'));

// PayPal Configuration
define('PAYPAL_CLIENT_ID', getenv('PAYPAL_CLIENT_ID'));
define('PAYPAL_CLIENT_SECRET', getenv('PAYPAL_CLIENT_SECRET'));

// Razorpay Configuration
define('RAZORPAY_KEY_ID', getenv('RAZORPAY_KEY_ID'));
define('RAZORPAY_KEY_SECRET', getenv('RAZORPAY_KEY_SECRET'));

// Payment Gateway Settings
define('DEFAULT_PAYMENT_GATEWAY', 'stripe'); // stripe, paypal, razorpay
define('ENABLE_STRIPE', true);
define('ENABLE_PAYPAL', false);
define('ENABLE_RAZORPAY', false);

// Currency Settings
define('CURRENCY_CODE', 'USD');
define('CURRENCY_SYMBOL', '$');

// Sandbox Mode
define('PAYMENT_SANDBOX', true);
