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
            <input id="profile-image-upload" type="file" accept="image/*">
            <input id="save-profile-image" type="submit" value="Save">
        </form>
        <button id="change-photo-btn" class="text-btn" type="button">Change photo</button>

        <form id="edit-profile-form" method="POST">
            <!-- Student Name -->
            <h3 class="input-label">First name</h3>
            <input type="text" placeholder="Enter first name">
            <p class="input-help"></p>
            
            <h3 class="input-label">Last name</h3>
            <input type="text" placeholder="Enter last name">
            <p class="input-help"></p>
            <h2 class="displayed">Mark Galang</h2>
            
            <!-- University -->
            <h3 class="input-label">University</h3>
            <input type="text" placeholder="Enter university">
            <p class="input-help"></p>
            <p class="displayed">FEU Tech</p>
            
            <!-- Degree -->
            <h3 class="input-label">Degree Program</h3>
            <input type="text" placeholder="Enter degree program">
            <p class="input-help"></p>
            <p class="displayed">Bachelor of Science in Computer Science with Specialization in Software Engineering</p>
            
            <!-- Year Level -->
            <h3 class="input-label">Year Level</h3>
            <input type="text" placeholder="Enter year level">
            <p class="input-help"></p>
            <p class="displayed">(2nd Year)</p>

            <input type="submit" value="Update">
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
            <form method="POST">
                <!-- Skills -->
                <h3 class="input-label">SKILLS</h3>
                <p class="content">Sample skills</p>
                <textarea name="" id="" placeholder="Share your skills to everyone..."></textarea>
                <p class="input-help"></p>
                
                <!-- Work Experience -->
                <h3 class="input-label">WORK EXPERIENCE</h3>
                <p class="content">Sample work experience</p>
                <textarea name="" id="" placeholder="This part is optional :)"></textarea>
                
                <!-- Certifications/Awards -->
                <h3 class="input-label">CERTIFICATIONS/AWARDS</h3>
                <p class="content">Sample certifications or awards</p>
                <textarea name="" id="" placeholder="This part is optional as well :)"></textarea>
                
                <!-- Contact Information -->
                <h3 class="input-label">Contact Information</h3>
                <p class="content">sample@example.com</p>
                <textarea name="" id="" placeholder="Enter contact details"></textarea>
                <p class="input-help"></p>

                <input name="save_about_me" id="save-about-me" type="submit" value="Save">
                <button id="edit-about-me" class="outline-btn" type="button">Edit About Me</button>
            </form>
        </div>

        <div class="applied-gigs">
            <div class="gig-item">
                <h3 class="gig-title">English Tutor</h3>
                <p class="gig-type">Remote</p>
                <p>420 per hour</p>
                <div class="with-actions">
                    <a href="./gig-details?g=">View</a>
                </div>
                <div class="with-actions">
                    <button>Message</button>
                </div>
            </div>
        </div>

        <div class="hired-gigs">
            <div class="gig-item">
                <h3 class="gig-title">English Tutor</h3>
                <p class="gig-type">Remote</p>
                <p>420 per hour</p>
                <div class="with-actions">
                    <a href="./gig-details?g=">View</a>
                </div>
                <div class="with-actions">
                    <button>Message</button>
                </div>
            </div>
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
                console.log(data);
                
                if (data.success) {
                    document.querySelector('#profile-image').src = data.student.profile_image_path || './images/profile-image.png';
                    // editProfileForm.
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
            profileImage.src = './images/profile-image.png';
        }
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
            
            editProfileForm.reset();

            editProfileBtn.innerHTML = 'Edit profile';
        }
    });

    // ========================== MAIN  ==========================
    const tabs = [
        document.querySelector('#about-me-tab'),
        document.querySelector('#applied-gigs-tab'),
        document.querySelector('#hired-gigs-tab')
    ];

    const sections = [
        document.querySelector('.about-me'),
        document.querySelector('.applied-gigs'),
        document.querySelector('.hired-gigs')
    ];

    // About Me
    tabs[0].addEventListener('click', () => {
        sections.forEach(section => section.style.display = 'none');
        tabs.forEach(tab => tab.classList.remove('active'));
        sections[0].style.display = 'block';
        tabs[0].classList.add('active');
    });

    document.querySelector('#edit-about-me').addEventListener('click', (e) => {
        if (e.target.innerHTML === 'Edit About Me') {
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'block';
            });
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelector('#save-about-me').style.display = 'block';
            e.target.innerHTML = 'Cancel';
            e.target.setAttribute('class', 'text-btn');
            e.target.style.display = 'block';
            e.target.style.margin = '10px auto';
        } else {
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'block';
            });
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'none';
            });

            document.querySelector('#save-about-me').style.display = 'none';
            e.target.innerHTML = 'Edit About Me';
            e.target.setAttribute('class', 'outline-btn');
            e.target.style.margin = '20px 0 0 0';
        }
    });
    
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

    // GET QUERY PARAMETER
    function getQueryParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
</script>

<?php
    include './partials/footer.php';
?>