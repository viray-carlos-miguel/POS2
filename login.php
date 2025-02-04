<?php
// Database connection settings
$servername = "localhost";
$username = "root";         // MySQL username (default "root")
$password = "";             // MySQL password (default empty string)
$dbname = "db_pos";         // The database name

// Initialize error message
$emailErr = $passwordErr = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = cleanInput($_POST["password"]);
    }

    // If no errors, check if the user exists in the database
    if (empty($emailErr) && empty($passwordErr)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User exists, fetch the user data
            $stmt->bind_result($userId, $storedUsername, $storedPassword);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $storedPassword)) {
                echo "<p>Login successful! Welcome back, $storedUsername.</p>";
                // Here, you can set a session variable to keep the user logged in
                // Example: $_SESSION['user_id'] = $userId;
            } else {
                $passwordErr = "Incorrect password";
            }
        } else {
            $emailErr = "No user found with this email";
        }

        $stmt->close();
    }
}

// Function to clean input data
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General page styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Form container styling */
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            color: #007BFF;
        }

        /* Input field styling */
        label {
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 1rem;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.875rem;
            margin-bottom: 15px;
        }

        /* Link styling */
        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <!-- Email Field -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email">
        <div class="error"><?php echo $emailErr; ?></div>

        <!-- Password Field -->
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">
        <div class="error"><?php echo $passwordErr; ?></div>

        <input type="submit" value="Login" onclick="location.href='dashboard.php';">
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
</div>

</body>
</html>
