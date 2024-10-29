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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Black Theme for a bold look */
        body {
            background-color: #1c1c1c;
            color: #f0f0f0;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #333;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        h1, h3 {
            font-weight: 700;
            color: #ffcc00;
        }

        .btn {
            font-size: 1.2rem;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #ffcc00;
            color: #1c1c1c;
            border: none;
        }

        .btn-danger {
            background-color: #ff5733;
            color: #fff;
            border: none;
        }

        .btn-primary:hover, .btn-danger:hover {
            opacity: 0.9;
        }

        /* Table Styles */
        .table {
            background-color: #444;
            color: #f0f0f0;
        }

        .table th {
            background-color: #ffcc00;
            color: #1c1c1c;
        }

        .table tr:hover {
            background-color: #555;
        }

        .thead-dark th {
            color: #1c1c1c;
        }

        /* Add icons to buttons */
        .btn-primary i, .btn-danger i {
            margin-left: 8px;
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, <?php echo $username; ?></h1>
        <a href="logout.php" class="btn btn-danger mb-3"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <a href="enroll_courses.php" class="btn btn-primary mb-3"><i class="fas fa-book-open"></i> Enroll in Courses</a>

        <h3>Your Exam Schedule</h3>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Exam Date</th>
                    <th>Hall Name</th>
                    <th>Superintendent</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch the student's enrolled courses and exam schedule
                $query = "SELECT c.course_code, c.course_name, e.exam_date, h.hall_name, s.name AS superintendent
                          FROM enrollments en
                          JOIN courses c ON en.course_code = c.course_code
                          JOIN exam_datesheet e ON c.course_code = e.course_code
                          JOIN examination_halls h ON e.hall_id = h.id
                          JOIN superintendents s ON e.superintendent_id = s.id
                          WHERE en.user_id = $student_id";

                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['course_code']}</td>
                                <td>{$row['course_name']}</td>
                                <td>" . date("d-m-Y", strtotime($row['exam_date'])) . "</td>
                                <td>{$row['hall_name']}</td>
                                <td>{$row['superintendent']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No exams scheduled for you.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
