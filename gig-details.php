<?php
    $title = 'Gig Details';
    $css_file_name = 'gig-details';
    include './partials/header.php';

    if (!isset($_GET['g'])) {
        header('Location: ./');
        exit;
    }
?>

<div class="container">
    <button class="back-btn" type="button"><i class="ri-arrow-left-fill"></i> Back</button>
    
    <form id="gig-details-form" class="inner" method="POST">
        <div class="main">
            <!-- Gig Title -->
            <h1 id="gig-title-display"></h1>
            <h3 class="input-label gig-title-label">Gig Title</h3>
            <input name="gig_title" id="gig-title" type="text" placeholder="Examples: Graphic Designer for event flyers, Social Media Manager for 1-week campaign">
            <p id="gig-title-err" class="input-help"></p>

            <!-- Duration -->
            <h3 class="input-label">Duration:</h3>
            <p id="duration-display" class="content"></p>
            <input name="duration_value" id="duration-value" class="short-input" type="number" min="1" value="1" step="1">
            <select name="duration_unit" id="duration-unit" class="short-select">
                <option value="days">day(s)</option>
                <option value="weeks">week(s)</option>
                <option value="months">month(s)</option>
            </select>
            <p id="duration-err" class="input-help"></p>

            <!-- Description -->
            <h3 class="input-label">Description</h3>
            <p id="description-display" class="content"></p>
            <textarea name="description" id="description" placeholder="Provide some description about the gig..."></textarea>
            <p id="description-err" class="input-help"></p>

            <!-- Preferred Skills -->
            <h3 class="input-label">Preferred Skills</h3>
            <p id="skills-display" class="content"></p>
            <textarea name="skills" id="skills" placeholder="What are the skills that the student should preferably have?"></textarea>
            <p id="skills-err" class="input-help"></p>

            <!-- Schedule/Time Commitment -->
            <h3 class="input-label">Schedule/Time Commitment</h3>
            <p id="schedule-display" class="content"></p>
            <textarea name="schedule" id="schedule" placeholder="Examples:
1) 9:00 PM to 11:30 PM (Mon, Wed, Fri)
2) Flexible Schedule (work on your own time)
3) Submit weekly reports every Friday, with flexible working hours"></textarea>
            <p id="schedule-err" class="input-help"></p>

            <!-- Payment information -->
            <h3 class="input-label">Payment Information</h3>
            <p id="payment-display" class="content"></p>
            <input name="payment_value" id="payment-value" class="short-input" type="number" min="0" step="0.01" placeholder="Enter amount">
            <select name="payment_unit" id="payment-unit" class="short-select">
                <option value="hour">per hour</option>
                <option value="day">per day</option>
                <option value="week">per week</option>
                <option value="month">per month</option>
                <option value="submission">per submission</option>
            </select>
            <p id="payment-err" class="input-help"></p>

            <!-- Gig Type -->
            <h3 class="input-label">Gig Type</h3>
            <p id="gig-type-display" class="content"></p>
            <select name="gig_type" id="gig-type">
                <option value="Remote">Remote</option>
                <option value="Onsite">Onsite</option>
                <option value="Hybrid">Hybrid</option>
            </select>

            <!-- Address -->
            <p id="address-display" class="content"></p>
            <input name="address" id="address" type="text" placeholder="Enter complete address">
            <p id="address-err" class="input-help"></p>

            <div id="loader"><div class="spinner"></div></div>

            <?php if ($_SESSION['role'] != 'gig creator') { ?>
                <input name="apply-gig" type="submit" value="Apply">
            <?php } ?>

            <input name="update_gig" id="update-gig" type="submit" value="Update">
        </div>

        <div class="side">
            <?php if ($_SESSION['role'] == 'gig creator') { ?>
                <a id="view-applicants" href="./view-applicants?g=<?php echo $_GET['g']; ?>">View Applicants</a>
                <button id="edit-btn" class="outline-btn" type="button">Edit</button>

                <input name="close_gig" class="outline-btn" type="submit" value="Close Gig">
            <?php } ?>       
        </div>
    </form>
</div>

