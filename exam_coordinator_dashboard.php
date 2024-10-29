<?php
include 'config.php';
session_start();
if ($_SESSION['user']['role'] != 'exam_coordinator') {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1>Exam Coordinator Dashboard</h1>
    <h3>Generate Exam Schedule</h3>
    <form method="POST" action="">
        <button type="submit" name="generate_schedule" class="btn btn-primary">Generate</button>
    </form>

    <?php
    if (isset($_POST['generate_schedule'])) {
        // Clear the existing schedule
        $conn->query("TRUNCATE TABLE exam_datesheet");

        // Fetch all required data from the database
        $courses = $conn->query("SELECT * FROM courses ORDER BY enrollment DESC");
        $halls = $conn->query("SELECT * FROM examination_halls ORDER BY capacity DESC");
        $superintendents = $conn->query("SELECT * FROM superintendents");

        // Store fetched data into arrays
        $hallData = [];
        while ($hall = $halls->fetch_assoc()) {
            $hallData[] = $hall;
        }

        $superintendentData = [];
        while ($superintendent = $superintendents->fetch_assoc()) {
            $superintendentData[] = $superintendent;
        }

        // Basic configuration for exam scheduling
        $currentSuperintendentIndex = 0;
        $currentHallIndex = 0;
        $examDate = date("Y-m-d"); // Starting date

        while ($course = $courses->fetch_assoc()) {
            $remainingEnrollment = $course['enrollment'];

            // Allocate examination halls for the course
            while ($remainingEnrollment > 0) {
                // Get the current hall and superintendent
                $hall = $hallData[$currentHallIndex];
                $superintendent = $superintendentData[$currentSuperintendentIndex];

                // Check how many students can fit in the current hall
                $assignedStudents = min($remainingEnrollment, $hall['capacity']);

                // Insert the scheduling data into the `exam_datesheet` table
                $stmt = $conn->prepare("INSERT INTO exam_datesheet (course_code, exam_date, hall_id, superintendent_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssii", $course['course_code'], $examDate, $hall['id'], $superintendent['id']);
                $stmt->execute();
                $stmt->close();

                // Reduce the remaining students for the course
                $remainingEnrollment -= $assignedStudents;

                // Move to the next hall and superintendent
                $currentHallIndex++;
                $currentSuperintendentIndex++;

                // If we have used all halls, reset the index and move to the next date
                if ($currentHallIndex >= count($hallData)) {
                    $currentHallIndex = 0;
                    $examDate = date('Y-m-d', strtotime($examDate . ' +1 day'));
                }

                // If we have used all superintendents, reset the index
                if ($currentSuperintendentIndex >= count($superintendentData)) {
                    $currentSuperintendentIndex = 0;
                }
            }
        }

        echo "<div class='alert alert-success mt-3'>Exam Schedule Generated Successfully.</div>";
    }
    ?>

    <h3 class="mt-5">Generated Exam Schedule</h3>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Course Code</th>
                <th>Exam Date</th>
                <th>Hall Name</th>
                <th>Superintendent</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $schedule = $conn->query("SELECT e.course_code, e.exam_date, h.hall_name, s.name as superintendent_name 
                                      FROM exam_datesheet e 
                                      JOIN examination_halls h ON e.hall_id = h.id 
                                      JOIN superintendents s ON e.superintendent_id = s.id 
                                      ORDER BY e.exam_date, e.course_code");

            if ($schedule->num_rows > 0) {
                while ($row = $schedule->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['course_code']}</td>
                            <td>" . date("d-m-Y", strtotime($row['exam_date'])) . "</td>
                            <td>{$row['hall_name']}</td>
                            <td>{$row['superintendent_name']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No exam schedule available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
