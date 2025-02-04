<?php
session_start();
include('db_connect.php'); // Include database connection

// Fetch all cart items
$query = "SELECT cart.id AS cart_id, products.id AS product_id, products.name, products.image, cart.quantity, cart.total_price 
          FROM cart 
          INNER JOIN products ON cart.product_id = products.id";
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
    <title>Shopping Cart</title>
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

<!-- Cart Section -->
<div class="container mt-5">
    <h2 class="text-center">Your Cart</h2>
    <div class="row justify-content-center">
        <?php while ($cart_item = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 d-flex justify-content-center mb-4">
                <div class="card">
                    <img src="<?php echo $cart_item['image']; ?>" class="card-img-top" alt="<?php echo $cart_item['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $cart_item['name']; ?></h5>
                        <p class="card-text">Quantity: <?php echo $cart_item['quantity']; ?></p>
                        <p class="card-text">Total Price: ₱<?php echo $cart_item['total_price']; ?></p>

                        <!-- Buy Now Button -->
                        <form method="POST" action="process_cart.php">
                            <input type="hidden" name="cart_id" value="<?php echo $cart_item['cart_id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $cart_item['product_id']; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $cart_item['quantity']; ?>">
                            <input type="hidden" name="total_price" value="<?php echo $cart_item['total_price']; ?>">
                            <button type="submit" name="buy_now" class="btn btn-success w-100 mt-2">Buy Now</button>
                        </form>

                        <!-- Remove Button -->
                        <form method="POST" action="process_cart.php">
                            <input type="hidden" name="cart_id" value="<?php echo $cart_item['cart_id']; ?>">
                            <button type="submit" name="remove_from_cart" class="btn btn-danger w-100 mt-2">Remove</button>
                        </form>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
