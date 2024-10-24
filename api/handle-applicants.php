<?php
    include '../connection.php';

    session_start();

    header('Content-Type: application/json');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    function generate_uuid() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    $gig_id = isset($_GET['g']) ? $_GET['g'] : '';

    $response = [];
    $errors = [];

    // Get Applicants
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

    // Invite Applicant
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

    // Chat (send messages)
    
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
        $gig_creator = $_POST['gig_creator'];
        $student = $_POST['student'];
        $gig_id = $_POST['gig_id'];

        if (empty($_POST['message'])) {
            $errors['message_err'] = '*Please type something first';
        } else {
            $message = sanitize_input($_POST['message']);
        }

        if (empty($errors)) {
            try {
                // Find and/or create chat record
                $sql = 'SELECT id FROM chats WHERE student = ? AND gig_creator = ? AND gig_id = ? LIMIT 1';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssi', $student, $gig_creator, $gig_id);
                $stmt->execute();
                
                $result = $stmt->get_result();
    
                if ($result->num_rows == 0) {
                    $chat_id = generate_uuid();
                    $sql = 'INSERT INTO chats (id, student, gig_creator, gig_id) VALUES (?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sssi', $chat_id, $student, $gig_creator, $gig_id);
                    $stmt->execute();
                } else {
                    $row = $result->fetch_assoc();
                    $chat_id = $row['id'];
                }
                
                // Send message
                $sql = 'INSERT INTO messages (chat_id, sender, message) VALUES (?, ?, ?)';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $chat_id, $gig_creator, $message);
                $stmt->execute();
                
                $response['success'] = true;
            } catch (mysqli_sql_exception $e) {
                $errors['db_err'] = 'Couldn\'t process chat or messages';
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

    // Chat (get messages)
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_messages'])) {
        $gig_creator = $_GET['gig_creator'];
        $student = $_GET['student'];
        $last_timestamp = isset($_GET['last_timestamp']) ? $_GET['last_timestamp'] : '1970-01-01 00:00:00'; // default to start of Unix time
        $gig_id = $_GET['gig_id'];

        try {
            $sql = 'SELECT id FROM chats WHERE student = ? AND gig_creator = ? AND gig_id = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssi', $student, $gig_creator, $gig_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $chat_id = $row['id'];
    
                $sql = 'SELECT sender, message, sent_at FROM messages WHERE chat_id = ? AND sent_at > ? ORDER BY sent_at ASC';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $chat_id, $last_timestamp);
                $stmt->execute();
                $result = $stmt->get_result();
                $messages = [];
    
                while ($row = $result->fetch_assoc()) {
                    $messages[] = $row;
                }

                $response['success'] = true;
                $response['messages'] = $messages;
            }
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'Couldn\'t retrieve messages';
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