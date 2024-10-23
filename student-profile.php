<?php
    $url_username = isset($_GET['u']) ? $_GET['u'] : '';

    $title = 'Student Profile';
    $css_file_name = 'profile';
    include './partials/header.php';

    if (empty($url_username)) {
        if ($_SESSION['username']) {
            $_GET['u'] = $_SESSION['username'];
            header('Location: ./student-profile' . '?' . http_build_query($_GET));
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
            <input type="hidden" id="user-id" name="user_id">
            <input type="hidden" id="current-profile-image-path" name="current_profile_image_path">

            <input name="profile_image_upload" id="profile-image-upload" type="file" accept="image/*">
            <p id="profile-image-upload-err" class="input-help"></p>

            <input name="save_profile_image" id="save-profile-image" type="submit" value="Save">
        </form>
        <button id="change-photo-btn" class="text-btn" type="button">Change photo</button>

        <form id="edit-profile-form" method="POST">
            <!-- Student Name -->
            <h3 class="input-label">First name</h3>
            <input name="first_name" id="first-name" type="text" placeholder="Enter first name">
            <p id="first-name-err" class="input-help"></p>
            
            <h3 class="input-label">Last name</h3>
            <input name="last_name" id="last-name" type="text" placeholder="Enter last name">
            <p id="last-name-err" class="input-help"></p>

            <h2 id="student-full-name" class="displayed"></h2>

            <!-- Email -->
            <h3 class="input-label">Email</h3>
            <input name="email" id="email" type="email" placeholder="Enter email">
            <p id="email-err" class="input-help"></p>
            <p id="student-email" class="displayed"></p>
            
            <!-- University -->
            <h3 class="input-label">University</h3>
            <input name="university" id="university" type="text" placeholder="Enter university">
            <p id="university-err" class="input-help"></p>
            <p id="student-university" class="displayed"></p>
            
            <!-- Degree -->
            <h3 class="input-label">Degree Program</h3>
            <input name="degree" id="degree" type="text" placeholder="Enter degree program">
            <p id="degree-err" class="input-help"></p>
            <p id="student-degree" class="displayed"></p>
            
            <!-- Year Level -->
            <h3 class="input-label">Year Level</h3>
            <input name="year_level" id="year-level" type="text" placeholder="Enter year level">
            <p id="year-level-err" class="input-help"></p>
            <p id="student-year-level" class="displayed"></p>

            <input name="edit_profile" id="edit-profile" type="submit" value="Update">
        </form>

        <button id="edit-profile-btn" class="text-btn" type="button">Edit profile</button>
    </div>

    <div class="main">
        <ul class="top-nav">
            <li id="about-me-tab">About Me</li>
            <li id="applied-gigs-tab" class="active">Applied Gigs</li>
            <li id="hired-gigs-tab">Hired Gigs</li>
        </ul>

        <div class="about-me">
            <form id="about-me-form" method="POST">
                <!-- Skills -->
                <h3 class="input-label">SKILLS</h3>
                <p id="student-skills" class="content"></p>
                <textarea name="skills" id="skills" placeholder="Share your skills to everyone..."></textarea>
                <p id="skills-err" class="input-help"></p>
                
                <!-- Work Experience -->
                <h3 id="work-exp-label" class="input-label">WORK EXPERIENCE</h3>
                <p id="student-work-exp" class="content"></p>
                <textarea name="work_exp" id="work-exp" placeholder="This is optional :)"></textarea>
                
                <!-- Certifications/Awards -->
                <h3 id="certs-label" class="input-label">CERTIFICATIONS/AWARDS</h3>
                <p id="student-certs" class="content"></p>
                <textarea name="certs" id="certs" placeholder="This is optional as well :)"></textarea>

                <input name="edit_about_me" id="edit-about-me" type="submit" value="Save">
                <button id="edit-about-me-btn" class="outline-btn" type="button">Edit About Me</button>
            </form>
        </div>

        <div class="applied-gigs">
            <!-- <div class="gig-item">
                <h3 class="gig-title">English Tutor</h3>
                <p class="gig-type">Remote</p>
                <p>420 per hour</p>
                <div class="with-actions">
                    <a href="./gig-details?g=">View</a>
                </div>
                <div class="with-actions">
                    <button>Message</button>
                </div>
            </div> -->
        </div>

        <div class="hired-gigs">
            <!-- <div class="gig-item">
                <h3 class="gig-title">English Tutor</h3>
                <p class="gig-type">Remote</p>
                <p>420 per hour</p>
                <div class="with-actions">
                    <a href="./gig-details?g=">View</a>
                </div>
                <div class="with-actions">
                    <button>Message</button>
                </div>
            </div> -->
        </div>
    </div>
</div>

<script>
    const username = getQueryParameter('u');

    retrieveStudent();

    function retrieveStudent() {
        fetch(`./api/handle-student-profile?u=${username}`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    // User ID
                    changePhotoForm.querySelector('#user-id').value = data.student.id;

                    // Profile image
                    document.querySelector('#profile-image').src = data.student.profile_image_path.slice(1) || './images/profile-image.png';
                    changePhotoForm.querySelector('#current-profile-image-path').value = data.student.profile_image_path || '';

                    // Full Name
                    editProfileForm.querySelector('#student-full-name').innerHTML = `${data.student.first_name} ${data.student.last_name}`;
                    editProfileForm.querySelector('#first-name').value = data.student.first_name;
                    editProfileForm.querySelector('#last-name').value = data.student.last_name;

                    // Email
                    editProfileForm.querySelector('#student-email').innerHTML = data.student.email;
                    editProfileForm.querySelector('#email').value = data.student.email;

                    // University
                    editProfileForm.querySelector('#student-university').innerHTML = data.student.university;
                    editProfileForm.querySelector('#university').value = data.student.university;

                    // Degree Program
                    editProfileForm.querySelector('#student-degree').innerHTML = data.student.degree_program;
                    editProfileForm.querySelector('#degree').value = data.student.degree_program;

                    // Year Level
                    editProfileForm.querySelector('#student-year-level').innerHTML = data.student.year_level;
                    editProfileForm.querySelector('#year-level').value = data.student.year_level;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // ========================== SIDE ==========================

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

        fetch(`./api/handle-student-profile?u=${username}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    changePhotoForm.reset();
                    changePhotoForm.style.display = 'none';

                    retrieveStudent();
                    
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

            editProfileForm.querySelectorAll('.input-help').forEach(inputHelp => inputHelp.innerHTML = '');
            
            editProfileForm.reset();

            retrieveStudent();

            editProfileBtn.innerHTML = 'Edit profile';
        }
    });

    editProfileForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        fetch(`./api/handle-student-profile?u=${username}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);

                if (data.success) {
                    editProfileForm.reset();

                    retrieveStudent();

                    document.querySelectorAll('.displayed').forEach(displayed => {
                        displayed.style.display = 'block';
                    });
                    document.querySelectorAll('.left #edit-profile-form .input-label').forEach(inputLabel => {
                        inputLabel.style.display = 'none';
                    });
                    document.querySelectorAll('.left #edit-profile-form input').forEach(input => {
                        input.style.display = 'none';
                    });

                    editProfileBtn.innerHTML = 'Edit profile';
                }

                editProfileForm.querySelector('#first-name-err').innerHTML = data.errors?.first_name_err || '';
                editProfileForm.querySelector('#last-name-err').innerHTML = data.errors?.last_name_err || '';
                editProfileForm.querySelector('#email-err').innerHTML = data.errors?.email_err || '';
                editProfileForm.querySelector('#university-err').innerHTML = data.errors?.university_err || '';
                editProfileForm.querySelector('#degree-err').innerHTML = data.errors?.degree_err || '';
                editProfileForm.querySelector('#year-level-err').innerHTML = data.errors?.year_level_err || '';
            })
            .catch(error => console.error('Error:', error));
    });

    // ========================== MAIN  ==========================
    const tabs = [
        document.querySelector('#about-me-tab'),
        document.querySelector('#applied-gigs-tab'),
        document.querySelector('#hired-gigs-tab')
    ];

    const appliedGigs = document.querySelector('.applied-gigs');
    const hiredGigs = document.querySelector('.hired-gigs');

    const sections = [
        document.querySelector('.about-me'),
        appliedGigs,
        hiredGigs
    ];

    // About Me
    tabs[0].addEventListener('click', () => {
        sections.forEach(section => section.style.display = 'none');
        tabs.forEach(tab => tab.classList.remove('active'));
        sections[0].style.display = 'block';
        tabs[0].classList.add('active');
    });

    const editAboutMeBtn = document.querySelector('#edit-about-me-btn');
    editAboutMeBtn.addEventListener('click', (e) => {
        if (e.target.innerHTML === 'Edit About Me') {
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'block';
                autoResizeTextarea(textarea);
            });
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelector('#edit-about-me').style.display = 'block';
            editAboutMeBtn.innerHTML = 'Cancel';
            editAboutMeBtn.setAttribute('class', 'text-btn');
            editAboutMeBtn.style.display = 'block';
            editAboutMeBtn.style.margin = '10px auto';
        } else {
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'block';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'none';
            });

            document.querySelector('#edit-about-me').style.display = 'none';
            editAboutMeBtn.innerHTML = 'Edit About Me';
            editAboutMeBtn.setAttribute('class', 'outline-btn');
            editAboutMeBtn.style.margin = '20px 0 0 0';
        }
    });

    const aboutMeForm = document.querySelector('#about-me-form');

    aboutMeForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append(e.submitter.name, true);

        fetch(`./api/handle-student-profile?u=${username}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    aboutMeForm.reset();

                    retrieveAboutMe();

                    document.querySelectorAll('.content').forEach(content => {
                        content.style.display = 'block';
                    });
                    document.querySelectorAll('textarea').forEach(textarea => {
                        textarea.style.display = 'none';
                    });

                    document.querySelector('#edit-about-me').style.display = 'none';
                    editAboutMeBtn.innerHTML = 'Edit About Me';
                    editAboutMeBtn.setAttribute('class', 'outline-btn');
                    editAboutMeBtn.style.margin = '20px 0 0 0';
                }

                aboutMeForm.querySelector('#skills-err').innerHTML = data.errors?.skills_err || '';
            })
            .catch(error => console.error('Error:', error));
    });

    retrieveAboutMe();
    
    function retrieveAboutMe() {
        fetch(`./api/handle-student-profile?u=${username}&get_about_me=true`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);

                if (data.success) {
                    // Skills
                    aboutMeForm.querySelector('#student-skills').innerHTML = data.about_me.skills;
                    aboutMeForm.querySelector('#skills').value = data.about_me.skills;
                    autoResizeTextarea(aboutMeForm.querySelector('#skills'));

                    // Work Experience
                    if (data.about_me.work_exp) {
                        aboutMeForm.querySelector('#work-exp-label').style.display = 'block';
                        aboutMeForm.querySelector('#student-work-exp').innerHTML = data.about_me.work_exp;
                        aboutMeForm.querySelector('#work-exp').value = data.about_me.work_exp;
                    }

                    // Certifications
                    if (data.about_me.certifications) {
                        aboutMeForm.querySelector('#certs-label').style.display = 'block';
                        aboutMeForm.querySelector('#student-certs').innerHTML = data.about_me.certifications;
                        aboutMeForm.querySelector('#certs').value = data.about_me.certifications;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Retrieve gigs of Student

    retrieveStudentGigs();

    function retrieveStudentGigs() {
        fetch(`./api/handle-student-profile?u=${username}&get_gigs=true`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                
                if (data.success) {
                    data.gigs.forEach(gig => {
                        const gigItem = document.createElement('div');
                        gigItem.classList.add('gig-item');
                        
                        gigItem.innerHTML = `
                            <h3 class="gig-title">${gig.title}</h3>
                            
                            <div class="with-actions">
                                <a href="./gig-details?g=${gig.gig_id}">View</a>
                            </div>
                            <div class="with-actions">
                                <button class="outline-btn">Open Message</button>
                            </div>
                            <div class="with-actions">
                                <button>Accept Offer</button>
                            </div>
                        `;

                        if (gig.status === 'hired') {
                            // TODO: hired gigs
                        } else {
                            appliedGigs.appendChild(gigItem);
                        }
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Applied Gigs
    tabs[1].addEventListener('click', () => {
        sections.forEach(section => section.style.display = 'none');
        tabs.forEach(tab => tab.classList.remove('active'));
        sections[1].style.display = 'block';
        tabs[1].classList.add('active');
    });
    
    // Hired Gigs
    tabs[2].addEventListener('click', () => {
        sections.forEach(section => section.style.display = 'none');
        tabs.forEach(tab => tab.classList.remove('active'));
        sections[2].style.display = 'block';
        tabs[2].classList.add('active');
    });

    // AUTO-RESIZE TEXTAREAS
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // GET QUERY PARAMETER
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
</script>

<?php
    include './partials/footer.php';
?>