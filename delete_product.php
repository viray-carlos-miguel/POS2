<?php
include('db_connect.php'); // Include database connection

// Check if product ID is provided
if (!isset($_GET['id'])) {
    header("Location: product.php"); // Redirect if no ID is provided
    exit();
}

$id = intval($_GET['id']);

// Get the image path before deleting the product
$query = "SELECT image FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: product.php"); // Redirect if product not found
    exit();
}

// Delete image file if it exists
if (!empty($product['image']) && file_exists($product['image'])) {
    unlink($product['image']);
}

// Delete product from database
$query = "DELETE FROM products WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: product.php"); // Redirect to products page
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
