<?php
    $title = 'Signup';
    $css_file_name = 'auth';
    include './partials/header.php';
?>

<div class="container">
    <h1>Signup</h1>

    <!-- Account Type -->
    <h3 class="input-label">Select Account Type</h3>
    <select id="account-type">
        <option value="student">Student</option>
        <option value="gig-creator">Gig Creator</option>
    </select>

    <form id="student-signup-form" method="POST">
        <!-- First Name -->
        <h3 class="input-label">First Name</h3>
        <input name="first_name" type="text" placeholder="Enter first name">
        <p id="first-name-err" class="input-help"></p>

        <!-- Last Name -->
        <h3 class="input-label">Last Name</h3>
        <input name="last_name" type="text" placeholder="Enter last name">
        <p id="last-name-err" class="input-help"></p>

        <!-- Birthdate -->
        <h3 class="input-label">Birthdate</h3>
        <input name="birthdate" type="date">
        <p id="birthdate-err" class="input-help"></p>

        <!-- University -->
        <h3 class="input-label">University</h3>
        <input name="university" type="text" placeholder="Enter university">
        <p id="university-err" class="input-help"></p>

        <!-- Year Level -->
        <h3 class="input-label">Year Level</h3>
        <input name="year_level" type="text" placeholder="e.g., 1st Year, 2nd Year, etc.">
        <p id="year-level-err" class="input-help"></p>

        <!-- Degree Program -->
        <h3 class="input-label">Degree Program</h3>
        <input name="degree" type="text" placeholder="Enter degree program">
        <p id="degree-err" class="input-help"></p>

        <!-- Student ID -->
        <h3 class="input-label">Student ID</h3>
        <input name="student_id" type="file" accept="image/*">
        <p id="student-id-err" class="input-help"></p>

        <!-- Email -->
        <h3 class="input-label">Email</h3>
        <input name="email" type="email" placeholder="Enter email">
        <p id="email-err" class="input-help"></p>

        <!-- Username -->
        <h3 class="input-label">Username</h3>
        <input name="username" type="text" placeholder="Enter username">
        <p id="username-err" class="input-help"></p>

        <!-- Password -->
        <h3 class="input-label">Password</h3>
        <input name="password" type="password" placeholder="Enter password">
        <p id="password-err" class="input-help"></p>

        <!-- Confirm Password -->
        <h3 class="input-label">Confirm Password</h3>
        <input name="confirm_pass" type="password" placeholder="Enter confirm password">
        <p id="confirm-pass-err" class="input-help"></p>
        
        <!-- Terms of Service & Privacy Policy -->
        <div class="agree">
            <input name="student_terms" id="student-terms" type="checkbox">
            <label for="student-terms">I agree to the <a href="./terms-of-service" target="_blank">Terms of Service</a> and <a href="./privacy-policy" target="_blank">Privacy Policy</a></label>
        </div>
        <p id="student-terms-err" class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input name="student_signup" type="submit" value="Signup">
    </form>

    <form id="gig-creator-signup-form" method="POST">
        <!-- First Name -->
        <h3 class="input-label">First Name</h3>
        <input name="first_name" type="text" placeholder="Enter first name">
        <p id="first-name-err" class="input-help"></p>

        <!-- Last Name -->
        <h3 class="input-label">Last Name</h3>
        <input name="last_name" type="text" placeholder="Enter last name">
        <p id="last-name-err" class="input-help"></p>
        
        <!-- Birthdate -->
        <h3 class="input-label">Birthdate</h3>
        <input name="birthdate" type="date">
        <p id="birthdate-err" class="input-help"></p>
        
        <!-- Company -->
        <h3 class="input-label">Company</h3>
        <input name="company" type="text" placeholder="Enter company (optional)">

        <!-- Valid ID -->
        <h3 class="input-label">Valid ID</h3>
        <input name="valid_id" type="file" accept="image/*">
        <p id="valid-id-err" class="input-help"></p>

        <!-- Email -->
        <h3 class="input-label">Email</h3>
        <input name="email" type="email" placeholder="Enter email">
        <p id="email-err" class="input-help"></p>

        <!-- Username -->
        <h3 class="input-label">Username</h3>
        <input name="username" type="text" placeholder="Enter username">
        <p id="username-err" class="input-help"></p>

        <!-- Password -->
        <h3 class="input-label">Password</h3>
        <input name="password" type="password" placeholder="Enter password">
        <p id="password-err" class="input-help"></p>

        <!-- Confirm Password -->
        <h3 class="input-label">Confirm Password</h3>
        <input name="confirm_pass" type="password" placeholder="Enter confirm password">
        <p id="confirm-pass-err" class="input-help"></p>
        
        <!-- Terms of Service & Privacy Policy -->
        <div class="agree">
            <input name="terms" id="terms" type="checkbox">
            <label for="terms">I agree to the <a href="./terms-of-service" target="_blank">Terms of Service</a> and <a href="./privacy-policy" target="_blank">Privacy Policy</a></label>
        </div>
        <p id="terms-err" class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input name="gig_creator_signup" type="submit" value="Signup">
    </form>
</div>

<script>
    // Toggle account type
    const accountType = document.querySelector('#account-type');
    const studentSignupForm = document.querySelector('#student-signup-form');
    const gigCreatorSignupForm = document.querySelector('#gig-creator-signup-form');
    accountType.addEventListener('change', () => {
        if (accountType.value === 'gig-creator') {
            studentSignupForm.reset();
            studentSignupForm.style.display = 'none';
            gigCreatorSignupForm.style.display = 'block';
        } else {
            gigCreatorSignupForm.reset();
            gigCreatorSignupForm.style.display = 'none';
            studentSignupForm.style.display = 'block';
        }
    });

    // Student Signup
    studentSignupForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        studentSignupForm.querySelector('#loader').style.display = 'block';
        e.submitter.disabled = true;

        fetch('./api/handle-signup', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                studentSignupForm.querySelector('#loader').style.display = 'none';
                e.submitter.disabled = false;

                if (data.success) {

                }
            })
            .catch(error => console.error('Error', error));
    });

    // Gig Creator Signup
    gigCreatorSignupForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        gigCreatorSignupForm.querySelector('#loader').style.display = 'block';
        e.submitter.disabled = true;

        fetch('./api/handle-signup', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                gigCreatorSignupForm.querySelector('#loader').style.display = 'none';
                e.submitter.disabled = false;

                if (data.success) {
                    window.location.href = data.url;
                }

                gigCreatorSignupForm.querySelector('#first-name-err').innerHTML = data.errors?.first_name_err || '';
                gigCreatorSignupForm.querySelector('#last-name-err').innerHTML = data.errors?.last_name_err || '';
                gigCreatorSignupForm.querySelector('#birthdate-err').innerHTML = data.errors?.birthdate_err || '';
                gigCreatorSignupForm.querySelector('#valid-id-err').innerHTML = data.errors?.valid_id_err || '';
                gigCreatorSignupForm.querySelector('#email-err').innerHTML = data.errors?.email_err || '';
                gigCreatorSignupForm.querySelector('#username-err').innerHTML = data.errors?.username_err || '';
                gigCreatorSignupForm.querySelector('#password-err').innerHTML = data.errors?.password_err || '';
                gigCreatorSignupForm.querySelector('#confirm-pass-err').innerHTML = data.errors?.confirm_pass_err || '';
                gigCreatorSignupForm.querySelector('#terms-err').innerHTML = data.errors?.terms_err || '';
            })
            .catch(error => console.error('Error', error));
    });
</script>

<?php
    include './partials/footer.php';
?>