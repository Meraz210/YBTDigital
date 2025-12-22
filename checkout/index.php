<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php?redirect=../checkout/index.php');
    exit;
}

require_once '../includes/db.php';

// Initialize cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    if (isset($_GET['product_id'])) {
        $_SESSION['cart'] = [
            ['id' => (int)$_GET['product_id'], 'quantity' => 1]
        ];
    } else {
        header('Location: ../cart/index.php');
        exit;
    }
}
// Product data
$products = [
    1 => [
        'id' => 1,
        'name' => 'Premium Web Template',
        'price' => 49.99,
        'image' => 'Premium Web Template.jpeg'
    ]
];


    2 => [
        'id' => 2,
        'name' => 'Mobile UI Kit',
        'price' => 39.99,
        'image' => 'https://via.placeholder.com/100x100/3f37c9/ffffff?text=Mobile+UI'
    ],
    3 => [
        'id' => 3,
        'name' => 'Icon Pack',
        'price' => 29.99,
        'image' => 'https://via.placeholder.com/100x100/4cc9f0/ffffff?text=Icon+Pack'
    ],
    4 => [
        'id' => 4,
        'name' => 'Development Tool',
        'price' => 59.99,
        'image' => 'https://via.placeholder.com/100x100/f72585/ffffff?text=Dev+Tool'
    ]
];

// Build cart
$cart_items = [];
$cart_total = 0;

foreach ($_SESSION['cart'] as $item) {
    if (isset($products[$item['id']])) {
        $product = $products[$item['id']];
        $total = $product['price'] * $item['quantity'];
        $cart_total += $total;

        $cart_items[] = [
            'product' => $product,
            'quantity' => $item['quantity'],
            'total' => $total
        ];
    }
}

$tax = $cart_total * 0.10;
$grand_total = $cart_total + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - YBT Digital</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body { background:#f8f9fa; }
.checkout-card { box-shadow:0 10px 25px rgba(0,0,0,.1); }
.order-summary img { width:60px; height:60px; object-fit:cover; }
</style>
</head>

<body>

<nav class="navbar navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <i class="fas fa-store me-2"></i>YBT Digital
    </a>
    <span class="fw-bold">
      <i class="fas fa-user"></i>
      <?php echo htmlspecialchars($_SESSION['user_name']); ?>
    </span>
  </div>
</nav>

<div class="container my-5">
<h3 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Checkout</h3>

<div class="row">
<!-- Billing -->
<div class="col-lg-8 mb-4">
<div class="card checkout-card">
<div class="card-body">

<h5>Billing Information</h5>
<form method="POST">

<div class="row">
  <div class="col-md-6 mb-3">
    <input class="form-control" name="first_name" placeholder="First Name" required>
  </div>
  <div class="col-md-6 mb-3">
    <input class="form-control" name="last_name" placeholder="Last Name" required>
  </div>
</div>

<input class="form-control mb-3" name="email"
value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>

<input class="form-control mb-3" name="address" placeholder="Address" required>

<div class="row">
  <div class="col-md-6 mb-3"><input class="form-control" name="city" placeholder="City"></div>
  <div class="col-md-4 mb-3"><input class="form-control" name="state" placeholder="State"></div>
  <div class="col-md-2 mb-3"><input class="form-control" name="zip" placeholder="ZIP"></div>
</div>

<hr>

<h5>Payment</h5>

<input class="form-control mb-3" name="card_name" placeholder="Name on Card">
<input class="form-control mb-3" name="card_number" placeholder="0000 0000 0000 0000">
<div class="row">
  <div class="col-md-6 mb-3"><input class="form-control" name="card_expiry" placeholder="MM/YY"></div>
  <div class="col-md-6 mb-3"><input class="form-control" name="card_cvv" placeholder="CVV"></div>
</div>

<button class="btn btn-success btn-lg w-100">
<i class="fas fa-lock me-2"></i>
Pay $<?php echo number_format($grand_total,2); ?>
</button>

</form>
</div>
</div>
</div>

<!-- Order Summary -->
<div class="col-lg-4">
<div class="card checkout-card order-summary">
<div class="card-body">

<h5>Order Summary</h5>

<?php foreach ($cart_items as $item): ?>
<div class="d-flex align-items-center mb-3">
  <img src="<?php echo htmlspecialchars($item['product']['image']); ?>" class="rounded me-3">
  <div class="flex-grow-1">
    <strong><?php echo htmlspecialchars($item['product']['name']); ?></strong><br>
    <small>Qty: <?php echo $item['quantity']; ?></small>
  </div>
  <span>$<?php echo number_format($item['total'],2); ?></span>
</div>
<?php endforeach; ?>

<hr>

<div class="d-flex justify-content-between">
<span>Subtotal</span>
<span>$<?php echo number_format($cart_total,2); ?></span>
</div>

<div class="d-flex justify-content-between">
<span>Tax (10%)</span>
<span>$<?php echo number_format($tax,2); ?></span>
</div>

<div class="d-flex justify-content-between fw-bold mt-2">
<span>Total</span>
<span>$<?php echo number_format($grand_total,2); ?></span>
</div>

</div>
</div>
</div>

</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>
<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php?redirect=../checkout/index.php');
    exit;
}

