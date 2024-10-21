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

    // Retrieve Gig Creator Details
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($username) && !isset($_GET['get_gigs'])) {
        // Enable exceptions for mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'SELECT id, email, first_name, last_name, company, profile_image_path FROM gig_creators WHERE username = ? LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $gig_creator = $result->fetch_assoc();

            $response['success'] = true;
            $response['gig_creator'] = $gig_creator;
        } catch (mysqli_sql_exception $e) {
            $errors['db_err'] = 'There was problem in retrieving your account details';
            $response['success'] = false;
            $response['errors'] = $errors;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            $conn->close();
        }
    }

    // Retrieve gigs of gig creator
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get_gigs'])) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'SELECT id, title, gig_type, payment_amount, payment_unit, duration_value, duration_unit, status FROM gigs WHERE gig_creator = ? ORDER BY date_posted DESC';
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
            $errors['db_err'] = 'There was problem in retrieving your gigs';
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile_image'])) {
        $gig_creator_id = $_POST['gig_creator_id'];
        $current_profile_image_path = $_POST['current_profile_image_path'];

        if (!isset($_FILES['profile_image_upload']) || $_FILES['profile_image_upload']['error'] !== UPLOAD_ERR_OK) {
            $errors['profile_image_upload_err'] = 'Profile image is required';
        }

        if (empty($errors)) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $profile_images_dir = '../uploads/gig-creators/profile-images/' . $gig_creator_id . '/';
                if (!is_dir($profile_images_dir)) {
                    mkdir($profile_images_dir, 0777, true);
                }

                $file = $_FILES['profile_image_upload'];
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('file_', true) . "." . $file_extension;
                $profile_image_path = $profile_images_dir . $new_file_name;

                if (move_uploaded_file($file['tmp_name'], $profile_image_path)) {
                    $sql = 'UPDATE gig_creators SET profile_image_path = ? WHERE id = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $profile_image_path, $gig_creator_id);
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

    // Update profile details
    $first_name = $last_name = $email = $company = '';

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

        if (!empty($_POST['company'])) {
            $company = sanitize_input($_POST['company']);
        }
        
        if (empty($errors)) {
            // Enable exceptions for mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $sql = 'UPDATE gig_creators SET first_name = ?, last_name = ?, email = ?, company = ? WHERE username = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssss', $first_name, $last_name, $email, $company, $username);
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

    exit(json_encode($response));
?>