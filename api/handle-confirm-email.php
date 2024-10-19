<?php
    require '../vendor/autoload.php';
    include '../connection.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    session_start();

    header('Content-Type: application/json');

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    $response = [];
    $errors = [];

    // Retrieve session variables (from previous page /signup)
    $role = $_SESSION['register_form_data']['role'];

    // Specifics:
    if ($role == 'student') {
        $user_id = $_SESSION['register_form_data']['user_id'];
        $university = $_SESSION['register_form_data']['university'];
        $year_level = $_SESSION['register_form_data']['year_level'];
        $degree = $_SESSION['register_form_data']['degree'];
        $student_id_image_path = $_SESSION['register_form_data']['student_id_image_path'];
    } else {
        $gig_creator_id = $_SESSION['register_form_data']['gig_creator_id'];
        $company = $_SESSION['register_form_data']['company'];
        $valid_id_image_path = $_SESSION['register_form_data']['valid_id_image_path'];
    }

    // Common:
    $first_name = $_SESSION['register_form_data']['first_name'];
    $last_name = $_SESSION['register_form_data']['last_name'];
    $birthdate = $_SESSION['register_form_data']['birthdate'];
    $email = $_SESSION['register_form_data']['email'];
    $username = $_SESSION['register_form_data']['username'];
    $password = $_SESSION['register_form_data']['password'];
    $terms = $_SESSION['register_form_data']['terms'];
    
    // Confirm Email
    $verif_code = $expires_at = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
        if (empty($_POST['verif_code'])) {
            $errors['verif_code_err'] = 'Please enter the code';
        } else {
            $verif_code = sanitize_input($_POST['verif_code']);

            $sql = 'SELECT code, is_verified, expires_at FROM verification_codes WHERE email = ? ORDER BY expires_at DESC LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $expires_at = $row['expires_at'];

            if ($row) {
                $cur_time = date('Y-m-d H:i:s');

                if ($verif_code != $row['code']) {
                    $errors['verif_code_err'] = 'Incorrect verification code';
                } elseif ($cur_time > $expires_at || $row['is_verified'] == 1) {
                    $errors['verif_code_err'] = 'Verification code has expired. Please resend code :)';
                }
            } else {
                $errors['verif_code_err'] = 'No verification code found for the email you provided';
            }
        }

        if (empty($errors)) {
            // Enable exceptions for mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                // verification_codes table
                $sql = 'UPDATE verification_codes SET is_verified = 1, expires_at = ? WHERE email = ? AND code = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $expires_at, $email, $verif_code);
                $stmt->execute();

                if ($role == 'student') {
                    // New student account
                    $sql = 'INSERT INTO students (id, username, email, first_name, last_name, university, year_level, degree_program, student_id_image_path, birthdate, terms_and_privacy, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssssssssssss', $user_id, $username, $email, $first_name, $last_name, $university, $year_level, $degree, $student_id_image_path, $birthdate, $terms, $password);
                    $stmt->execute();
    
                    // students_about_me table
                    $sql = 'INSERT INTO students_about_me (student) VALUES (?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                } else {
                    // New gig creator account
                    $sql = 'INSERT INTO gig_creators (id, username, email, first_name, last_name, company, valid_id_image_path, birthdate, terms_and_privacy, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssssssssss', $gig_creator_id, $username, $email, $first_name, $last_name, $company, $valid_id_image_path, $birthdate, $terms, $password);
                    $stmt->execute();
                }
            } catch (mysqli_sql_exception  $e) {
                $errors['verif_code_err'] = 'There was problem in creating your account. Please try again later';
                $response['success'] = false;
                $response['errors'] = $errors;
                exit(json_encode($response));
            } finally {
                if ($stmt) {
                    $stmt->close();
                }
                $conn->close();
            }

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            unset($_SESSION['register_form_data']);
            $response['success'] = true;
            $response['url'] = './';
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    // Resend Code
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resend_code'])) {
        $new_verif_code = random_int(100000, 999999);
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
            $mail->Subject = 'StudentGig - New Verification Code';
            $mail->Body    = 'Your new verification code is: <strong>' . $new_verif_code . '</strong><br>Note: This code will expire in 10 minutes.';

            $mail->send();

            // Save new code in db
            $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $sql = 'INSERT INTO verification_codes (email, code, expires_at) VALUES (?, ?, ?)';

            $stmt = $conn->prepare($sql);
            $cnv_verif_code = strval($new_verif_code);
            $stmt->bind_param('sss', $email, $cnv_verif_code, $expires_at);
            $stmt->execute();

            $stmt->close();
            $conn->close();

            $response['success'] = true;
            $response['resend_success'] = 'A new verification code has been sent to your email';
            exit(json_encode($response));
        } catch (Exception $e) {
            $response['success'] = false;
            $errors['verif_code_err'] = 'Couldn\'t send new verification code to your email';
            $response['errors'] = $errors;
        }
    }
    
    // Change Email
    $new_email = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_email'])) {
        if (empty($_POST['new_email'])) {
            $errors['new_email_err'] = 'Please provide a new email';
        } else {
            $new_email = sanitize_input($_POST['new_email']);

            if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                $errors['new_email_err'] = 'Invalid email format';
            } else {
                $sql = 'SELECT email FROM students WHERE email = ?
                        UNION
                        SELECT email FROM gig_creators WHERE email = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $new_email, $new_email);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        if ($row['email'] === $new_email) {
                            $errors['new_email_err'] = 'Email is already taken';
                            break;
                        }
                    }
                } else {
                    $errors['new_email_err'] = 'There was a problem in verifying your email';
                }
            }
        }
        
        if (empty($errors)) {
            $_SESSION['register_form_data']['email'] = $new_email;
            $email = $_SESSION['register_form_data']['email'];

            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
    }

    exit(json_encode($response));
?>