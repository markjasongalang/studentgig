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
        <input type="text" placeholder="Enter first name">
        <p class="input-help"></p>

        <!-- Last Name -->
        <h3 class="input-label">Last Name</h3>
        <input type="text" placeholder="Enter last name">
        <p class="input-help"></p>

        <!-- Birthdate -->
        <h3 class="input-label">Birthdate</h3>
        <input type="date">
        <p class="input-help"></p>

        <!-- Year Level -->
        <h3 class="input-label">Year Level</h3>
        <input type="text" placeholder="e.g., 1st Year, 2nd Year, etc.">
        <p class="input-help"></p>

        <!-- University -->
        <h3 class="input-label">University</h3>
        <input type="text" placeholder="Enter university">
        <p class="input-help"></p>

        <!-- Degree Program -->
        <h3 class="input-label">Degree Program</h3>
        <input type="text" placeholder="Enter degree program">
        <p class="input-help"></p>

        <!-- Email -->
        <h3 class="input-label">Email</h3>
        <input type="email" placeholder="Enter email">
        <p class="input-help"></p>

        <!-- Username -->
        <h3 class="input-label">Username</h3>
        <input type="text" placeholder="Enter username">
        <p class="input-help"></p>

        <!-- Password -->
        <h3 class="input-label">Password</h3>
        <input type="password" placeholder="Enter password">
        <p class="input-help"></p>

        <!-- Confirm Password -->
        <h3 class="input-label">Confirm Password</h3>
        <input type="password" placeholder="Enter confirm password">
        <p class="input-help"></p>
        
        <!-- Terms of Service & Privacy Policy -->
        <div class="agree">
            <input type="checkbox" name="student_terms" id="student-terms">
            <label for="student-terms">I agree to the <a href="./terms-of-service" target="_blank">Terms of Service</a> and <a href="./privacy-policy" target="_blank">Privacy Policy</a></label>
        </div>
        <p class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input type="submit" value="Signup">
    </form>

    <form id="gig-creator-signup-form" method="POST">
        <!-- First Name -->
        <h3 class="input-label">First Name</h3>
        <input type="text" placeholder="Enter first name">
        <p class="input-help"></p>

        <!-- Last Name -->
        <h3 class="input-label">Last Name</h3>
        <input type="text" placeholder="Enter last name">
        <p class="input-help"></p>
        
        <!-- Birthdate -->
        <h3 class="input-label">Birthdate</h3>
        <input type="date">
        <p class="input-help"></p>
        
        <!-- Company -->
        <h3 class="input-label">Company</h3>
        <input type="text" placeholder="Enter company (optional)">
        <p class="input-help"></p>

        <!-- Email -->
        <h3 class="input-label">Email</h3>
        <input type="email" placeholder="Enter email">
        <p class="input-help"></p>

        <!-- Username -->
        <h3 class="input-label">Username</h3>
        <input type="text" placeholder="Enter username">
        <p class="input-help"></p>

        <!-- Password -->
        <h3 class="input-label">Password</h3>
        <input type="password" placeholder="Enter password">
        <p class="input-help"></p>

        <!-- Confirm Password -->
        <h3 class="input-label">Confirm Password</h3>
        <input type="password" placeholder="Enter confirm password">
        <p class="input-help"></p>
        
        <!-- Terms of Service & Privacy Policy -->
        <div class="agree">
            <input type="checkbox" name="gig_creator_terms" id="gig-creator-terms">
            <label for="gig-creator-terms">I agree to the <a href="./terms-of-service" target="_blank">Terms of Service</a> and <a href="./privacy-policy" target="_blank">Privacy Policy</a></label>
        </div>
        <p class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input type="submit" value="Signup">
    </form>
</div>

<script>
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
</script>

<?php
    include './partials/footer.php';
?>