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

    $username = isset($_GET['u']) ? $_GET['u'] : '';

    $response = [];
    $errors = [];

    // Retrieve Student Details
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['get_gigs']) && !isset($_GET['get_about_me'])) {
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

    // Retrieve About Me
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_about_me'])) {
        try {
            $sql = 'SELECT id, student, skills, work_exp, certifications FROM students_about_me WHERE student = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $response['success'] = true;
            $response['about_me'] = $row;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in retrieving about me';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    // Edit About Me
    $skills = $work_exp = $certs = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_about_me'])) {
        if (empty($_POST['skills'])) {
            $errors['skills_err'] = 'Skills are required';
        } else {
            $skills = sanitize_input($_POST['skills']);
        }

        if (!empty($_POST['work_exp'])) {
            $work_exp = $_POST['work_exp'];
        }

        if (!empty($_POST['certs'])) {
            $certs = $_POST['certs'];
        }
        
        if (empty($errors)) {
            try {
                $sql = 'UPDATE students_about_me SET skills = ?, work_exp = ?, certifications = ? WHERE student = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssss', $skills, $work_exp, $certs, $username);
                $stmt->execute();
                
                $response['success'] = true;
            } catch (mysqli_sql_exception $ex1) {
                $errors['db_err'] = 'There was problem in editing about me';
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

    // Change photo
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile_image'])) {
        $user_id = $_POST['user_id'];
        $current_profile_image_path = $_POST['current_profile_image_path'];

        if (!isset($_FILES['profile_image_upload']) || $_FILES['profile_image_upload']['error'] !== UPLOAD_ERR_OK) {
            $errors['profile_image_upload_err'] = 'Profile image is required';
        }

        if (empty($errors)) {
            try {
                $profile_images_dir = '../uploads/students/profile-images/' . $user_id . '/';
                if (!is_dir($profile_images_dir)) {
                    mkdir($profile_images_dir, 0777, true);
                }

                $file = $_FILES['profile_image_upload'];
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('file_', true) . "." . $file_extension;
                $profile_image_path = $profile_images_dir . $new_file_name;

                if (move_uploaded_file($file['tmp_name'], $profile_image_path)) {
                    $sql = 'UPDATE students SET profile_image_path = ? WHERE id = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $profile_image_path, $user_id);
                    $stmt->execute();
                    
                    if (isset($current_profile_image_path)) {
                        unlink($current_profile_image_path);
                    }
                } else {
                    throw new Exception();
                }
             
                $response['success'] = true;
            } catch (mysqli_sql_exception $ex1) {
                $errors['profile_image_upload_err'] = 'There was a problem in saving your new profile image';
            } catch (Exception $ex2) {
                $errors['profile_image_upload_err'] = 'Couldn\'t upload a new profile image';
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

    // Retrieve applied & hired gigs of student

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_gigs'])) {
        try {
            $sql = 'SELECT a.id, a.gig_id, a.student, a.status, g.title, g.gig_type, g.gig_creator
                    FROM applicants a
                    INNER JOIN gigs g ON g.id = a.gig_id
                    WHERE a.student = ?
                    ORDER BY a.date_applied DESC';

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();

            $result = $stmt->get_result();
            $gigs = [];
            while ($row = $result->fetch_assoc()) {
                $gigs[] = $row;
            }

            $response['success'] = true;
            $response['gigs'] = $gigs;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'Couldn\'t retrieve gigs of student';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    // Accept Invite
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accept_invite'])) {
        $gig_id = $_POST['gig_id'];
        $student = $_POST['student'];

        try {
            $sql = "UPDATE applicants SET status = 'Accepted' WHERE gig_id = ? AND student = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $gig_id, $student);
            $stmt->execute();
            
            $response['success'] = true;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'Couldn\'t accept invite';
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
        $student = $_POST['student'];
        $gig_creator = $_POST['gig_creator'];
        $gig_id = $_POST['gig_id'];

        if (empty($_POST['message'])) {
            $errors['message_err'] = '*Please type something first';
        } else {
            $message = sanitize_input($_POST['message']);
        }

        if (empty($errors)) {
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
            $stmt->bind_param('sss', $chat_id, $student, $message);
            $stmt->execute();
            
            $response['success'] = true;
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