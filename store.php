<?php
include('db_connect.php'); // Include database connection

// Fetch all products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
.product-gallery {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .product-item {
            width: 200px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .product-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-name {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .product-price {
            font-size: 14px;
            color: green;
            margin-top: 5px;
        }
        .product-quantity {
            font-size: 14px;
            color: blue;
            margin-top: 5px;
        }
        .crud-actions {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <h4 class="text-white">POS System</h4>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="product.php">📦 Products</a>
    <a href="store.php">🛒 Store</a>
    <a href="orders.php">📊 Orders</a>
    <a href="cart.php">🛍 Cart</a>
</div>

<!-- Product Listings -->
<div class="container mt-5">
    <h2 class="text-center">Available Products</h2>
    <div class="row justify-content-center">
        <?php while ($product = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 d-flex justify-content-center mb-4">
                <div class="card">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text">Price: ₱<?php echo $product['price']; ?></p>
                        <p class="card-text">Available Stock: <?php echo $product['quantity']; ?></p>
                        
                      <!-- Buy Now Button (Redirects to order_product.php) -->
<a href="order_product.php?id=<?php echo $product['id']; ?>" class="btn btn-success w-100">Buy Now</a>

<!-- Add to Cart Button (Redirects to add_to_cart.php) -->
<a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100 mt-2">Add to Cart</a>


                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
