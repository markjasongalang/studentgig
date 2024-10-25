<?php
    include '../connection.php';

    header('Content-Type: application/json');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    session_start();
    
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $response = [];
    $errors = [];

    // Get free gig posts
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_free_gig_posts'])) {
        $gig_creator = $_GET['gig_creator'];

        try {
            $sql = 'SELECT free_gig_posts FROM gig_creators WHERE username = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $gig_creator);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $response['success'] = true;
            $response['free_gig_posts'] = $row['free_gig_posts'];
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'Couldn\'t retrieve free gig posts';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

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
            if (isset($_POST['pay_post']) || isset($_POST['free_post'])) {
                $conn->begin_transaction();

                try {
                    $expiration = date('Y-m-d H:i:s', strtotime('+10 days'));
    
                    $sql = 'INSERT INTO gigs (title, gig_creator, duration_value, duration_unit, description, skills, schedule, payment_amount, payment_unit, gig_type, address, expiration)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssssssssssss', $gig_title, $username, $duration_value, $duration_unit, $description, $skills, $schedule, $payment_value, $payment_unit, $gig_type, $address, $expiration);
                    $stmt->execute();

                    if (isset($_POST['free_post'])) {
                        $sql = 'UPDATE gig_creators SET free_gig_posts = free_gig_posts - 1 WHERE username = ?';
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                    }

                    $conn->commit();
    
                    $response['gig_post_success'] = true;

                    // For redirect
                    $_SESSION['post_successful'] = true;
                } catch (mysqli_sql_exception $e) {
                    $conn->rollback();
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
                $response['validate_success'] = true;
            }
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    exit(json_encode($response));
?>