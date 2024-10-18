<?php
    $title = 'Gig Creator Profile';
    $css_file_name = 'profile';
    include './partials/header.php';
?>

<div class="container">
    <div class="left">
        <!-- Profile Image -->
        <img id="profile-image" src="./images/profile-image.png" alt="Profile image">
        <form id="change-photo-form" method="POST">
            <input id="profile-image-upload" type="file" accept="image/*">
            <input id="save-profile-image" type="submit" value="Save">
        </form>
        <button id="change-photo-btn" class="text-btn" type="button">Change photo</button>

        <form id="edit-profile-form" method="POST">
            <!-- Gig Creator Name -->
            <h3 class="input-label">First name</h3>
            <input type="text" placeholder="Enter first name">
            <p class="input-help"></p>
            <h3 class="input-label">Last name</h3>
            <input type="text" placeholder="Enter last name">
            <p class="input-help"></p>
            <h2 class="displayed">Jason Creator</h2>
            
            <!-- Email -->
            <h3 class="input-label">Email</h3>
            <input type="email" placeholder="Enter email">
            <p class="input-help"></p>
            <p class="displayed">jason@example.com</p>

            <!-- Company -->
            <h3 class="input-label">Company</h3>
            <input type="text" placeholder="Enter company (optional)">
            <p class="input-help"></p>
            <p class="displayed">Company</p>

            <input type="submit" value="Update">
        </form>

        <button id="edit-profile-btn" class="text-btn" type="button">Edit profile</button>
    </div>

    <div class="main">
        <ul class="top-nav">
            <li id="active-gigs-tab" class="active">Active Gigs</li>
            <li id="closed-gigs-tab">Closed Gigs</li>
        </ul>

        <div class="active-gigs">
            <a href="./gig-details?g=" class="gig-item">
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
            </a>
        </div>
        
        <div class="closed-gigs">
            <a href="./gig-details?g=" class="gig-item">
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
            </a>
        </div>
    </div>
</div>

<script>
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
</script>

<?php
    include './partials/footer.php';
?>