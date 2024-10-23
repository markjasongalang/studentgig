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

    $gig_id = isset($_GET['g']) ? $_GET['g'] : '';
    
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

    $response = [];
    $errors = [];

    // Retrieve Gig Details
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Enable exceptions for mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'SELECT title, duration_value, duration_unit, description, skills, schedule, payment_amount, payment_unit, gig_type, address, status FROM gigs WHERE id = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $gig_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($role == 'student') {
                $sql = 'SELECT gig_id, student FROM applicants WHERE gig_id = ? AND student = ? LIMIT 1';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $gig_id, $username);
                $stmt->execute();
                
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $response['student_applied'] = true;
                }
            }

            $response['success'] = true;
            $response['gig'] = $row;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in retrieving gig details';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    // Update Gig
    $gig_title = $duration_value = $duration_unit = $description = $skills = $schedule = '';
    $payment_value = $payment_unit = $gig_type = $address = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_gig'])) {
        if (empty($_POST['gig_title'])) {
            $errors['gig_title_err'] = 'Gig Title is required';
        } else {
            $gig_title = sanitize_input($_POST['gig_title']);
        }

        if (empty($_POST['duration_value'])) {
            $errors['duration_err'] = 'Duration is required';
        } else {
            $duration_value = sanitize_input($_POST['duration_value']);
        }

        $duration_unit = $_POST['duration_unit'];

        if (empty($_POST['description'])) {
            $errors['description_err'] = 'Description is required';
        } else {
            $description = sanitize_input($_POST['description']);
        }

        if (empty($_POST['skills'])) {
            $errors['skills_err'] = 'Preferred Skills is required';
        } else {
            $skills = sanitize_input($_POST['skills']);
        }

        if (empty($_POST['schedule'])) {
            $errors['schedule_err'] = 'Schedule is required';
        } else {
            $schedule = sanitize_input($_POST['schedule']);
        }

        if (empty($_POST['payment_value'])) {
            $errors['payment_err'] = 'Payment is required';
        } else {
            $payment_value = sanitize_input($_POST['payment_value']);
        }

        $payment_unit = $_POST['payment_unit'];

        $gig_type = $_POST['gig_type'];

        if ($gig_type != 'Remote' && empty($_POST['address'])) {
            $errors['address_err'] = 'Address is required';
        } else {
            $address = sanitize_input($_POST['address']);
        }

        if (empty($errors)) {
            // Enable exceptions for mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $expiration = date('Y-m-d H:i:s', strtotime('+10 days'));

            try {                
                $sql = 'UPDATE gigs SET title = ?, duration_value = ?, duration_unit = ?, description = ?, skills = ?, schedule = ?, payment_amount = ?, payment_unit = ?, gig_type = ?, address = ?, expiration = ? WHERE id = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssssssssss', $gig_title, $duration_value, $duration_unit, $description, $skills, $schedule, $payment_value, $payment_unit, $gig_type, $address, $expiration, $gig_id);
                $stmt->execute();

                $response['update_gig_success'] = true;
            } catch (mysqli_sql_exception $e) {
                $errors['db_err'] = 'There was problem in updating gig';
                $response['success'] = false;
                $response['errors'] = $errors;
            } finally {
                if (isset($stmt)) {
                    $stmt->close();
                }
                $conn->close();
            }
        } else {
            $response['update_gig_success'] = false;
            $response['errors'] = $errors;
        }
    }

    // Close Gig
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['close_gig'])) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'UPDATE gigs SET status = \'closed\' WHERE id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $gig_id);
            $stmt->execute();

            $response['close_gig_success'] = true;
            $response['url'] = './';
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in closing gig';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    // Apply Gig
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_gig'])) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);        

        try {
            $sql = 'INSERT INTO applicants (gig_id, student) VALUES (?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $gig_id, $username);
            $stmt->execute();

            $response['apply_gig_success'] = true;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in applying to this gig';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    exit(json_encode($response));
?>