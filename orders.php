<?php
session_start();
include('db_connect.php'); // Include database connection

// Fetch all orders
$query = "SELECT orders.id AS order_id, products.name, products.image, orders.quantity, orders.total_price 
          FROM orders 
          INNER JOIN products ON orders.product_id = products.id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn)); // Debugging SQL errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
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

<!-- Orders Section -->
<div class="container mt-5">
    <h2 class="text-center">Your Orders</h2>
    <div class="row justify-content-center">
        <?php while ($order = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 d-flex justify-content-center mb-4">
                <div class="card">
                    <img src="<?php echo $order['image']; ?>" class="card-img-top" alt="<?php echo $order['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $order['name']; ?></h5>
                        <p class="card-text">Quantity: <?php echo $order['quantity']; ?></p>
                        <p class="card-text">Total Price: ₱<?php echo $order['total_price']; ?></p>

                        <!-- Cancel Order Button -->
                        <form method="POST" action="cancel_order.php">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" name="cancel_order" class="btn btn-danger w-100 mt-2">Cancel Order</button>
                        </form>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
