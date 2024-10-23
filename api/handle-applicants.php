<?php
    include '../connection.php';

    session_start();

    header('Content-Type: application/json');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $gig_id = isset($_GET['g']) ? $_GET['g'] : '';

    $response = [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_applicants'])) {
        try {
            $sql = 'SELECT s.first_name, s.last_name, s.university, a.status, a.gig_id, a.student
                    FROM applicants a
                    INNER JOIN students s ON s.username = a.student
                    WHERE a.gig_id = ?
                    ORDER BY a.date_applied';
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $gig_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $applicants = [];
            while ($row = $result->fetch_assoc()) {
                $applicants[] = $row;
            }

            $response['success'] = true;
            $response['applicants'] = $applicants;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'Couldn\'t retrieve applicants';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invite_applicant'])) {
        $gig_id = $_POST['gig_id'];
        $student = $_POST['student'];

        try {
            $sql = "UPDATE applicants SET status = 'Invited' WHERE gig_id = ? AND student = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $gig_id, $student);
            $stmt->execute();
            
            $response['success'] = true;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'Couldn\'t invite applicant';
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