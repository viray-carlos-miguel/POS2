<?php
session_start();
include('db_connect.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    die("Error: Invalid request.");
}

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

// Fetch product details
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = mysqli_query($conn, $product_query);

if (!$product_result || mysqli_num_rows($product_result) == 0) {
    die("Error: Product not found.");
}

$product = mysqli_fetch_assoc($product_result);

// Ensure enough stock is available
if ($product['quantity'] >= $quantity) {
    $total_price = $product['price'] * $quantity;

    if (isset($_POST['buy'])) {
        // Insert into orders table
        $insert_order_query = "INSERT INTO orders (product_id, quantity, total_price) 
                               VALUES ('$product_id', '$quantity', '$total_price')";
        mysqli_query($conn, $insert_order_query);

        // Decrease product stock
        $update_stock_query = "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id";
        mysqli_query($conn, $update_stock_query);

        // Redirect to orders page
        header("Location: orders.php");
        exit();
    } elseif (isset($_POST['add_to_cart'])) {
        // Check if product already exists in cart
        $cart_check_query = "SELECT * FROM cart WHERE product_id = '$product_id'";
        $cart_check_result = mysqli_query($conn, $cart_check_query);

        if (mysqli_num_rows($cart_check_result) > 0) {
            // Update existing cart item
            $cart_update_query = "UPDATE cart 
                                  SET quantity = quantity + $quantity, 
                                      total_price = total_price + $total_price 
                                  WHERE product_id = '$product_id'";
            mysqli_query($conn, $cart_update_query);
        } else {
            // Insert new item into cart
            $cart_insert_query = "INSERT INTO cart (product_id, quantity, total_price) 
                                  VALUES ('$product_id', '$quantity', '$total_price')";
            mysqli_query($conn, $cart_insert_query);
        }

        // Redirect to cart page
        header("Location: cart.php");
        exit();
    }
} else {
    die("Error: Not enough stock available.");
}
?>
