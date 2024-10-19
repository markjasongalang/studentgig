<?php
    require '../vendor/autoload.php';
    include '../connection.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    session_start();

    header('Content-Type: application/json');

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

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $response = [];
    $errors = [];

    // Shared
    $first_name = $last_name = $birthdate = $email = $username = $password = $confirm_pass = $terms = '';

    // Student Signup
    $university = $year_level = $degree = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_signup'])) {
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

        if (empty($_POST['birthdate'])) {
            $errors['birthdate_err'] = 'Birthdate is required';
        } else {
            $birthdate = sanitize_input($_POST['birthdate']);
        }

        if (empty($_POST['university'])) {
            $errors['university_err'] = 'University is required';
        } else {
            $university = sanitize_input($_POST['university']);
        }

        if (empty($_POST['year_level'])) {
            $errors['year_level_err'] = 'Year level is required';
        } else {
            $year_level = sanitize_input($_POST['year_level']);
        }

        if (empty($_POST['degree'])) {
            $errors['degree_err'] = 'Degree program is required';
        } else {
            $degree = sanitize_input($_POST['degree']);
        }

        if (!isset($_FILES['student_id']) || $_FILES['student_id']['error'] !== UPLOAD_ERR_OK) {
            $errors['student_id_err'] = 'Student ID is required';
        }

        if (empty($_POST['email'])) {
            $errors['email_err'] = 'Email is required';
        } else {
            $email = sanitize_input($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email_err'] = 'Invalid email format';
            } else {
                // $sql = 'SELECT email FROM students WHERE email = ?';
                // $stmt = $conn->prepare($sql);
                // $stmt->bind_param('s', $email);
                // if ($stmt->execute()) {
                //     $result = $stmt->get_result();
                //     if ($result->num_rows > 0) {
                //         $row = $result->fetch_assoc();
                //         if ($email == $row['email']) {
                //             $errors['email_err'] = 'Email is already taken';
                //         }
                //     }
                // } else {
                //     $errors['email_err'] = 'There was a problem in verifying your email';
                // }
            }
        }

        if (empty($_POST['username'])) {
            $errors['username_err'] = 'Username is required';
        } else {
            $username = sanitize_input($_POST['username']);
            
            if (strlen($username) < 4) {
                $errors['username_err'] = 'Must be at least 4 characters';
            } elseif (preg_match('/\s/', $username)) {
                $errors['username_err'] = "Username cannot contain spaces";
            } else {
                // $sql = 'SELECT username FROM students WHERE username = ?';
                // $stmt = $conn->prepare($sql);
                // $stmt->bind_param('s', $username);
                // if ($stmt->execute()) {
                //     $result = $stmt->get_result();
                //     if ($result->num_rows > 0) {
                //         $row = $result->fetch_assoc();
                //         if ($username == $row['username']) {
                //             $errors['username_err'] = 'Username is already taken';
                //         }
                //     }
                // } else {
                //     $errors['username_err'] = 'There was a problem in verifying your username';
                // }
            }
        }

        if (empty($_POST['password'])) {
            $errors['password_err'] = 'Password is required';
        } else {
            $password = sanitize_input($_POST['password']);
            
            if (strlen($password) < 6) {
                $errors['password_err'] = 'Must be at least 6 characters';
            }
        }

        if (empty($_POST['confirm_pass'])) {
            $errors['confirm_pass_err'] = 'Confirm Password is required';
        } else {
            $confirm_pass = sanitize_input($_POST['confirm_pass']);
            
            if ($confirm_pass != $password) {
                $errors['confirm_pass_err'] = 'Passwords don\'t match';
            }
        }

        if (!isset($_POST['terms'])) {
            $errors['terms_err'] = 'Must agree to terms of service and privacy policy';
        } else {
            $terms = 'agree';
        }
        
        if (empty($errors)) {
            // Set session variables
            $_SESSION['register_form_data'] = [];
            $_SESSION['register_form_data']['user_id'] = generate_uuid();

            try {
                $valid_ids_dir = '../uploads/students/student-ids/' . $_SESSION['register_form_data']['user_id'] . '/';
                if (!is_dir($valid_ids_dir)) {
                    mkdir($valid_ids_dir, 0777, true);
                }
                
                $file = $_FILES['student_id'];
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('file_', true) . "." . $file_extension;
                $student_id_image_path = $valid_ids_dir . $new_file_name;

                if (move_uploaded_file($file['tmp_name'], $student_id_image_path)) {
                    $_SESSION['register_form_data']['student_id_image_path'] = $student_id_image_path;
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                $errors['student_id_err'] = "Couldn't save student id";
                $response['success'] = false;
                $response['errors'] = $errors;
                exit(json_encode($response));
            }

            $_SESSION['register_form_data']['first_name'] = $first_name;
            $_SESSION['register_form_data']['last_name'] = $last_name;
            $_SESSION['register_form_data']['birthdate'] = $birthdate;
            $_SESSION['register_form_data']['university'] = $university;
            $_SESSION['register_form_data']['year_level'] = $year_level;
            $_SESSION['register_form_data']['degree'] = $degree;
            $_SESSION['register_form_data']['email'] = $email;
            $_SESSION['register_form_data']['username'] = $username;
            $_SESSION['register_form_data']['password'] = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['register_form_data']['terms'] = $terms;
            $_SESSION['register_form_data']['role'] = 'student';

            // Send verification code (email)
            $verification_code = random_int(100000, 999999);
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'markjasongalang.work@gmail.com';
                $mail->Password = 'hehh yaxi bpnv fwqy';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'StudentGig');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'StudentGig - Verification Code';
                $mail->Body    = 'Your verification code is: <strong>' . $verification_code . '</strong><br>Note: This code will expire in 10 minutes.';

                $mail->send();
            } catch (Exception $e) {
                $errors['terms_err'] = "Couldn't send verification code to email";
                $response['success'] = false;
                $response['errors'] = $errors;
                exit(json_encode($response));
            }

            // Store verification code in db
            $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
            $sql = "INSERT INTO verification_codes (email, code, expires_at) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $cnv_verif_code = strval($verification_code);
            $stmt->bind_param("sss", $email, $cnv_verif_code, $expires_at);
            $stmt->execute();

            $stmt->close();
            $conn->close();
            
            $response['success'] = true;
            $response['url'] = './confirm-email';
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    // Gig Creator Signup
    $company = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gig_creator_signup'])) {
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

        if (empty($_POST['birthdate'])) {
            $errors['birthdate_err'] = 'Birthdate is required';
        } else {
            $birthdate = sanitize_input($_POST['birthdate']);
        }

        if (!empty($_POST['company'])) {
            $company = sanitize_input($_POST['company']);
        }

        if (!isset($_FILES['valid_id']) || $_FILES['valid_id']['error'] !== UPLOAD_ERR_OK) {
            $errors['valid_id_err'] = 'Valid ID is required';
        }

        if (empty($_POST['email'])) {
            $errors['email_err'] = 'Email is required';
        } else {
            $email = sanitize_input($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email_err'] = 'Invalid email format';
            } else {
                $sql = 'SELECT email FROM gig_creators WHERE email = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $email);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if ($email == $row['email']) {
                            $errors['email_err'] = 'Email is already taken';
                        }
                    }
                } else {
                    $errors['email_err'] = 'There was a problem in verifying your email';
                }
            }
        }

        if (empty($_POST['username'])) {
            $errors['username_err'] = 'Username is required';
        } else {
            $username = sanitize_input($_POST['username']);
            
            if (strlen($username) < 4) {
                $errors['username_err'] = 'Must be at least 4 characters';
            } elseif (preg_match('/\s/', $username)) {
                $errors['username_err'] = "Username cannot contain spaces";
            } else {
                $sql = 'SELECT username FROM gig_creators WHERE username = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $username);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if ($username == $row['username']) {
                            $errors['username_err'] = 'Username is already taken';
                        }
                    }
                } else {
                    $errors['username_err'] = 'There was a problem in verifying your username';
                }
            }
        }

        if (empty($_POST['password'])) {
            $errors['password_err'] = 'Password is required';
        } else {
            $password = sanitize_input($_POST['password']);
            
            if (strlen($password) < 6) {
                $errors['password_err'] = 'Must be at least 6 characters';
            }
        }

        if (empty($_POST['confirm_pass'])) {
            $errors['confirm_pass_err'] = 'Confirm Password is required';
        } else {
            $confirm_pass = sanitize_input($_POST['confirm_pass']);
            
            if ($confirm_pass != $password) {
                $errors['confirm_pass_err'] = 'Passwords don\'t match';
            }
        }

        if (!isset($_POST['terms'])) {
            $errors['terms_err'] = 'Must agree to terms of service and privacy policy';
        } else {
            $terms = 'agree';
        }

        if (empty($errors)) {
            // Set session variables
            $_SESSION['register_form_data'] = [];
            $_SESSION['register_form_data']['gig_creator_id'] = generate_uuid();

            try {
                $valid_ids_dir = '../uploads/gig-creators/valid-ids/' . $_SESSION['register_form_data']['gig_creator_id'] . '/';
                if (!is_dir($valid_ids_dir)) {
                    mkdir($valid_ids_dir, 0777, true);
                }
                
                $file = $_FILES['valid_id'];
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('file_', true) . "." . $file_extension;
                $valid_id_image_path = $valid_ids_dir . $new_file_name;

                if (move_uploaded_file($file['tmp_name'], $valid_id_image_path)) {
                    $_SESSION['register_form_data']['valid_id_image_path'] = $valid_id_image_path;
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                $errors['valid_id_err'] = "Couldn't save valid id";
                $response['success'] = false;
                $response['errors'] = $errors;
                exit(json_encode($response));
            }

            $_SESSION['register_form_data']['first_name'] = $first_name;
            $_SESSION['register_form_data']['last_name'] = $last_name;
            $_SESSION['register_form_data']['birthdate'] = $birthdate;
            $_SESSION['register_form_data']['company'] = $company;
            $_SESSION['register_form_data']['email'] = $email;
            $_SESSION['register_form_data']['username'] = $username;
            $_SESSION['register_form_data']['password'] = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['register_form_data']['terms'] = $terms;
            $_SESSION['register_form_data']['role'] = 'gig creator';

            // Send verification code (email)
            $verification_code = random_int(100000, 999999);
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'markjasongalang.work@gmail.com';
                $mail->Password = 'hehh yaxi bpnv fwqy';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'StudentGig');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'StudentGig - Verification Code';
                $mail->Body    = 'Your verification code is: <strong>' . $verification_code . '</strong><br>Note: This code will expire in 10 minutes.';

                $mail->send();
            } catch (Exception $e) {
                $errors['terms_err'] = "Couldn't send verification code to email";
                $response['success'] = false;
                $response['errors'] = $errors;
                exit(json_encode($response));
            }

            // Store verification code in db
            $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
            $sql = "INSERT INTO verification_codes (email, code, expires_at) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $cnv_verif_code = strval($verification_code);
            $stmt->bind_param("sss", $email, $cnv_verif_code, $expires_at);
            $stmt->execute();

            $stmt->close();
            $conn->close();
            
            $response['success'] = true;
            $response['url'] = './confirm-email';
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    exit(json_encode($response));
?>