<?php
    include '../connection.php';

    session_start();

    header('Content-Type: application/json');

    $username = isset($_GET['u']) ? $_GET['u'] : '';

    $response = [];
    $errors = [];

    // Retrieve Gig Creator Details
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($username)) {
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
            if ($stmt) {
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

    // Update profile details
    

    exit(json_encode($response));
?>