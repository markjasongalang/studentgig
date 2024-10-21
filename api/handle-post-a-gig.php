<?php
    include '../connection.php';

    header('Content-Type: application/json');

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $response = [];
    $errors = [];

    // Post a Gig
    $gig_title = $duration_value = $duration_unit = $description = $skills = '';
    $schedule = $payment_value = $payment_unit = $gig_type = $address = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_gig'])) {
        $username = $_POST['username'];

        if (empty($_POST['gig_title'])) {
            $errors['gig_title_err'] = 'Gig Title is required';
        } else {
            $gig_title = sanitize_input($_POST['gig_title']);
        }

        if (empty($_POST['duration_value'])) {
            $errors['duration_err'] = 'Duration is required';
        } elseif (!ctype_digit($_POST['duration_value'])) {
            $errors['duration_err'] = 'Must be a whole number';
        } else {
            $duration_value = sanitize_input($_POST['duration_value']);
        }

        $duration_unit = sanitize_input($_POST['duration_unit']);

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
            $errors['schedule_err'] = 'Schedule/Time Commitment is required';
        } else {
            $schedule = sanitize_input($_POST['schedule']);
        }

        if (empty($_POST['payment_value'])) {
            $errors['payment_err'] = 'Payment is required';
        } else {
            $payment_value = sanitize_input($_POST['payment_value']);
        }

        $payment_unit = sanitize_input($_POST['payment_unit']);

        $gig_type = $_POST['gig_type'];

        if ($gig_type != 'Remote' && empty($_POST['address'])) {
            $errors['address_err'] = 'Address is required';
        } else {
            $address = sanitize_input($_POST['address']);
        }

        if (empty($errors)) {
            // Enable exceptions for mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $expiration = date('Y-m-d H:i:s', strtotime('+10 days'));

                $sql = 'INSERT INTO gigs (title, gig_creator, duration_value, duration_unit, description, skills, schedule, payment_amount, payment_unit, gig_type, address, expiration)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssssssssss', $gig_title, $username, $duration_value, $duration_unit, $description, $skills, $schedule, $payment_value, $payment_unit, $gig_type, $address, $expiration);
                $stmt->execute();

                $response['success'] = true;
            } catch (mysqli_sql_exception $e) {
                $errors['db_err'] = 'There was problem in posting a gig';
                $response['success'] = false;
                $response['errors'] = $errors;
            } finally {
                if ($stmt) {
                    $stmt->close();
                }
                $conn->close();
            }
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    exit(json_encode($response));
?>