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

    if ($role == 'student') {
        // TODO: Get session from student signup
    } else {
        $company = $_SESSION['register_form_data']['company'];
    }

    // Common in both accounts:
    $first_name = $_SESSION['register_form_data']['first_name'];
    $last_name = $_SESSION['register_form_data']['last_name'];
    $birthdate = $_SESSION['register_form_data']['birthdate'];
    $email = $_SESSION['register_form_data']['email'];
    $username = $_SESSION['register_form_data']['username'];
    $password = $_SESSION['register_form_data']['password'];
    $terms = $_SESSION['register_form_data']['terms'];
    
    // Confirm Email
    $verif_code = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
        if (empty($_POST['verif_code'])) {
            $errors['verif_code_err'] = 'Please enter the code';
        } else {
            $verif_code = sanitize_input($_POST['verif_code']);

            $sql = 'SELECT code, is_verified, expires_at FROM verification_codes WHERE email = ? AND is_verified = 0 ORDER BY expires_at DESC LIMIT 1';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $cur_time = date('Y-m-d H:i:s');

                if ($verif_code != $row['code']) {
                    $errors['verif_code_err'] = 'Incorrect verification code';
                } elseif ($cur_time > $row['expires_at'] || $row['is_verified'] == 1) {
                    $errors['verif_code_err'] = "Verification code has expired. Please resend code :)";
                }
            } else {
                $errors['verif_code_err'] = "No verification code found for the email you provided";
            }
        }

        if (empty($errors)) {
            try {
                // verification_codes table
                $sql = 'UPDATE verification_codes SET is_verified = 1 WHERE email = ? AND code = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $email, $verif_code);
                $stmt->execute();

                if ($role == 'student') {
                    // TODO: Save student in db
    
                } else {
                    // TODO: Save gig creator in db
                    
                }
            } catch (Exception $e) {
                $errors['verif_code_err'] = "There was problem in creating your account. Please try again later";
                $response['success'] = false;
                $response['errors'] = $errors;
                exit(json_encode($response));
            } finally {
                $stmt->close();
                $conn->close();
            }

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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_email'])) {
        $response['sample'] = 'Change email';
    }

    exit(json_encode($response));
?>