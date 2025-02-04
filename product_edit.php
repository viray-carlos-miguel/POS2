<?php
include('db_connect.php'); // Include database connection

// Check if product ID is provided
if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = intval($_GET['id']); // Get product ID
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = intval($_POST['quantity']); // Get updated quantity
    $image = $product['image']; // Keep old image if no new one is uploaded

    // Handle Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = mysqli_real_escape_string($conn, $target_file);
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }
    
    // Update product in the database
    $query = "UPDATE products SET name='$name', price='$price', quantity='$quantity', image='$image' WHERE id=$id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: product.php"); // Redirect to products page
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
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
<div class="container mt-5">
    <h2 class="text-center">Edit Product</h2>
    <form method="POST" action="product_edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price (₱)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="<?php echo $product['image']; ?>" alt="Product Image" width="150">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload New Image (Optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Update Product</button>
    </form>
</div>

</body>
</html>
