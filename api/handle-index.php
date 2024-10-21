<?php
    include '../connection.php';

    header('Content-Type: application/json');

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $search_query = isset($_GET['search_query']) ? sanitize_input($_GET['search_query']) : '';

    $response = [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Enable exceptions for mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = "SELECT id, title, duration_value, duration_unit, description, skills, schedule, payment_amount, payment_unit, gig_type, address, status FROM gigs WHERE status = 'active' AND title LIKE ? ORDER BY date_posted DESC";
            $stmt = $conn->prepare($sql);

            $search_query = '%' . $search_query . '%';
            $stmt->bind_param('s', $search_query);

            $stmt->execute();
            $result = $stmt->get_result();

            $gigs = [];
            while ($row = $result->fetch_assoc()) {
                $gigs[] = $row;
            }

            $response['success'] = true;
            $response['gigs'] = $gigs;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in retrieving all active gigs';
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