<?php
    $title= 'Post a gig';
    $css_file_name = 'post-a-gig';
    include './partials/header.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'gig creator') {
        header('Location: ./login');
        exit;
    }
?>

<div class="container">
    <form id="post-gig-form" method="POST">
        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">

        <!-- Gig Title -->
        <h3 class="input-label">Gig Title</h3>
        <input name="gig_title" type="text" placeholder="Examples: Graphic Designer for event flyers, Social Media Manager for 1-week campaign, Tutor for midterm preparation">
        <p id="gig-title-err" class="input-help"></p>

        <!-- Duration -->
        <h3 class="input-label">How long will the student be required to work?</h3>
        <input name="duration_value" class="short-input" type="number" min="1" value="1" step="1">
        <select name="duration_unit" class="short-select">
            <option value="days">day(s)</option>
            <option value="weeks">week(s)</option>
            <option value="months">month(s)</option>
        </select>
        <p id="duration-err" class="input-help"></p>

        <!-- Description -->
        <h3 class="input-label">Description</h3>
        <textarea name="description" placeholder="Provide some description about the gig..."></textarea>
        <p id="description-err" class="input-help"></p>

        <!-- Preferred Skills -->
        <h3 class="input-label">Preferred Skills</h3>
        <textarea name="skills" placeholder="What are the skills that the student should preferably have?"></textarea>
        <p id="skills-err" class="input-help"></p>

        <!-- Schedule/Time Commitment -->
        <h3 class="input-label">Schedule/Time Commitment</h3>
        <textarea name="schedule" placeholder="Examples:
1) 9:00 PM to 11:30 PM (Mon, Wed, Fri)
2) Flexible Schedule (work on your own time)
3) Submit weekly reports every Friday, with flexible working hours"></textarea>
        <p id="schedule-err" class="input-help"></p>

        <!-- Payment Information -->
        <h3 class="input-label">Payment Information</h3>
        <input name="payment_value" class="short-input" type="number" min="1" step="0.01" placeholder="Enter amount">
        <select name="payment_unit" class="short-select">
            <option value="hour">per hour</option>
            <option value="day">per day</option>
            <option value="week">per week</option>
            <option value="month">per month</option>
            <option value="submission">per submission</option>
        </select>
        <p id="payment-err" class="input-help"></p>

        <!-- Gig Type -->
        <h3 class="input-label">Gig Type</h3>
        <select name="gig_type" id="gig-type">
            <option value="Remote">Remote</option>
            <option value="Onsite">Onsite</option>
            <option value="Hybrid">Hybrid</option>
        </select>
        <input name="address" id="address" type="text" placeholder="Enter complete address">
        <p id="address-err" class="input-help"></p>

        <div id="loader"><div class="spinner"></div></div>
        <input name="post_gig" type="submit" value="Post Gig">
    </form>
</div>

<script>
    // Post a Gig Form
    const postGigForm = document.querySelector('#post-gig-form');
    postGigForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        postGigForm.querySelector('#loader').style.display = 'block';
        e.submitter.disabled = true;

        fetch('./api/handle-post-a-gig', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                postGigForm.querySelector('#loader').style.display = 'none';
                e.submitter.disabled = false;
                
                if (data.success) {
                    postGigForm.reset();
                    window.location.href = './';
                }

                postGigForm.querySelector('#gig-title-err').innerHTML = data.errors?.gig_title_err || '';
                postGigForm.querySelector('#duration-err').innerHTML = data.errors?.duration_err || '';
                postGigForm.querySelector('#description-err').innerHTML = data.errors?.description_err || '';
                postGigForm.querySelector('#skills-err').innerHTML = data.errors?.skills_err || '';
                postGigForm.querySelector('#schedule-err').innerHTML = data.errors?.schedule_err || '';
                postGigForm.querySelector('#payment-err').innerHTML = data.errors?.payment_err || '';
                postGigForm.querySelector('#address-err').innerHTML = data.errors?.address_err || '';
            })
            .catch(error => console.error('Error:', error));
    });

    // Optional address (for remote)
    const gigType = postGigForm.querySelector('#gig-type');
    const address = postGigForm.querySelector('#address');
    gigType.addEventListener('change', (e) => {
        const selected = e.target.value;
        if (selected !== 'Remote') {
            address.style.display = 'block';
        } else {
            postGigForm.querySelector('#address-err').innerHTML = '';
            address.style.display = 'none';
            address.value = '';
        }
    });
</script>

<?php
    include './partials/footer.php';
?>