<?php
    include '../connection.php';

    session_start();

    header('Content-Type: application/json');

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $username = isset($_GET['u']) ? $_GET['u'] : '';

    $response = [];
    $errors = [];

    // Retrieve Student Details
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['get_gigs'])) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'SELECT id, email, first_name, last_name, university, year_level, degree_program, profile_image_path FROM students WHERE username = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $response['success'] = true;
            $response['student'] = $row;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in retrieving student details';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    // Edit Profile
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_profile'])) {
        $response['sample'] = 'Edit profile!';
    }

    // Retrieve gigs of student
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_gigs'])) {
        $response['sample'] = 'student gigs!';
    }

    exit(json_encode($response));
?>