<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<div class="content">
    <h2>📊 Sales Dashboard</h2>

    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="monthlySalesChart"></canvas>
    </div>

    <h3 style="text-align: center;">🛒 Featured Products</h3>
    <div class="product-gallery">
        <?php
        $products = [
            ["name" => "Laptop", "image" => "uploads/laptop.jpg"],
            ["name" => "Smartphone", "image" => "uploads/smartphone.jpg"],
            ["name" => "Headphones", "image" => "uploads/headphones.jpg"],
            ["name" => "Camera", "image" => "uploads/camera.jpg"],
            ["name" => "Smartwatch", "image" => "uploads/smartwatch.jpg"]
        ];

        foreach ($products as $product) {
            echo '<div class="product-item">
                    <img src="'.$product['image'].'" alt="'.$product['name'].'">
                    <div class="product-name">'.$product['name'].'</div>
                  </div>';
        }
        ?>
    </div>
</div>

<script>
const dailySalesData = {
    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
    datasets: [{
        label: "Daily Sales ($)",
        data: [500, 700, 800, 900, 1200, 1500, 1300],
        backgroundColor: "rgba(54, 162, 235, 0.6)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1
    }]
};

const salesChart = new Chart(document.getElementById("salesChart"), {
    type: "bar",
    data: dailySalesData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
    }
});

const monthlySalesData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: "Monthly Sales (₱)",
        data: [5000, 7000, 8000, 9000, 12000, 15000, 16000, 14000, 13000, 12000, 11000, 10000],
        borderColor: "rgba(255, 99, 132, 1)",
        fill: false,
        tension: 0.4
    }]
};

const monthlySalesChart = new Chart(document.getElementById("monthlySalesChart"), {
    type: "line",
    data: monthlySalesData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true } }
    }
});
</script>

</body>
</html>
