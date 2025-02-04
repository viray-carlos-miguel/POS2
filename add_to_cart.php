<?php
session_start();
include('db_connect.php'); // Include database connection

// Check if product ID is provided
if (!isset($_GET['id'])) {
    die("Error: Product ID not provided.");
}

$product_id = intval($_GET['id']);

// Fetch product details
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = mysqli_query($conn, $product_query);

if (!$product_result || mysqli_num_rows($product_result) == 0) {
    die("Error: Product not found.");
}

$product = mysqli_fetch_assoc($product_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
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

<!-- Add to Cart Form -->
<div class="container mt-5">
    <h2 class="text-center">Add to Cart</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text">Price: ₱<?php echo $product['price']; ?></p>
                    <p class="card-text">Available Stock: <?php echo $product['quantity']; ?></p>

                    <!-- Add to Cart Form -->
                    <form method="POST" action="process_order.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="quantity" class="form-label">Select Quantity:</label>
                        <input type="number" name="quantity" class="form-control mb-2" min="1" max="<?php echo $product['quantity']; ?>" required>

                        <button type="submit" name="add_to_cart" class="btn btn-primary w-100 mt-2">Confirm Add to Cart</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
