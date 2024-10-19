<?php
    $title = 'Confirm Email';
    $css_file_name = 'auth';
    include './partials/header.php';
?>

<div class="container">
    <h1>Confirm Email</h1>

    <!-- Confirm Email -->
    <form id="confirm-email-form" method="POST">
        <!-- Verification Code -->
        <h3 class="input-label">Verification Code</h3>
        <input name="verif_code" type="number" placeholder="Enter 6-digit verification code">
        <p id="verif-code-err" class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input name="confirm" id="confirm" type="submit" value="Confirm">
        <input name="resend_code" id="resend-code" class="outline-btn" type="submit" value="Resend Code">
    </form>

    <!-- Change Email -->
    <button id="change-email-toggle" class="text-btn" type="button">Change Email</button>
    <form id="change-email-form" method="POST">
        <!-- New Email -->
        <h3 class="input-label">New Email</h3>
        <input name="new_email" type="email" placeholder="Enter new email">
        <p id="new-email-err" class="input-help"></p>
        
        <div id="loader"><div class="spinner"></div></div>
        <input name="change_email" type="submit" value="Change">
    </form>
</div>

<script>
    // Confirm Email
    const confirmEmailForm = document.querySelector('#confirm-email-form');
    confirmEmailForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        confirmEmailForm.querySelector('#loader').style.display = 'block';
        confirmEmailForm.querySelector('#confirm').disabled = true;
        confirmEmailForm.querySelector('#resend-code').disabled = true;

        fetch('./api/handle-confirm-email', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                confirmEmailForm.querySelector('#loader').style.display = 'none';
                confirmEmailForm.querySelector('#confirm').disabled = false;
                confirmEmailForm.querySelector('#resend-code').disabled = false;

                confirmEmailForm.querySelector('#verif-code-err').innerHTML = data.errors?.verif_code_err || '';
                
                if (data.success) {
                    if (data.resend_success) {
                        confirmEmailForm.querySelector('#verif-code-err').innerHTML = data.resend_success;
                    } else {
                        // window.location.href = data.url;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    });

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

    changeEmailForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        changeEmailForm.querySelector('#loader').style.display = 'block';
        formData.append(e.submitter.name, true);

        fetch('./api/handle-confirm-email', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                changeEmailForm.querySelector('#loader').style.display = 'none';
                e.submitter.disabled = false;

                changeEmailForm.querySelector('#new-email-err').innerHTML = data.errors?.new_email_err || '';

                if (data.success) {
                    changeEmailForm.querySelector('#new-email-err').innerHTML = 'Email has been updated. Please resend code :)';
                    setTimeout(() => {
                        e.target.reset();
                        e.target.style.display = 'none';
                        changeEmailToggle.innerHTML = 'Change Email';
                        changeEmailForm.querySelector('#new-email-err').innerHTML = '';
                    }, 3000);
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<?php
    include './partials/footer.php';
?>