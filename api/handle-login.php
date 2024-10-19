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

    $response = [];
    $errors = [];

    $username = $password = $role = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        if (empty($_POST['username'])) {
            $errors['login_err'] = 'Please fill in the fields above';
        } else {
            $username = sanitize_input($_POST['username']);
        }

        if (empty($_POST['password'])) {
            $errors['login_err'] = 'Please fill in the fields above';
        } else {
            $password = sanitize_input($_POST['password']);
        }

        $role = $_POST['role'];
        
        if (empty($errors)) {
            // Enable exceptions for mysqli
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                if ($role == 'student') {
                    $sql = 'SELECT username, password FROM students WHERE username = ?';
                } else {
                    $sql = 'SELECT username, password FROM gig_creators WHERE username = ?';
                }
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    if ($username === $row['username'] && password_verify($password, $row['password'])) {
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $role;
                        $response['success'] = true;
                        $response['url'] = "./";
                        exit(json_encode($response));
                    } else {
                        $errors['login_err'] = 'Username/Password is incorrect (try checking the Account Type above)';
                    }
                } else {
                    $errors['login_err'] = 'Username/Password is incorrect (try checking the Account Type above)';
                }
            } catch (mysqli_sql_exception $e) {
                $errors['login_err'] = 'There was a problem in checking your credentials';
            }
        }
    }

    $response['success'] = false;
    $response['errors'] = $errors;

    exit(json_encode($response));
?>