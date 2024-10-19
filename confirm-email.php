<?php
    $title = 'Confirm Email';
    $css_file_name = 'auth';
    include './partials/header.php';

    print_r($_SESSION['register_form_data']);
?>

<div class="container">
    <h1>Confirm Email</h1>

    <!-- Confirm Email -->
    <form id="confirm-email-form" method="POST">
        <!-- Verification Code -->
        <h3 class="input-label">Verification Code</h3>
        <input type="number" placeholder="Enter 6-digit verification code">
        <p class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input name="confirm" id="confirm" type="submit" value="Confirm">
        <input name="resend_code" id="resend-code" class="outline-btn" type="submit" value="Resend Code">
    </form>

    <!-- Change Email -->
    <button id="change-email-toggle" class="text-btn" type="button">Change Email</button>
    <form id="change-email-form" method="POST">
        <!-- New Email -->
        <h3 class="input-label">New Email</h3>
        <input type="email" placeholder="Enter new email">
        <p class="input-help"></p>
        
        <input type="submit" value="Change">
    </form>
</div>

<script>
    // Change Email
    const changeEmailToggle = document.querySelector('#change-email-toggle');
    const changeEmailForm = document.querySelector('#change-email-form');
    changeEmailToggle.addEventListener('click', () => {
        if (changeEmailToggle.innerHTML === 'Change Email') {
            changeEmailForm.style.display = 'block';
            changeEmailToggle.innerHTML = 'Close';
        } else {
            changeEmailForm.reset();
            changeEmailForm.style.display = 'none';
            changeEmailToggle.innerHTML = 'Change Email';
        }
    });
</script>

<?php
    include './partials/footer.php';
?>