<script>
    const gigId = getQueryParameter('g');

    // Retrieve Gig details
    retrieveGigDetails();

    function retrieveGigDetails() {
        fetch(`./api/handle-gig-details?g=${gigId}`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);

                if (data.success) {
                    // Gig Title
                    gigDetailsForm.querySelector('#gig-title-display').innerHTML = data.gig.title;
                    gigDetailsForm.querySelector('#gig-title').value = data.gig.title;
                    
                    // Duration
                    gigDetailsForm.querySelector('#duration-display').innerHTML = `${data.gig.duration_value} ${data.gig.duration_unit}`;
                    gigDetailsForm.querySelector('#duration-value').value = data.gig.duration_value;
                    gigDetailsForm.querySelector('#duration-unit').value = data.gig.duration_unit;
                    
                    // Description
                    gigDetailsForm.querySelector('#description-display').innerHTML = data.gig.description;
                    gigDetailsForm.querySelector('#description').value = data.gig.description;
                    
                    // Preferred Skills
                    gigDetailsForm.querySelector('#skills-display').innerHTML = data.gig.skills;
                    gigDetailsForm.querySelector('#skills').value = data.gig.skills;
                    
                    // Schedule/Time Commitment
                    gigDetailsForm.querySelector('#schedule-display').innerHTML = data.gig.schedule;
                    gigDetailsForm.querySelector('#schedule').value = data.gig.schedule;

                    // Payment information
                    gigDetailsForm.querySelector('#payment-display').innerHTML = `${data.gig.payment_amount} per ${data.gig.payment_unit}`;
                    gigDetailsForm.querySelector('#payment-value').value = data.gig.payment_amount;
                    gigDetailsForm.querySelector('#payment-unit').value = data.gig.payment_unit;

                    // Gig Type
                    gigDetailsForm.querySelector('#gig-type-display').innerHTML = data.gig.gig_type;
                    gigDetailsForm.querySelector('#gig-type').value = data.gig.gig_type;

                    // Address
                    gigDetailsForm.querySelector('#address-display').innerHTML = data.gig.address || '';
                    gigDetailsForm.querySelector('#address').value = data.gig.address || '';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Gig Details Form - Actions
    const gigDetailsForm = document.querySelector('#gig-details-form');
    
    gigDetailsForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);
        e.submitter.disabled = true;
        
        gigDetailsForm.querySelector('#loader').style.display = 'block';

        
    });

    // Gig Type Dropdown & Address
    gigDetailsForm.querySelector('#gig-type').addEventListener('change', (e) => {
        if (e.target.value === 'Remote') {
            gigDetailsForm.querySelector('#address').classList.remove('show');
        } else {
            gigDetailsForm.querySelector('#address').classList.add('show');
        }
    });

    // Edit Button
    const editBtn = document.querySelector('#edit-btn');
    editBtn?.addEventListener('click', () => {
        if (editBtn.innerHTML === 'Edit') {
            document.querySelector('h1').style.display = 'none';

            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelector('.gig-title-label').style.display = 'block';
            document.querySelectorAll('input[type=text]').forEach(inputText => {
                inputText.style.display = 'block';
            });
            document.querySelectorAll('input[type=number]').forEach(inputNumber => {
                inputNumber.style.display = 'inline-block';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'block';
            });
            document.querySelectorAll('select').forEach(select => {
                select.classList.add('show');
            });
            document.querySelector('#update-gig').style.display = 'block';

            if (gigDetailsForm.querySelector('#gig-type').value !== 'Remote') {
                gigDetailsForm.querySelector('#address').classList.add('show');
            }

            editBtn.innerHTML = 'Cancel';
        } else {
            document.querySelector('h1').style.display = 'block';

            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'block';
            });

            document.querySelector('.gig-title-label').style.display = 'none';
            document.querySelectorAll('input[type=text]').forEach(inputText => {
                inputText.style.display = 'none';
            });
            document.querySelectorAll('input[type=number]').forEach(inputNumber => {
                inputNumber.style.display = 'none';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'none';
            });
            document.querySelectorAll('select').forEach(select => {
                select.classList.remove('show');
            });
            document.querySelector('#update-gig').style.display = 'none';

            gigDetailsForm.querySelector('#address').classList.remove('show');
            retrieveGigDetails();

            editBtn.innerHTML = 'Edit';
        }
    });

    // ========================== GET QUERY PARAMETER ==========================
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
</script>

<?php
    include './partials/footer.php';
?>