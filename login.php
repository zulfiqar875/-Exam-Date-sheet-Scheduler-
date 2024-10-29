<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Hash the password using MD5

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row;
        header("Location: " . $row['role'] . "_dashboard.php");
    } else {
        echo "<div class='alert alert-danger mt-3'>Invalid username or password.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Exam Scheduling System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f4f7;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 1rem;
        }

        .register-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: 600;
        }

        .register-link a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            </form>
            <!-- Navigation link to the register page -->
            
        </div>
    </div>

</body>
</html>
