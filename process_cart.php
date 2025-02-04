<?php
session_start();
include('db_connect.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Buy Now - Move item from cart to orders
    if (isset($_POST['buy_now'])) {
        $cart_id = intval($_POST['cart_id']);
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $total_price = floatval($_POST['total_price']);

        // Insert into orders table
        $insert_order_query = "INSERT INTO orders (product_id, quantity, total_price) 
                               VALUES ('$product_id', '$quantity', '$total_price')";
        if (mysqli_query($conn, $insert_order_query)) {
            // Remove item from cart after ordering
            $delete_cart_query = "DELETE FROM cart WHERE id = $cart_id";
            mysqli_query($conn, $delete_cart_query);

            // Reduce stock in products table
            $update_stock_query = "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id";
            mysqli_query($conn, $update_stock_query);

            // Redirect to orders page
            header("Location: orders.php");
            exit();
        } else {
            echo "Error processing order: " . mysqli_error($conn);
        }
    }

    // Remove from Cart
    if (isset($_POST['remove_from_cart'])) {
        $cart_id = intval($_POST['cart_id']);

        // Delete from cart table
        $delete_query = "DELETE FROM cart WHERE id = $cart_id";
        if (mysqli_query($conn, $delete_query)) {
            // Redirect back to cart
            header("Location: cart.php");
            exit();
        } else {
            echo "Error removing from cart: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request.";
}
?>
