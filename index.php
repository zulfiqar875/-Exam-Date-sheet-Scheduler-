<?php
session_start();
include 'config.php';

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    // Redirect to the corresponding dashboard based on role
    switch ($role) {
        case 'admin':
            header("Location: admin_dashboard.php");
            break;
        case 'exam_coordinator':
            header("Location: coordinator_dashboard.php");
            break;
        case 'superintendent':
            header("Location: super_dashboard.php");
            break;
        case 'student':
            header("Location: student_dashboard.php");
            break;
        default:
            header("Location: login.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Scheduling System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f4f7;
            font-family: 'Arial', sans-serif;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #007bff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #007bff;
        }

        .card-text {
            font-size: 1rem;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Title -->
        <h1 class="text-center mb-5">Welcome to the Exam Scheduling System</h1>

        <!-- Login Button -->
        <div class="text-center">
            <a href="login.php" class="btn btn-primary">Login</a>
        </div>

        <!-- Role Cards -->
        <div class="row mt-5">
            <!-- Admin Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Admin</h5>
                        <p class="card-text">Admins can manage courses, examination halls, superintendents, and user roles.</p>
                    </div>
                </div>
            </div>

            <!-- Exam Coordinator Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Exam Coordinator</h5>
                        <p class="card-text">The Exam Coordinator can manage exam scheduling and generate exam date sheets.</p>
                    </div>
                </div>
            </div>

            <!-- Superintendent Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Superintendent</h5>
                        <p class="card-text">Superintendents can view assigned examination halls and details.</p>
                    </div>
                </div>
            </div>

            <!-- Student Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Student</h5>
                        <p class="card-text">Students can view their exam schedules and other related details.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
