<?php
/* =========================
   DEFINE BASE URL (CRITICAL)
========================= */
define('BASE_URL', '/YBTDigital');

/* =========================
   Include Reviews System
========================= */
require_once '../includes/reviews.php';

$products = [
    ['id'=>1,'name'=>'Premium Web Template','price'=>49.99,'image'=>'web-template.jpg'],
    ['id'=>2,'name'=>'Mobile UI Kit','price'=>39.99,'image'=>'mobile-ui.jpg'],
    ['id'=>3,'name'=>'Icon Pack','price'=>29.99,'image'=>'icon-pack.jpg'],
    ['id'=>4,'name'=>'Development Tool','price'=>59.99,'image'=>'dev-tool.jpg'],
];

// Ensure fallback image exists
$fallback_image = file_exists($_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/assets/images/no-image.png') ? 
    BASE_URL . '/assets/images/no-image.png' : 
    'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Featured Products - YBT Digital</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="<?php echo BASE_URL; ?>/assets/css/star-rating.css" rel="stylesheet">

<style>
body{background:#f8f9fa}
.card{
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}
img{
    width:100%;
    height:180px;
    object-fit:cover;
}
.price{color:#4361ee;font-weight:bold}
</style>
</head>

<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Featured Products</h2>

    <div class="row">
        <?php foreach($products as $p): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">

                <!-- ✅ ABSOLUTE ROOT-RELATIVE IMAGE PATH -->
                <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo htmlspecialchars($p['image']); ?>"
                     alt="<?php echo htmlspecialchars($p['name']); ?>"
                     class="card-img-top"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='<?php echo $fallback_image; ?>';">

                <div class="card-body">
                    <h6><?php echo $p['name']; ?></h6>
                    
                    <!-- Display average rating -->
                    <?php
                    $avg_rating = getProductAverageRating($p['id']);
                    echo displayStarRating($avg_rating['average']);
                    ?>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price">$<?php echo $p['price']; ?></span>
                        <a href="<?php echo BASE_URL; ?>/products/detail.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">
                            View
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/star-rating.js"></script>
</body>
</html>