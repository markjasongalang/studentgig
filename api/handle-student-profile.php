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

    // Change photo


    // Edit Profile
    $first_name = $last_name = $email = $university = $degree = $year_level = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_profile'])) {
        if (empty($_POST['first_name'])) {
            $errors['first_name_err'] = 'First name is required';
        } else {
            $first_name = sanitize_input($_POST['first_name']);
        }

        if (empty($_POST['last_name'])) {
            $errors['last_name_err'] = 'Last name is required';
        } else {
            $last_name = sanitize_input($_POST['last_name']);
        }

        if (empty($_POST['email'])) {
            $errors['email_err'] = 'Email is required';
        } else {
            $email = sanitize_input($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email_err'] = 'Invalid email format';
            } else {
                $sql = 'SELECT username, email FROM students WHERE email = ?
                        UNION
                        SELECT username, email FROM gig_creators WHERE email = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $email, $email);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        if ($row['email'] === $email && $row['username'] != $username) {
                            $errors['email_err'] = 'Email is already taken';
                            break;
                        }
                    }
                } else {
                    $errors['email_err'] = 'There was a problem in verifying your email';
                }
                $stmt->close();
            }
        }

        if (empty($_POST['university'])) {
            $errors['university_err'] = 'University is required';
        } else {
            $university = sanitize_input($_POST['university']);
        }

        if (empty($_POST['degree'])) {
            $errors['degree_err'] = 'Degree is required';
        } else {
            $degree = sanitize_input($_POST['degree']);
        }

        if (empty($_POST['year_level'])) {
            $errors['year_level_err'] = 'Year level is required';
        } else {
            $year_level = sanitize_input($_POST['year_level']);
        }

        if (empty($errors)) {
            // Enable exceptions for mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $sql = 'UPDATE students SET first_name = ?, last_name = ?, email = ?, university = ?, degree_program = ?, year_level = ? WHERE username = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssssss', $first_name, $last_name, $email, $university, $degree, $year_level, $username);
                $stmt->execute();

                $response['success'] = true;
            } catch (mysqli_sql_exception $e) {
                $errors['db_err'] = 'Couldn\'t update profile details';
                $response['success'] = false;
                $response['errors'] = $errors;
            } finally {
                if (isset($stmt)) {
                    $stmt->close();
                }
                $conn->close();
            }
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    // Retrieve gigs of student
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_gigs'])) {
        $response['sample'] = 'student gigs!';
    }

    exit(json_encode($response));
?>