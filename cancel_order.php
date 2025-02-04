<?php
session_start();
include('db_connect.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Fetch the order details before deleting
    $order_query = "SELECT * FROM orders WHERE id = $order_id";
    $order_result = mysqli_query($conn, $order_query);
    
    if (!$order_result || mysqli_num_rows($order_result) == 0) {
        die("Error: Order not found.");
    }

    $order = mysqli_fetch_assoc($order_result);
    $product_id = $order['product_id'];
    $quantity = $order['quantity'];

    // Delete the order from the database
    $delete_query = "DELETE FROM orders WHERE id = $order_id";
    if (mysqli_query($conn, $delete_query)) {
        // Restore product stock
        $restore_stock_query = "UPDATE products SET quantity = quantity + $quantity WHERE id = $product_id";
        mysqli_query($conn, $restore_stock_query);

        // Redirect back to orders page
        header("Location: orders.php");
        exit();
    } else {
        echo "Error canceling order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
