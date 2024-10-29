<?php
include 'config.php';
session_start();
if ($_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* Background and container styling */
        body {
            background-image: url('https://t4.ftcdn.net/jpg/02/64/10/47/360_F_264104799_Xn6rzSgOwVR7lbMfcl8DsyNzI3Gqsh1p.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #007bff;
            text-align: center;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .btn {
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-group .btn {
            padding: 10px 20px;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        /* Animation for sections */
        .toggle-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .toggle-section.active {
            display: block;
            opacity: 1;
        }

        /* Custom table header */
        .thead-dark th {
            background-color: #007bff;
            color: white;
        }

        /* Logout button style */
        .btn-danger {
            font-size: 1.1rem;
            padding: 10px 20px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1><i class="fas fa-user-shield"></i> Admin Dashboard</h1>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        <!-- Navigation Buttons -->
        <div class="btn-group mb-4" role="group">
            <button type="button" class="btn btn-primary" id="btn-course"><i class="fas fa-book"></i> Manage Courses</button>
            <button type="button" class="btn btn-secondary" id="btn-hall"><i class="fas fa-building"></i> Manage Examination Halls</button>
            <button type="button" class="btn btn-success" id="btn-superintendent"><i class="fas fa-user-tie"></i> Manage Superintendents</button>
        </div>

        <!-- Manage Courses Section -->
        <div id="course-section" class="toggle-section active">
            <h3>Manage Courses</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Course Code:</label>
                    <input type="text" name="course_code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Course Name:</label>
                    <input type="text" name="course_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Enrollment:</label>
                    <input type="number" name="enrollment" class="form-control" required>
                </div>
                <button type="submit" name="add_course" class="btn btn-success"><i class="fas fa-plus"></i> Add Course</button>
            </form>

            <?php
            if (isset($_POST['add_course'])) {
                $course_code = $_POST['course_code'];
                $course_name = $_POST['course_name'];
                $enrollment = $_POST['enrollment'];

                $query = "INSERT INTO courses (course_code, course_name, enrollment) VALUES ('$course_code', '$course_name', $enrollment)";
                if ($conn->query($query)) {
                    echo "<div class='alert alert-success mt-3'>Course added successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
                }
            }
            ?>
            <!-- Display Courses -->
            <h4 class="mt-5">Courses</h4>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Enrollment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $courses = $conn->query("SELECT * FROM courses");
                    while ($course = $courses->fetch_assoc()) {
                        echo "<tr>
                                <td>{$course['course_code']}</td>
                                <td>{$course['course_name']}</td>
                                <td>{$course['enrollment']}</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Manage Examination Halls Section -->
        <div id="hall-section" class="toggle-section">
            <h3>Manage Examination Halls</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Hall Name:</label>
                    <input type="text" name="hall_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Capacity:</label>
                    <input type="number" name="capacity" class="form-control" required>
                </div>
                <button type="submit" name="add_hall" class="btn btn-success"><i class="fas fa-plus"></i> Add Hall</button>
            </form>

            <?php
            if (isset($_POST['add_hall'])) {
                $hall_name = $_POST['hall_name'];
                $capacity = $_POST['capacity'];

                $query = "INSERT INTO examination_halls (hall_name, capacity) VALUES ('$hall_name', $capacity)";
                if ($conn->query($query)) {
                    echo "<div class='alert alert-success mt-3'>Examination hall added successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
                }
            }
            ?>
            <!-- Display Halls -->
            <h4 class="mt-5">Examination Halls</h4>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Hall Name</th>
                        <th>Capacity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $halls = $conn->query("SELECT * FROM examination_halls");
                    while ($hall = $halls->fetch_assoc()) {
                        echo "<tr>
                                <td>{$hall['hall_name']}</td>
                                <td>{$hall['capacity']}</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Manage Superintendents Section -->
        <div id="superintendent-section" class="toggle-section">
            <h3>Manage Superintendents</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Superintendent Name:</label>
                    <input type="text" name="superintendent_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Contact:</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>
                <button type="submit" name="add_superintendent" class="btn btn-success"><i class="fas fa-plus"></i> Add Superintendent</button>
            </form>

            <?php
            if (isset($_POST['add_superintendent'])) {
                $superintendent_name = trim($_POST['superintendent_name']);
                $contact = trim($_POST['contact']);
                $check_superintendent_query = "SELECT * FROM superintendents WHERE name = '$superintendent_name' OR contact = '$contact'";
                $check_superintendent_result = $conn->query($check_superintendent_query);

                if ($check_superintendent_result->num_rows > 0) {
                    echo "<div class='alert alert-warning mt-3'>A superintendent with this name or contact already exists. Please use a different name or contact.</div>";
                } else {
                    $username = strtolower(str_replace(' ', '', $superintendent_name));
                    $check_user_query = "SELECT * FROM users WHERE username = '$username'";
                    $check_user_result = $conn->query($check_user_query);

                    if ($check_user_result->num_rows > 0) {
                        echo "<div class='alert alert-warning mt-3'>A user with this username already exists. Please use a different name.</div>";
                    } else {
                        $query = "INSERT INTO superintendents (name, contact) VALUES ('$superintendent_name', '$contact')";
                        if ($conn->query($query)) {
                            $superintendent_id = $conn->insert_id;
                            $password = substr(rand(), 0, 8);
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $user_query = "INSERT INTO users (sid, username, password, role) VALUES ('$superintendent_id', '$username', '$hashed_password', 'superintendent')";
                            if ($conn->query($user_query)) {
                                echo "<div class='alert alert-success mt-3'>
                                        Superintendent added successfully.<br>
                                        Username: <strong>$username</strong><br>
                                        Password: <strong>$password</strong>
                                    </div>";
                            } else {
                                echo "<div class='alert alert-danger mt-3'>Error adding superintendent to users table: " . $conn->error . "</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Error adding superintendent to superintendents table: " . $conn->error . "</div>";
                        }
                    }
                }
            }
            ?>
            <!-- Display Superintendents -->
            <h4 class="mt-5">Superintendents</h4>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $superintendents = $conn->query("SELECT * FROM superintendents");
                    while ($superintendent = $superintendents->fetch_assoc()) {
                        echo "<tr>
                                <td>{$superintendent['name']}</td>
                                <td>{$superintendent['contact']}</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Show the course section on page load
            $('#course-section').addClass('active');

            // Toggle visibility of sections with smooth animation
            $('#btn-course').click(function() {
                $('.toggle-section').removeClass('active');
                $('#course-section').addClass('active');
            });

            $('#btn-hall').click(function() {
                $('.toggle-section').removeClass('active');
                $('#hall-section').addClass('active');
            });

            $('#btn-superintendent').click(function() {
                $('.toggle-section').removeClass('active');
                $('#superintendent-section').addClass('active');
            });
        });
    </script>

</body>
</html>
