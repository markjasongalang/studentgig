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
                <button id="close-gig-btn" class="outline-btn" type="button">Close Gig</button>
            <?php } ?>

            <p id="gig-notice"></p>
        </div>

        <!-- Close Gig Modal -->
        <div id="close-gig-modal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Confirm Action</h2>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to close this gig?</p>
                    <input name="close_gig" type="submit" value="Close Gig">
                </div>
                <!-- <div class="modal-footer">
                    <h3>Modal Footer</h3>
                </div> -->
            </div>
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
                    gigDetailsForm.querySelector('#payment-display').innerHTML = `Php ${formatToPesos(data.gig.payment_amount)} per ${data.gig.payment_unit}`;
                    gigDetailsForm.querySelector('#payment-value').value = data.gig.payment_amount;
                    gigDetailsForm.querySelector('#payment-unit').value = data.gig.payment_unit;

                    // Gig Type
                    gigDetailsForm.querySelector('#gig-type-display').innerHTML = data.gig.gig_type;
                    gigDetailsForm.querySelector('#gig-type').value = data.gig.gig_type;

                    // Address
                    gigDetailsForm.querySelector('#address-display').innerHTML = data.gig.address || '';
                    gigDetailsForm.querySelector('#address').value = data.gig.address || '';

                    if (data.gig.status === 'active') {
                        gigDetailsForm.querySelector('#edit-btn').style.display = 'block';
                        gigDetailsForm.querySelector('#close-gig-btn').style.display = 'block';
                    } else {
                        gigNotice.innerHTML = data.gig.status === 'closed' ? 'This gig is closed.' : 'This gig has expired.';
                        gigNotice.style.display = 'block';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Gig Details Form - Actions
    const gigDetailsForm = document.querySelector('#gig-details-form');
    const gigNotice = gigDetailsForm.querySelector('#gig-notice');
    
    gigDetailsForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);
        
        gigDetailsForm.querySelector('#loader').style.display = 'block';
        e.submitter.disabled = true;

        fetch(`./api/handle-gig-details?g=${gigId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                gigDetailsForm.querySelector('#loader').style.display = 'none';
                e.submitter.disabled = false;

                if (data.update_gig_success) {
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
                } else if (data.close_gig_success) {
                    window.location.href = data.url;
                }

                gigDetailsForm.querySelector('#gig-title-err').innerHTML = data.errors?.gig_title_err || '';
                gigDetailsForm.querySelector('#duration-err').innerHTML = data.errors?.duration_err || '';
                gigDetailsForm.querySelector('#description-err').innerHTML = data.errors?.description_err || '';
                gigDetailsForm.querySelector('#skills-err').innerHTML = data.errors?.skills_err || '';
                gigDetailsForm.querySelector('#schedule-err').innerHTML = data.errors?.schedule_err || '';
                gigDetailsForm.querySelector('#payment-err').innerHTML = data.errors?.payment_err || '';
                gigDetailsForm.querySelector('#address-err').innerHTML = data.errors?.address_err || '';
            })
            .catch(error => console.error('Error:', error));
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
                // Need to place auto-resize here (after display: block, to make sure it works)
                autoResizeTextarea(textarea);
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

    // ========================== CLOSE GIG MODAL ==========================

    // Get the button that opens the modal
    const closeGigBtn = gigDetailsForm.querySelector('#close-gig-btn');

    // Actual Close Gig Modal
    const closeGigModal = gigDetailsForm.querySelector('#close-gig-modal');
    // Get the <span> element that closes the modal
    const closeModalBtn = closeGigModal.querySelector('.close');

    // When the user clicks the button, open the modal 
    closeGigBtn.addEventListener('click', () => {
        closeGigModal.style.display = 'block';
    });

    // When the user clicks on <span> (x), close the modal
    closeModalBtn.addEventListener('click', () => {
        closeGigModal.style.display = 'none';
    });

    // When the user clicks anywhere outside of the modal, close it
    document.addEventListener('click', (e) => {
        if (e.target === closeGigModal) {
            closeGigModal.style.display = 'none';
        }
    });

    // ========================== GET QUERY PARAMETER ==========================
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    // ========================== AUTO-RESIZE TEXTAREAS ==========================
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // ========================== FORMAT MONEY AMOUNT (peso) ==========================
    function formatToPesos(amount) {
        let numericAmount = parseFloat(amount); // Convert string to number
        if (isNaN(numericAmount)) {
            return 'Invalid amount'; // Handle invalid numbers
        }
        return numericAmount.toLocaleString('en-PH');
    }

</script>

<?php
    include './partials/footer.php';
?>