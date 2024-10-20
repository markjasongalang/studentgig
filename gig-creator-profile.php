<?php
    $url_username = isset($_GET['u']) ? $_GET['u'] : '';

    $title = 'Gig Creator';
    $css_file_name = 'profile';
    include './partials/header.php';

    if (empty($url_username)) {
        if ($_SESSION['username']) {
            $_GET['u'] = $_SESSION['username'];
            header('Location: ./gig-creator-profile' . '?' . http_build_query($_GET));
        } else {
            header('Location: ./login');
            exit;
        }
    }
?>

<div class="container">
    <div class="left">
        <!-- Profile Image -->
        <img id="profile-image" alt="Profile image">
        <form id="change-photo-form" method="POST">
            <input type="hidden" id="gig-creator-id" name="gig_creator_id">
            <input type="hidden" id="current-profile-image-path" name="current_profile_image_path">

            <input name="profile_image_upload" id="profile-image-upload" type="file" accept="image/*">
            <p id="profile-image-upload-err" class="input-help"></p>

            <input name="save_profile_image" id="save-profile-image" type="submit" value="Save">
        </form>
        <button id="change-photo-btn" class="text-btn" type="button">Change photo</button>

        <form id="edit-profile-form" method="POST">
            <!-- Gig Creator Name -->
            <h3 class="input-label">First name</h3>
            <input name="first_name" id="first-name" type="text" placeholder="Enter first name">
            <p id="first-name-err" class="input-help"></p>

            <h3 class="input-label">Last name</h3>
            <input name="last_name" id="last-name" type="text" placeholder="Enter last name">
            <p id="last-name-err" class="input-help"></p>

            <h2 id="gig-creator-name" class="displayed"></h2>
            
            <!-- Email -->
            <h3 class="input-label">Email</h3>
            <input name="email" id="email" type="email" placeholder="Enter email">
            <p id="email-err" class="input-help"></p>

            <p id="gig-creator-email" class="displayed"></p>

            <!-- Company -->
            <h3 class="input-label">Company</h3>
            <input name="company" id="company" type="text" placeholder="Enter company (optional)">

            <p id="gig-creator-company" class="displayed"></p>

            <input name="edit_profile" id="edit-profile" type="submit" value="Update">
        </form>

        <button id="edit-profile-btn" class="text-btn" type="button">Edit profile</button>
    </div>

    <div class="main">
        <ul class="top-nav">
            <li id="active-gigs-tab" class="active">Active Gigs</li>
            <li id="closed-gigs-tab">Closed Gigs</li>
        </ul>

        <div class="active-gigs">
            <!-- <a href="./gig-details?g=" class="gig-item">
                <h3 class="gig-title">English Tutor</h3>
                <p class="gig-type">Remote</p>
                <div>
                    <p>Payment</p>
                    <p>420 per hour</p>
                </div>
                <div>
                    <p>Duration</p>
                    <p>2 weeks</p>
                </div>
                <i class="ri-arrow-right-line"></i>
            </a> -->
        </div>
        
        <div class="closed-gigs">
            <!-- <a href="./gig-details?g=" class="gig-item">
                <h3 class="gig-title">Graphic Designer</h3>
                <p class="gig-type">Onsite</p>
                <div>
                    <p>Payment</p>
                    <p>750 per week</p>
                </div>
                <div>
                    <p>Duration</p>
                    <p>3 months</p>
                </div>
                <i class="ri-arrow-right-line"></i>
            </a> -->
        </div>
    </div>
</div>

