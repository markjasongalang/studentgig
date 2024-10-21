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

    $gig_id = isset($_GET['g']) ? $_GET['g'] : "";

    $response = [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Enable exceptions for mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'SELECT title, duration_value, duration_unit, description, skills, schedule, payment_amount, payment_unit, gig_type, address FROM gigs WHERE id = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $gig_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

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

    exit(json_encode($response));
?>