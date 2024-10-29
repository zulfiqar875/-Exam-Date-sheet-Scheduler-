<?php
include 'config.php';
session_start();

// Check if the user is logged in and is a superintendent
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'superintendent') {
    header("Location: login.php");
    exit;
}

$superintendent_sid = $_SESSION['user']['sid']; // Fetch superintendent ID from session
$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superintendent Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Background and container styling */
        body {
            background-image: url('https://t4.ftcdn.net/jpg/02/64/10/47/360_F_264104799_Xn6rzSgOwVR7lbMfcl8DsyNzI3Gqsh1p.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #007bff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h3 {
            font-weight: 600;
            color: #007bff;
            text-align: center;
        }

        .btn-danger {
            float: right;
            font-size: 1.2rem;
        }

        .table {
            margin-top: 30px;
            animation: fadeIn 1s ease-in-out;
        }

        .thead-dark th {
            background-color: #007bff;
            color: white;
        }

        /* Loading animation */
        #loading-animation {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .spinner-border {
            width: 4rem;
            height: 4rem;
            color: #007bff;
        }

        /* Keyframes for table animation */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Loading Animation -->
    <div id="loading-animation">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container" id="main-content" style="display: none;">
        <h1>Welcome, Superintendent <?php echo $username; ?></h1>
        <a href="logout.php" class="btn btn-danger mb-3"><i class="fas fa-sign-out-alt"></i> Logout</a>

        <h3>Your Assigned Examination Halls and Exams</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Exam Date</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Hall Name</th>
                    <th>Capacity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch the exams assigned to this superintendent
                $query = "SELECT e.exam_date, c.course_code, c.course_name, h.hall_name, h.capacity
                        FROM exam_datesheet e
                        JOIN courses c ON e.course_code = c.course_code
                        JOIN examination_halls h ON e.hall_id = h.id
                        WHERE e.superintendent_id = $superintendent_sid";


                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . date("d-m-Y", strtotime($row['exam_date'])) . "</td>
                                <td>{$row['course_code']}</td>
                                <td>{$row['course_name']}</td>
                                <td>{$row['hall_name']}</td>
                                <td>{$row['capacity']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No exams assigned to you yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Show loading animation while data is being processed
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loading-animation").style.display = "none"; // Hide loading animation
                document.getElementById("main-content").style.display = "block";    // Show main content
                document.getElementById("main-content").style.opacity = 1;
                document.getElementById("main-content").style.transform = "translateY(0)";
            }, 2000); // Simulate loading time of 2 seconds
        });
    </script>
</body>
</html>