<script>
    const username = getQueryParameter('u');

    // ========================== SIDE ==========================

    // Gig Creator Details
    retrieveGigCreator();

    function retrieveGigCreator() {
        fetch(`./api/handle-gig-creator-profile?u=${encodeURIComponent(username)}`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    changePhotoForm.querySelector('#gig-creator-id').value = data.gig_creator.id;

                    document.querySelector('#profile-image').src = data.gig_creator.profile_image_path.slice(1) || './images/profile-image.png';
                    changePhotoForm.querySelector('#current-profile-image-path').value = data.gig_creator.profile_image_path || '';
                    
                    editProfileForm.querySelector('#gig-creator-name').innerHTML = data.gig_creator.first_name + ' ' + data.gig_creator.last_name;
                    editProfileForm.querySelector('#gig-creator-email').innerHTML = data.gig_creator.email;
                    editProfileForm.querySelector('#gig-creator-company').innerHTML = data.gig_creator.company;

                    editProfileForm.querySelector('#first-name').value = data.gig_creator.first_name;
                    editProfileForm.querySelector('#last-name').value = data.gig_creator.last_name;
                    editProfileForm.querySelector('#email').value = data.gig_creator.email;
                    editProfileForm.querySelector('#company').value = data.gig_creator.company;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Change Photo
    const changePhotoBtn = document.querySelector('#change-photo-btn');
    const profileImage = document.querySelector('#profile-image');
    const changePhotoForm = document.querySelector('#change-photo-form');

    changePhotoBtn.addEventListener('click', () => {
        if (changePhotoBtn.innerHTML === 'Change photo') {
            changePhotoForm.style.display = 'block';
            
            changePhotoBtn.innerHTML = 'Cancel';
        } else {
            changePhotoForm.reset();
            changePhotoForm.style.display = 'none';

            document.querySelector('#profile-image').src = changePhotoForm.querySelector('#current-profile-image-path').value.slice(1) || './images/profile-image.png';
            
            changePhotoBtn.innerHTML = 'Change photo';
        }
    });

    const profileImageUpload = document.querySelector('#profile-image-upload');
    profileImageUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            profileImage.src = changePhotoForm.querySelector('#current-profile-image-path').value.slice(1) || './images/profile-image.png';
        }
    });

    changePhotoForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        changePhotoForm.querySelector('#save-profile-image').disabled = true;

        fetch(`./api/handle-gig-creator-profile?u=${username}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                changePhotoForm.querySelector('#save-profile-image').disabled = false;

                if (data.success) {
                    changePhotoForm.reset();
                    changePhotoForm.style.display = 'none';

                    retrieveGigCreator();
                    
                    changePhotoBtn.innerHTML = 'Change photo';
                }

                changePhotoForm.querySelector('#profile-image-upload-err').innerHTML = data.errors?.profile_image_upload_err || '';
            })
            .catch(error => console.error('Error:', error));
    });

    // Edit Profile
    const editProfileBtn = document.querySelector('#edit-profile-btn');
    const editProfileForm = document.querySelector('#edit-profile-form');

    editProfileBtn.addEventListener('click', () => {
        if (editProfileBtn.innerHTML == 'Edit profile') {
            document.querySelectorAll('.left #edit-profile-form .input-label').forEach(inputLabel => {
                inputLabel.style.display = 'block';
            });
            document.querySelectorAll('.left #edit-profile-form input').forEach(input => {
                input.style.display = 'block';
            });
            document.querySelectorAll('.displayed').forEach(displayed => {
                displayed.style.display = 'none';
            });
            
            editProfileBtn.innerHTML = 'Cancel';
        } else {
            document.querySelectorAll('.displayed').forEach(displayed => {
                displayed.style.display = 'block';
            });
            document.querySelectorAll('.left #edit-profile-form .input-label').forEach(inputLabel => {
                inputLabel.style.display = 'none';
            });
            document.querySelectorAll('.left #edit-profile-form input').forEach(input => {
                input.style.display = 'none';
            });

            retrieveGigCreator();
            
            editProfileBtn.innerHTML = 'Edit profile';
        }
    });

    editProfileForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        editProfileForm.querySelector('#edit-profile').disabled = true;

        fetch(`./api/handle-gig-creator-profile?u=${username}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                editProfileForm.querySelector('#edit-profile').disabled = false;
                
                if (data.success) {
                    document.querySelectorAll('.displayed').forEach(displayed => {
                        displayed.style.display = 'block';
                    });
                    document.querySelectorAll('.left #edit-profile-form .input-label').forEach(inputLabel => {
                        inputLabel.style.display = 'none';
                    });
                    document.querySelectorAll('.left #edit-profile-form input').forEach(input => {
                        input.style.display = 'none';
                    });

                    retrieveGigCreator();
                    
                    editProfileBtn.innerHTML = 'Edit profile';
                }
                
                editProfileForm.querySelector('#first-name-err').innerHTML = data.errors?.first_name_err || '';
                editProfileForm.querySelector('#last-name-err').innerHTML = data.errors?.last_name_err || '';
                editProfileForm.querySelector('#email-err').innerHTML = data.errors?.email_err || '';
            })
            .catch(error => console.error('Error:', error));
    });

    // ========================== MAIN  ==========================

    // Retrieve Gigs
    const activeGigs = document.querySelector('.active-gigs');

    retrieveGigs();

    function retrieveGigs() {
        fetch(`./api/handle-gig-creator-profile?u=${username}&get_gigs=true`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                
                if (data.success) {
                    data.gigs.forEach(gig => {
                        const gigItem = document.createElement('a');
                        gigItem.setAttribute('href', `./gig-details?g=`);
                        gigItem.classList.add('gig-item');
                        
                        gigItem.innerHTML = `
                            <h3 class="gig-title">${gig.title}</h3>
                            <p class="gig-type">${gig.gig_type}</p>
                            <div>
                                <p>Payment</p>
                                <p>${gig.payment_amount} per ${gig.payment_unit}</p>
                            </div>
                            <div>
                                <p>Duration</p>
                                <p>${gig.duration_value} ${gig.duration_unit}</p>
                            </div>
                            <i class="ri-arrow-right-line"></i>
                        `;

                        activeGigs.appendChild(gigItem);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    const tabs = [
        document.querySelector('#active-gigs-tab'),
        document.querySelector('#closed-gigs-tab')
    ];

    const sections = [
        document.querySelector('.active-gigs'),
        document.querySelector('.closed-gigs')
    ];

    // Active Gigs
    tabs[0].addEventListener('click', () => {
        sections.forEach(section => section.style.display = 'none');
        tabs.forEach(tab => tab.classList.remove('active'));
        sections[0].style.display = 'block';
        tabs[0].classList.add('active');
    });
    
    
    // Closed Gigs
    tabs[1].addEventListener('click', () => {
        sections.forEach(section => section.style.display = 'none');
        tabs.forEach(tab => tab.classList.remove('active'));
        sections[1].style.display = 'block';
        tabs[1].classList.add('active');
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