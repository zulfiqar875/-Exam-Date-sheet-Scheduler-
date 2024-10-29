<?php
include 'config.php';
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

// Handle course enrollment
if (isset($_POST['enroll'])) {
    $code = $_POST['code'];  // Get course code from the button
    $limit = $_POST['limit'];

    // echo "<script>alert('.$code.');</script>";
    // Check if the student is already enrolled in the course
    $check_enrollment = "SELECT * FROM enrollments WHERE user_id = $student_id AND course_code = '$code'";
    $result = $conn->query($check_enrollment);

    if ($result->num_rows > 0) {
        echo "<script>alert('You are already enrolled in this course.');</script>";
    } else {
        // Check if the enrollment limit for the course has been reached
        $enrollment_check_query = "SELECT COUNT(*) AS current_enrollments, c.enrollment AS max_enrollment 
                                   FROM enrollments e 
                                   RIGHT JOIN courses c ON e.course_code = c.course_code 
                                   WHERE c.course_code = '$code'";
        $enrollment_result = $conn->query($enrollment_check_query);
        $enrollment_data = $enrollment_result->fetch_assoc();

        $current_enrollments = $enrollment_data['current_enrollments'];
        $max_enrollment = $enrollment_data['max_enrollment'];

        if ($current_enrollments >= $max_enrollment) {
            echo "<script>alert('The enrollment limit for this course has been reached.');</script>";
        } else {
            // Enroll the student in the selected course
            $enroll_query = "INSERT INTO enrollments (user_id, course_code) VALUES ($student_id, '$code')";
            if ($conn->query($enroll_query)) {
                echo "<script>alert('Successfully enrolled in course $code.');</script>";
            } else {
                echo "<script>alert('Error enrolling in course: " . $conn->error . "');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Black Theme */
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            background-color: #1c1c1c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        h1 {
            font-weight: bold;
            color: #ffcc00;
            text-shadow: 0 0 10px rgba(255, 255, 0, 0.8);
        }

        h3 {
            color: #00e676;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.7);
        }

        /* Button Styling */
        .btn {
            font-size: 1.1rem;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #ffcc00;
            color: #1c1c1c;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ffdd33;
            box-shadow: 0 0 12px rgba(255, 255, 0, 0.7);
            transform: scale(1.05);
        }

        .btn-secondary {
            background-color: #00e676;
            color: #1c1c1c;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #33ff77;
            box-shadow: 0 0 12px rgba(0, 255, 0, 0.7);
            transform: scale(1.05);
        }

        /* Table Styling */
        .table {
            background-color: #2c2c2c;
            color: #f0f0f0;
        }

        .table th {
            background-color: #00e676;
            color: #121212;
        }

        .table tr:hover {
            background-color: #444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $username; ?> - Enroll in Courses</h1>
        <a href="student_dashboard.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Go to Dashboard</a>

        <h3>Available Courses</h3>
        <form method="POST" action="">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <!-- <th>Enrollment Left</th>
                        <th>Current Enrollment</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all available courses
                    $query = "SELECT c.course_code, c.course_name, c.enrollment AS max_enrollment, 
                             (SELECT COUNT(*) FROM enrollments e WHERE e.course_code = c.course_code) AS current_enrollment 
                             FROM courses c";
                    $courses = $conn->query($query);

                    if ($courses->num_rows > 0) {
                        while ($course = $courses->fetch_assoc()) {
                            $remaining_spots = $course['max_enrollment'] - $course['current_enrollment'];
                            $disabled = $remaining_spots <= 0 ? 'disabled' : '';
                            
                            echo "<tr>
                                    <td>{$course['course_code']}</td>
                                    <td>{$course['course_name']}</td>
                                    
                                    <td>
                                        <form action='' method='post'>
                                            <input type='hidden' name='code' value='{$course['course_code']}'>
                                            <input type='hidden' name='limit' value='{$course['max_enrollment']}'>
                                            <button type='submit' name='enroll' class='btn btn-primary' $disabled>Enroll</button>
                                        </form>
                                        
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No courses available for enrollment.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