require_once '../includes/db.php';

// Initialize cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    if (isset($_GET['product_id'])) {
        $_SESSION['cart'] = [
            ['id' => (int)$_GET['product_id'], 'quantity' => 1]
        ];
    } else {
        header('Location: ../cart/index.php');
        exit;
    }
}

// Product data
$products = [
    1 => [
        'id' => 1,
        'name' => 'Premium Web Template',
        'price' => 49.99,
        'image' => 'Premium Web Template.jpeg'
    ]
];
    
    2 => [
        'id' => 2,
        'name' => 'Mobile UI Kit',
        'price' => 39.99,
        'image' => 'https://via.placeholder.com/100x100/3f37c9/ffffff?text=Mobile+UI'
    ],
    3 => [
        'id' => 3,
        'name' => 'Icon Pack',
        'price' => 29.99,
        'image' => 'https://via.placeholder.com/100x100/4cc9f0/ffffff?text=Icon+Pack'
    ],
    4 => [
        'id' => 4,
        'name' => 'Development Tool',
        'price' => 59.99,
        'image' => 'https://via.placeholder.com/100x100/f72585/ffffff?text=Dev+Tool'
    ]
];

// Build cart
$cart_items = [];
$cart_total = 0;

foreach ($_SESSION['cart'] as $item) {
    if (isset($products[$item['id']])) {
        $product = $products[$item['id']];
        $total = $product['price'] * $item['quantity'];
        $cart_total += $total;

        $cart_items[] = [
            'product' => $product,
            'quantity' => $item['quantity'],
            'total' => $total
        ];
    }
}

$tax = $cart_total * 0.10;
$grand_total = $cart_total + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - YBT Digital</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body { background:#f8f9fa; }
.checkout-card { box-shadow:0 10px 25px rgba(0,0,0,.1); }
.order-summary img { width:60px; height:60px; object-fit:cover; }
</style>
</head>

<body>

<nav class="navbar navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <i class="fas fa-store me-2"></i>YBT Digital
    </a>
    <span class="fw-bold">
      <i class="fas fa-user"></i>
      <?php echo htmlspecialchars($_SESSION['user_name']); ?>
    </span>
  </div>
</nav>

<div class="container my-5">
<h3 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Checkout</h3>

<div class="row">
<!-- Billing -->
<div class="col-lg-8 mb-4">
<div class="card checkout-card">
<div class="card-body">

<h5>Billing Information</h5>
<form method="POST">

<div class="row">
  <div class="col-md-6 mb-3">
    <input class="form-control" name="first_name" placeholder="First Name" required>
  </div>
  <div class="col-md-6 mb-3">
    <input class="form-control" name="last_name" placeholder="Last Name" required>
  </div>
</div>

<input class="form-control mb-3" name="email"
value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>

<input class="form-control mb-3" name="address" placeholder="Address" required>

<div class="row">
  <div class="col-md-6 mb-3"><input class="form-control" name="city" placeholder="City"></div>
  <div class="col-md-4 mb-3"><input class="form-control" name="state" placeholder="State"></div>
  <div class="col-md-2 mb-3"><input class="form-control" name="zip" placeholder="ZIP"></div>
</div>

<hr>

<h5>Payment</h5>

<input class="form-control mb-3" name="card_name" placeholder="Name on Card">
<input class="form-control mb-3" name="card_number" placeholder="0000 0000 0000 0000">
<div class="row">
  <div class="col-md-6 mb-3"><input class="form-control" name="card_expiry" placeholder="MM/YY"></div>
  <div class="col-md-6 mb-3"><input class="form-control" name="card_cvv" placeholder="CVV"></div>
</div>

<button class="btn btn-success btn-lg w-100">
<i class="fas fa-lock me-2"></i>
Pay $<?php echo number_format($grand_total,2); ?>
</button>

</form>
</div>
</div>
</div>

<!-- Order Summary -->
<div class="col-lg-4">
<div class="card checkout-card order-summary">
<div class="card-body">

<h5>Order Summary</h5>

<?php foreach ($cart_items as $item): ?>
<div class="d-flex align-items-center mb-3">
  <img src="<?php echo htmlspecialchars($item['product']['image']); ?>" class="rounded me-3">
  <div class="flex-grow-1">
    <strong><?php echo htmlspecialchars($item['product']['name']); ?></strong><br>
    <small>Qty: <?php echo $item['quantity']; ?></small>
  </div>
  <span>$<?php echo number_format($item['total'],2); ?></span>
</div>
<?php endforeach; ?>

<hr>

<div class="d-flex justify-content-between">
<span>Subtotal</span>
<span>$<?php echo number_format($cart_total,2); ?></span>
</div>

<div class="d-flex justify-content-between">
<span>Tax (10%)</span>
<span>$<?php echo number_format($tax,2); ?></span>
</div>

<div class="d-flex justify-content-between fw-bold mt-2">
<span>Total</span>
<span>$<?php echo number_format($grand_total,2); ?></span>
</div>

</div>
</div>
</div>

</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>
