<?php
include('db_connect.php'); // Include database connection

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Ensure ID is an integer
    $query = "DELETE FROM products WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: product.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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
<div class="sidebar">
    <h4 class="text-white">POS System</h4>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="product.php">📦 Products</a>
    <a href="store.php">👥 Store</a>
    <a href="orders.php">📊 Orders</a>
    <a href="cart.php">⚙️ Cart</a>
</div>

<div class="container">
    <h2 class="text-center mt-4">Product List</h2>
    <a href="add_product.php" class="btn btn-primary mb-3">Add New Product</a>
    <div class="product-gallery">
        <?php
        $query = "SELECT id, name, image, price, quantity FROM products";
        $result = mysqli_query($conn, $query);

        // Check if the query executed successfully
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn)); // Debugging SQL errors
        }

        // Fetch and display products
        while ($product = mysqli_fetch_assoc($result)) {
            echo '<div class="product-item">
                    <img src="'.$product['image'].'" alt="'.$product['name'].'">
                    <div class="product-name">'.$product['name'].'</div>
                    <div class="product-price">₱'.$product['price'].'</div>
                    <div class="product-quantity">Stock: '.$product['quantity'].'</div>
                    <div class="crud-actions">
                        <a href="product_edit.php?id='.$product['id'].'" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_product.php?id='.$product['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(&quot;Are you sure you want to delete this product?&quot;)">Delete</a>


                        </div>
                  </div>';
        }
        ?>
    </div>
</div>

</body>
</html>
