<?php
    $title = 'Login';
    $css_file_name = 'auth';
    include './partials/header.php';

    if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
        header('Location: ./');
        exit;
    }
?>

<div class="container">
    <form id="login-form" method="POST">
        <h1>Login</h1>

        <h3 class="input-label">Account Type</h3>
        <select name="role">
            <option value="student">Student</option>
            <option value="gig creator">Gig Creator</option>
        </select>

        <h3 class="input-label">Username</h3>
        <input name="username" type="text" placeholder="Enter username">
        
        <h3 class="input-label">Password</h3>
        <input name="password" type="password" placeholder="Enter password">
        <p id="login-err" class="input-help"></p>
        
        <div id="loader"><div class="spinner"></div></div>
        <input name="login" type="submit" value="Login">
    </form>
</div>

<script>
    const loginForm = document.querySelector('#login-form');
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        loginForm.querySelector('#loader').style.display = 'block';
        e.submitter.disabled = true;

        fetch('./api/handle-login', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                loginForm.querySelector('#loader').style.display = 'none';
                e.submitter.disabled = false;

                if (data.success) {
                    window.location.href = data.url;
                }

                loginForm.querySelector('#login-err').innerHTML = data.errors?.login_err || '';
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<?php
    include './partials/footer.php';
?>